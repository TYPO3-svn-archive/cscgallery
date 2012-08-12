<?php
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}



$_EXTCONF = unserialize($_EXTCONF); // unserializing the configuration so we can use it here:

if ($_EXTCONF['removePositionTypes'] || !$_EXTCONF) {
	t3lib_extMgm::addPageTSConfig('
		TCEFORM.tt_content.imageorient.types.gallery.removeItems = 17,18
	#	TCEFORM.tt_content.imageorient.types.gallery.altLabels.25 = Beside, right
	#	TCEFORM.tt_content.imageorient.types.gallery.altLabels.26 = Beside, left
		TCEFORM.tt_content.imagecols.types.gallery.addItems.9 = 9
		TCEFORM.tt_content.imagecols.types.gallery.addItems.10 = 10
		TCEFORM.tt_content.imagecols.types.gallery.addItems.11 = 11
		TCEFORM.tt_content.imagecols.types.gallery.addItems.12 = 12
		TCEFORM.tt_content.imagecols.types.gallery.addItems.13 = 13
		TCEFORM.tt_content.imagecols.types.gallery.addItems.14 = 14
		TCEFORM.tt_content.imagecols.types.gallery.addItems.15 = 15
		TCEFORM.tt_content.imagecols.types.gallery.addItems.16 = 16
		TCEFORM.tt_content.imagecols.types.gallery.addItems.20 = 20
		TCEFORM.tt_content.imagecols.types.gallery.addItems.24 = 24
		TCEFORM.tt_content.imagecols.types.gallery.addItems.32 = 32
	');
/*
	t3lib_extMgm::addPageTSConfig('
		TCEFORM.tt_content.imageorient.types.' . $_EXTKEY . '.removeItems = 17,18
		TCEFORM.tt_content.imageorient.types.' . $_EXTKEY . '.altLabels.25 = Beside, right
		TCEFORM.tt_content.imageorient.types.' . $_EXTKEY . '.altLabels.26 = Beside, left
		TCEFORM.tt_content.imagecols.types.' . $_EXTKEY . '.addItems.9 = 9
		TCEFORM.tt_content.imagecols.types.' . $_EXTKEY . '.addItems.10 = 10
		TCEFORM.tt_content.imagecols.types.' . $_EXTKEY . '.addItems.11 = 11
		TCEFORM.tt_content.imagecols.types.' . $_EXTKEY . '.addItems.12 = 12
		TCEFORM.tt_content.imagecols.types.' . $_EXTKEY . '.addItems.13 = 13
		TCEFORM.tt_content.imagecols.types.' . $_EXTKEY . '.addItems.14 = 14
		TCEFORM.tt_content.imagecols.types.' . $_EXTKEY . '.addItems.15 = 15
		TCEFORM.tt_content.imagecols.types.' . $_EXTKEY . '.addItems.16 = 16
		TCEFORM.tt_content.imagecols.types.' . $_EXTKEY . '.addItems.20 = 20
		TCEFORM.tt_content.imagecols.types.' . $_EXTKEY . '.addItems.24 = 24
		TCEFORM.tt_content.imagecols.types.' . $_EXTKEY . '.addItems.32 = 32
*/
	');
}
?>