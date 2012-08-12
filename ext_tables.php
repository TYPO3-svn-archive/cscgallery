<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}



/**
 * Add plugin
 */
t3lib_div::loadTCA('tt_content');
	//  temporary array
$ttcCTypeItems = array();
	//  loop through present items
foreach ($TCA['tt_content']['columns']['CType']['config']['items'] as $iVal) {
	if (preg_match('/CType\.div\.lists$/', $iVal[0])) {
			//  add image gallery before div.lists
		$ttcCTypeItems[] = array(
			'LLL:EXT:' . $_EXTKEY . '/locallang_db.xml:tt_content.CType_pi1',
			'gallery',
			'i/tt_content_image.gif',
		);
	}
		//  add all present items
	$ttcCTypeItems[] = $iVal;
}
	//  replace present items array by extended array
$TCA['tt_content']['columns']['CType']['config']['items'] = $ttcCTypeItems;
##t3lib_extMgm::addPItoST43('gallery', 'pi1/class.tx_cscgallery_pi1.php', '_pi1', 'CType', 1);



/**
 * Configure plugin / BE form
 */
	//  copy configuration from CType 'image'
$TCA['tt_content']['types']['gallery']['showitem'] = $TCA['tt_content']['types']['image']['showitem'];
	//  add
t3lib_extMgm::addPiFlexFormValue('*', 'FILE:EXT:' . $_EXTKEY . '/pi1/flexform_ds.xml', 'gallery');
t3lib_extMgm::addToAllTCAtypes('tt_content', 'pi_flexform', 'gallery', 'after:imagecaption_position');


/**
 * Add TypoScript
 */
t3lib_extMgm::addStaticFile($_EXTKEY, 'static/cscgallery/', 'Gallery for CSC');
?>
