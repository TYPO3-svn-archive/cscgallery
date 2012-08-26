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
			$_EXTKEY . '_pi1',
			'i/tt_content_image.gif',
		);
	}
		//  add all present items
	$ttcCTypeItems[] = $iVal;
}
	//  replace present items array by extended array
$TCA['tt_content']['columns']['CType']['config']['items'] = $ttcCTypeItems;



/**
 * Configure plugin / BE form
 */
	//  copy configuration from CType 'image'
$TCA['tt_content']['ctrl']['typeicons'][$_EXTKEY . '_pi1']          = $TCA['tt_content']['ctrl']['typeicons']['image'];
$TCA['tt_content']['ctrl']['typeicon_classes'][$_EXTKEY . '_pi1']   = $TCA['tt_content']['ctrl']['typeicon_classes']['image'];
$TCA['tt_content']['types'][$_EXTKEY . '_pi1']['showitem']          = $TCA['tt_content']['types']['image']['showitem'];
	//  add flexform
t3lib_extMgm::addPiFlexFormValue('*', 'FILE:EXT:' . $_EXTKEY . '/pi1/flexform_ds.xml', $_EXTKEY . '_pi1');
t3lib_extMgm::addToAllTCAtypes('tt_content', 'pi_flexform', $_EXTKEY . '_pi1', 'after:imagecaption_position');
	//  remove image altText, titleText, longdescURL
	//  @ToDo: do it for TYPO3 6.0
$pattern = '%--palette--;LLL:EXT:cms/locallang_ttc\.xml:palette.image_accessibility;image_accessibility\,%';
$TCA['tt_content']['types']['cscgallery_pi1']['showitem']           = preg_replace($pattern, '', $TCA['tt_content']['types']['cscgallery_pi1']['showitem']);
	//  remove image_link
$TCA['tt_content']['palettes'][$_EXTKEY . '_imagezoom'] = $TCA['tt_content']['palettes']['imagelinks'];
$pattern = '%\, image_link;LLL:EXT:cms/locallang_ttc\.xml:image_link_formlabel%';
$TCA['tt_content']['palettes'][$_EXTKEY . '_imagezoom']['showitem'] = preg_replace($pattern, '', $TCA['tt_content']['palettes'][$_EXTKEY . '_imagezoom']['showitem']);
$pattern = '%--palette--;LLL:EXT:cms/locallang_ttc.xml:palette\.imagelinks;imagelinks%';
$replacement = '--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.imagelinks;' . $_EXTKEY . '_imagezoom';
$TCA['tt_content']['types']['cscgallery_pi1']['showitem']           = preg_replace($pattern, $replacement, $TCA['tt_content']['types']['cscgallery_pi1']['showitem']);


/**
 * Add TypoScript
 */
t3lib_extMgm::addStaticFile($_EXTKEY, 'static/cscgallery/', 'Gallery for CSC');
?>