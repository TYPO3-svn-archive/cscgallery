/** Possible Markers:
 *  UID        [int]
 *  LIGHTBOX   [bool]
 *  HEIGHT     [int]
 *  AUTOSTART  [bool]
 *  TIMEOUT    [int]
 *  CTRLS      [bool]
 *  PAUSE      [bool]
 *  SHOWTITLE  [bool]
 *  ROWSPACE   [int]
 */

<!-- ###CSCGALLERY_PARTS### begin -->
jQuery(function($){
	$(document).ready(function() {
			// Add classes and ids
		var cscGalleryImageOuterWrap = $('#c###UID### .csc-textpic');
		var cscGalleryImageInnerWrap = $('#c###UID### .csc-textpic .csc-textpic-imagewrap');
		cscGalleryImageOuterWrap.attr('id', 'gallery-slideshow###UID###').addClass('csc-gallery-slideshow');
		if (cscGalleryImageOuterWrap.hasClass('csc-textpic-below')) {
			cscGalleryImageInnerWrap.first().attr('id', 'nav###UID###').addClass('csc-gallery-nav csc-textpic-text');
			cscGalleryImageInnerWrap.last().attr('id', 'slideshow###UID###').addClass('csc-gallery-slideshow-single');
		} else {
			cscGalleryImageInnerWrap.first().attr('id', 'slideshow###UID###').addClass('csc-gallery-slideshow-single');
			cscGalleryImageInnerWrap.last().attr('id', 'nav###UID###').addClass('csc-gallery-nav csc-textpic-text');
		}


			// vars
		var useLightbox###UID###   = ###LIGHTBOX###;
		var largectrls###UID###    = ###CTRLS###;
			// slideshow container
		var $ss###UID###           = $('#slideshow###UID###');

			//  fit height:
			//  get max. image height
		var maxSlideshowImageHeight = 0;
		var maxSlideshowImageWidth  = 0;
		$ss###UID###.find('img').each(function() {
			maxSlideshowImageHeight = ($(this).height() > maxSlideshowImageHeight) ? $(this).height() : maxSlideshowImageHeight;
			maxSlideshowImageWidth  = ($(this).width()  > maxSlideshowImageWidth)  ? $(this).width()  : maxSlideshowImageWidth;
		});
	//	cscGalleryImageInnerWrap.parent().find('a.csc-ctrl').each(function() {
	//		$(this).css('height', maxSlideshowImageHeight);
	//	});


			// add interface prev|next
		$('#gallery-slideshow###UID###').prepend('<div class="csc-ctrl-wrap" style="height: ' + maxSlideshowImageHeight + 'px; width: ' + maxSlideshowImageWidth + 'px;"></div>');
		$ss###UID###Wrap = $('#gallery-slideshow###UID### .csc-ctrl-wrap');
		if (largectrls###UID###) {
			$ss###UID###Wrap.append('<a class="csc-ctrl csc-btn csc-prev" href="#">prev</a><a class="csc-ctrl csc-btn csc-next" href="#">next</a>');
		} else {
			$ss###UID###Wrap.append('<a class="csc-ctrl csc-btn csc-prev hidden" href="#">prev</a><a class="csc-ctrl csc-btn csc-next hidden" href="#">next</a>');
		}
			// add interface lightbox
		if (largectrls###UID### && !useLightbox###UID###) {
			$ss###UID###Wrap.append('<a class="csc-ctrl csc-play no-box" href="#">play</a>');
		}
			// add interface play|pause & lightbox
		if (largectrls###UID### && useLightbox###UID###) {
			$ss###UID###Wrap.append('<a class="csc-ctrl csc-play" href="#">play</a>');
			$ss###UID###Wrap.append('<a rel="lightbox###UID###" class="csc-ctrl csc-btn csc-box" id="csc-lightbox-###UID###" href="#">box</a>');
		}


			// remove single image from container
			// add css style (margin) due to csc settings
		$ss###UID###.empty().css({
			'height': maxSlideshowImageHeight + 'px',
			'width':  maxSlideshowImageWidth + 'px',
		});
		$('.csc-textpic-above #slideshow###UID###').css({
			'margin': '0 0 ###ROWSPACE###px',
		});
		$('.csc-textpic-below #slideshow###UID###').css({
			'margin': '###ROWSPACE###px 0 0',
		});


			// build playlist from #nav ul li a
		$('#nav###UID### a').each(function(index) {
				// vars & objs
			var ltbox   = $(this).attr('rel');
			var href    = $(this).attr('href');
			var title   = $(this).attr('title');
			var ssTitle = '';
			if (title) {
					// for slide show image caption (from title)
				var ssTitle = title;
					// lightbox title
				title = ' title="' + title + '"';
			} else {
			}
			var imageHeight = '';
			var rel = '';
			var img = new Image();

				// get img attr
			$(img).attr('src', ltbox);
			imageHeight = $(img).attr('height');

				// check for urls
			if (href.substr(0,7)=='http://') {
				rel = ' rel="lightbox###UID###" class="iframe"';
			} else {
				rel = ' rel="lightbox###UID###"';
			};

				// enable <a>-wrapping for lightbox
			if (useLightbox###UID###) {
				$ss###UID###.append('<div class="slideshow-item slideshow-item' + index + '" height:' + imageHeight + 'px;"><a href="' + this.href + '"' + rel + '' + title + '><img src="' + ltbox + '" /></a></div>');
			} else {
				$ss###UID###.append('<div class="slideshow-item slideshow-item' + index + '" height:' + imageHeight + 'px;"><img src="' + ltbox + '" /></div>');
			}
			if (ssTitle != '') {
					// slide show image caption (from title)
				$('#slideshow###UID### .slideshow-item' + index).prepend('<div class="image-caption">' + ssTitle + '</div>');
			}
		});


			// configure play/pause btn
		$('#gallery-slideshow###UID### .csc-play').click(function() {
			$(this).toggleClass('csc-paused');
			$('#gallery-slideshow###UID### .csc-btn').toggleClass('hidden');
			$ss###UID###.cycle('toggle');
			return false;
		}).hover(function () {
		//	$ss###UID###.cycle('pause');
		//	$(this).removeClass('csc-paused');
			$('#gallery-slideshow###UID### .csc-btn').removeClass('hidden');
		});

			// configure the slideshow
			// Grand parent of image(s):
		var gParentTagName = $('#nav###UID### img').parent('a').parent()[0].tagName;
			// Slide show autostart state
		var slideShowAutostart = '###AUTOSTART###';
		$ss###UID###.cycle({
			height            : '###HEIGHT###',
			pauseOnPagerHover : 1,
			timeout           : ###TIMEOUT###,
			speed             : 'fast',
			pause             : ###PAUSE###,
			next              : '#gallery-slideshow###UID### .csc-next',
			prev              : '#gallery-slideshow###UID### .csc-prev',
			manualTrump       : true,
			pager             : '#nav###UID###',
			pagerAnchorBuilder: function(idx, slide) {
			//	return '#nav###UID### li:eq(' + idx + ') a';
				return '#nav###UID### ' + gParentTagName + ':eq(' + idx + ') a';
			},
			after             : function (curr,next,opts) {
				$('#csc-lightbox-###UID###').attr('alt', opts.currSlide);
			}
		}).cycle(slideShowAutostart);
		if (slideShowAutostart == 'resume') {
				// play button active
			$('#gallery-slideshow###UID### .csc-play').addClass('csc-paused');
		}

			// add keyboard functionality
		$(document).keydown(function(e){
			//alert (e.which);
			if (e.which == 37 || e.which == 80) {
				$('.csc-prev').click();
			} else if (e.which == 39 || e.which == 78) {
				$('.csc-next').click();
			} else if (e.which == 32) {
				$('.csc-play').click();
			} else {
				return;
			}
		});

			// work around: add first image link to lightbox
		var firstImageUrl = $('#slideshow###UID### img').first().parent('a').attr('href');
		$('a#csc-lightbox-###UID###').attr('href', firstImageUrl);
			// init lightbox
		$lbox###UID### = $("#slideshow###UID### a").fancybox({
			cyclic          : 1,
			overlayOpacity  : 0.9,
			overlayColor    : '#000',
			swf             : {
				wmode : 'transparent',
				allowfullscreen : 'true'
			},
			titleShow: ###SHOWTITLE###,
			//showCloseButton	: false,
			titlePosition 		: 'inside',
			//titleFormat		: formatTitle,
			onComplete	:	function() {
				$("#fancybox-wrap").hover(function() {
					$("#fancybox-title").show();
				}, function() {
					$("#fancybox-title").hide();
				});
			}
		});

			// bind lightbox-click to #box-btn
		$("a#csc-lightbox-###UID###").click(function(){
			$lbox###UID###.eq($(this).attr('alt')).trigger('click');
			$ss###UID###.cycle('pause');
			$('.csc-play').removeClass('csc-paused');
			return false;
		});
	});
});
<!-- ###CSCGALLERY_PARTS### end -->