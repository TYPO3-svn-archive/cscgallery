/** Possible Markers:
 *  UID        [int]
 *  LIGHTBOX   [bool]
 *  HEIGHT     [int]
 *  AUTOSTART  [bool]
 *  TIMEOUT    [int]
 *  CTRLS      [bool]
 *  PAUSE      [bool]
 */

<!-- ###CSCGALLERY_PARTS### begin -->
(function($){
	$(document).ready(function() {
			// add cycle navigation
		var cscGalleryImagewraps = $('#c###UID### .csc-textpic .csc-textpic-imagewrap');
		cscGalleryImagewraps.parent().attr('id', 'gallery-slideshow###UID###').addClass('csc-gallery-slideshow');
		cscGalleryImagewraps.first().attr('id', 'slideshow###UID###');
		cscGalleryImagewraps.last().attr('id', 'nav###UID###').addClass('csc-gallery-nav csc-textpic-text');



			// vars
		var useLightbox###UID###   = ###LIGHTBOX###;
		var largectrls###UID###    = ###CTRLS###;

			// slideshow container
		var $ss###UID###  = $('#slideshow###UID###');

			// add interface prev|next
		if (largectrls###UID###) {
			$ss###UID###.before('<a class="csc-ctrl csc-btn csc-prev" href="">prev</a><a class="csc-ctrl csc-btn csc-next" href="">next</a>');
		} else {
			$ss###UID###.before('<a class="csc-ctrl csc-btn csc-prev hidden" href="">prev</a><a class="csc-ctrl csc-btn csc-next hidden" href="">next</a>');
		}
			// add interface lightbox
		if (largectrls###UID### && !useLightbox###UID###) {
			$ss###UID###.before('<a class="csc-ctrl csc-play no-box" href="">play</a>');
		}
			// add interface play|pause & lightbox
		if (largectrls###UID### && useLightbox###UID###) {
			$ss###UID###.before('<a class="csc-ctrl csc-play" href="">play</a>');
			$ss###UID###.before('<a rel="lightbox###UID###" class="csc-ctrl csc-btn csc-box" id="csc-lightbox-###UID###" href="">box</a>');
		}
			//  fit height:
			//  get max. image height
		var maxSlideshowmageHeight = 0;
		$('#slideshow###UID###').find('img').each(function() {
			maxSlideshowmageHeight = ($(this).height() > maxSlideshowmageHeight) ? $(this).height() : maxSlideshowmageHeight;
		});
		cscGalleryImagewraps.parent().find('a.csc-ctrl').each(function() {
			$(this).css('height', maxSlideshowmageHeight);
		});

			// remove single image from container
		$ss###UID###.empty();

			// build playlist from #nav ul li a
		$('#nav###UID### a').each(function(index) {
				// vars & objs
			var ltbox = $(this).attr('rel');
			var href  = $(this).attr('href');
			var title = $(this).attr('title');
			if (title) {
				title = ' title="'+title+'"';
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
				$ss###UID###.append('<div style="width:100%; height:'+imageHeight+'px;"><a href="'+this.href+'"'+rel+''+title+'><img src="'+ltbox+'" /></a></div>');
			} else {
				$ss###UID###.append('<div style="width:100%; height:'+imageHeight+'px;"><img src="'+ltbox+'" /></div>');
			}
		});

			// configure play/pause btn
		$('.csc-play').click(function() {
			$(this).toggleClass('csc-paused');
			$('.csc-btn').toggleClass('hidden');
			$ss###UID###.cycle('toggle');
			return false;
		}).hover(function () {
			$ss###UID###.cycle('pause');
			$(this).removeClass('csc-paused');
			$('.csc-btn').removeClass('hidden');
		});

			// configure the slideshow
			// Grand parent of image(s):
		var gParentTagName = $('#nav###UID### img').parent('a').parent()[0].tagName;
		$ss###UID###.cycle({
			height            : ###HEIGHT###,
			pauseOnPagerHover : 1,
			timeout           : ###TIMEOUT###,
			speed             : 'fast',
			pause             : ###PAUSE###,
			next              : '.csc-next',
			prev              : '.csc-prev',
			manualTrump       : true,
			pager             : '#nav###UID###',
			pagerAnchorBuilder: function(idx, slide) {
			//	return '#nav###UID### li:eq(' + idx + ') a';
				return '#nav###UID### ' + gParentTagName + ':eq(' + idx + ') a';
			},
			after             : function (curr,next,opts) {
				$('#csc-lightbox-###UID###').attr('alt', opts.currSlide);
			}
		}).cycle('###AUTOSTART###');

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
})(jQuery)
<!-- ###CSCGALLERY_PARTS### end -->