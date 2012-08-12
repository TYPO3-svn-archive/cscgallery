<?php
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}



$_EXTCONF = unserialize($_EXTCONF); // unserializing the configuration so we can use it here:

if ($_EXTCONF['removePositionTypes'] || !$_EXTCONF) {
	t3lib_extMgm::addPageTSConfig('
		TCEFORM.tt_content.imageorient.types.' . $_EXTKEY . '_pi1.removeItems = 17,18
		TCEFORM.tt_content.imageorient.types.' . $_EXTKEY . '_pi1.altLabels.25 = LLL:EXT:' . $_EXTKEY . '/locallang_db.xml:tt_content.imageorient.25
		TCEFORM.tt_content.imageorient.types.' . $_EXTKEY . '_pi1.altLabels.26 = LLL:EXT:' . $_EXTKEY . '/locallang_db.xml:tt_content.imageorient.26
		TCEFORM.tt_content.imagecols.types.' . $_EXTKEY . '_pi1.addItems.9 = 9
		TCEFORM.tt_content.imagecols.types.' . $_EXTKEY . '_pi1.addItems.10 = 10
		TCEFORM.tt_content.imagecols.types.' . $_EXTKEY . '_pi1.addItems.11 = 11
		TCEFORM.tt_content.imagecols.types.' . $_EXTKEY . '_pi1.addItems.12 = 12
		TCEFORM.tt_content.imagecols.types.' . $_EXTKEY . '_pi1.addItems.13 = 13
		TCEFORM.tt_content.imagecols.types.' . $_EXTKEY . '_pi1.addItems.14 = 14
		TCEFORM.tt_content.imagecols.types.' . $_EXTKEY . '_pi1.addItems.15 = 15
		TCEFORM.tt_content.imagecols.types.' . $_EXTKEY . '_pi1.addItems.16 = 16
		TCEFORM.tt_content.imagecols.types.' . $_EXTKEY . '_pi1.addItems.20 = 20
		TCEFORM.tt_content.imagecols.types.' . $_EXTKEY . '_pi1.addItems.24 = 24
		TCEFORM.tt_content.imagecols.types.' . $_EXTKEY . '_pi1.addItems.32 = 32
	');
}
?>