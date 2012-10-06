<?php

########################################################################
# Extension Manager/Repository config file for ext "cscgallery".
#
# Auto generated 27-08-2012 09:44
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Gallery for CSS_styled_content',
	'description' => '',
	'category' => 'fe',
	'author' => 'Lars Hayer',
	'author_email' => 'typo3@larshayer.com',
	'shy' => '',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '1.1.1',
	'constraints' => array(
		'depends' => array(
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:73:{s:9:"ChangeLog";s:4:"1ccc";s:12:"ext_icon.gif";s:4:"237e";s:17:"ext_localconf.php";s:4:"680f";s:14:"ext_tables.php";s:4:"ee43";s:16:"locallang_db.xml";s:4:"2e6f";s:14:"doc/manual.sxw";s:4:"f2fc";s:31:"pi1/class.tx_cscgallery_pi1.php";s:4:"4b36";s:19:"pi1/flexform_ds.xml";s:4:"e073";s:19:"pi1/flexform_ll.xml";s:4:"4bd4";s:17:"pi1/locallang.xml";s:4:"36c4";s:11:"res/box.png";s:4:"76c5";s:30:"res/jquery.cycle.cscgallery.js";s:4:"b967";s:23:"res/jquery.tools.min.js";s:4:"93e4";s:42:"res/cycle/jquery.cycle.all.2.9999.5.min.js";s:4:"c618";s:26:"res/cycle/jquery.cycle.css";s:4:"1bcf";s:29:"res/cycle/jquery.cycle.min.js";s:4:"dde3";s:34:"res/cycle/images/bg.figcaption.png";s:4:"6a01";s:24:"res/cycle/images/box.gif";s:4:"37ec";s:28:"res/cycle/images/magnify.png";s:4:"049c";s:30:"res/cycle/images/nextlabel.gif";s:4:"485d";s:31:"res/cycle/images/nextlabel2.gif";s:4:"51d8";s:26:"res/cycle/images/pause.gif";s:4:"261d";s:25:"res/cycle/images/play.gif";s:4:"b5f0";s:30:"res/cycle/images/prevlabel.gif";s:4:"d935";s:31:"res/cycle/images/prevlabel2.gif";s:4:"d762";s:37:"res/cycle/images/sb_anchor_spacer.gif";s:4:"df3e";s:34:"res/cycle/images/sb_closelabel.gif";s:4:"0e54";s:31:"res/cycle/images/sb_loading.gif";s:4:"7e99";s:33:"res/cycle/images/sb_nextlabel.gif";s:4:"c443";s:34:"res/cycle/images/sb_nextlabel2.gif";s:4:"4c34";s:29:"res/cycle/images/sb_pause.gif";s:4:"5d10";s:28:"res/cycle/images/sb_prev.gif";s:4:"a130";s:33:"res/cycle/images/sb_prevlabel.gif";s:4:"4d06";s:34:"res/cycle/images/sb_prevlabel2.gif";s:4:"854b";s:33:"res/cycle/images/sb_printicon.gif";s:4:"7a7c";s:32:"res/cycle/images/sb_saveicon.gif";s:4:"9265";s:31:"res/cycle/styles/slimbox_ex.css";s:4:"576e";s:31:"res/cycle/styles/slimbox_pf.css";s:4:"6486";s:22:"res/fancybox/blank.gif";s:4:"3254";s:28:"res/fancybox/fancy_close.png";s:4:"6e28";s:30:"res/fancybox/fancy_loading.png";s:4:"b1d5";s:31:"res/fancybox/fancy_nav_left.png";s:4:"3f3e";s:32:"res/fancybox/fancy_nav_right.png";s:4:"216e";s:31:"res/fancybox/fancy_shadow_e.png";s:4:"fd4f";s:31:"res/fancybox/fancy_shadow_n.png";s:4:"18cd";s:32:"res/fancybox/fancy_shadow_ne.png";s:4:"63ad";s:32:"res/fancybox/fancy_shadow_nw.png";s:4:"c820";s:31:"res/fancybox/fancy_shadow_s.png";s:4:"9b9e";s:32:"res/fancybox/fancy_shadow_se.png";s:4:"a8af";s:32:"res/fancybox/fancy_shadow_sw.png";s:4:"f81c";s:31:"res/fancybox/fancy_shadow_w.png";s:4:"59b0";s:33:"res/fancybox/fancy_title_left.png";s:4:"1582";s:33:"res/fancybox/fancy_title_main.png";s:4:"38da";s:33:"res/fancybox/fancy_title_over.png";s:4:"b886";s:34:"res/fancybox/fancy_title_right.png";s:4:"6cbe";s:27:"res/fancybox/fancybox-x.png";s:4:"1686";s:27:"res/fancybox/fancybox-y.png";s:4:"36a5";s:25:"res/fancybox/fancybox.png";s:4:"11e5";s:38:"res/fancybox/jquery.easing-1.3.pack.js";s:4:"83e5";s:38:"res/fancybox/jquery.fancybox-1.3.0.css";s:4:"9ee5";s:37:"res/fancybox/jquery.fancybox-1.3.0.js";s:4:"d60e";s:42:"res/fancybox/jquery.fancybox-1.3.0.pack.js";s:4:"5c16";s:38:"res/fancybox/jquery.fancybox-1.3.4.css";s:4:"4638";s:37:"res/fancybox/jquery.fancybox-1.3.4.js";s:4:"e7fc";s:42:"res/fancybox/jquery.fancybox-1.3.4.pack.js";s:4:"8bc3";s:38:"res/fancybox/jquery.fancybox-1.3.4.zip";s:4:"f964";s:44:"res/fancybox/jquery.mousewheel-3.0.2.pack.js";s:4:"6ac0";s:44:"res/fancybox/jquery.mousewheel-3.0.4.pack.js";s:4:"3b0a";s:27:"res/fancybox/nextlabel2.gif";s:4:"51d8";s:27:"res/fancybox/prevlabel2.gif";s:4:"d762";s:35:"res/jquery_core/jquery-1.8.0.min.js";s:4:"cd8b";s:31:"static/cscgallery/constants.txt";s:4:"e136";s:27:"static/cscgallery/setup.txt";s:4:"fc08";}',
	'suggests' => array(
	),
);

?>