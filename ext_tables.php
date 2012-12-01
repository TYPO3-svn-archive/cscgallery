<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

require_once t3lib_extMgm::extPath($_EXTKEY, $script = 'lib/class.tx_scsgallery_tcahelper.php');


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
	//  remove image_link: change palette 'imagelinks' with 'cscgallery_imagezoom'
$TCA['tt_content']['palettes'][$_EXTKEY . '_imagezoom'] = array(
	'canNotCollapse' => 1,
	'showitem'       => 'image_zoom;LLL:EXT:cms/locallang_ttc.xml:image_zoom_formlabel',
);
$pattern = '%--palette--;LLL:EXT:cms/locallang_ttc.xml:palette\.imagelinks;imagelinks%';
$replacement = '--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.imagelinks;' . $_EXTKEY . '_imagezoom';
$TCA['tt_content']['types']['cscgallery_pi1']['showitem']           = preg_replace($pattern, $replacement, $TCA['tt_content']['types']['cscgallery_pi1']['showitem']);

/**
 * Add TypoScript
 */
t3lib_extMgm::addStaticFile($_EXTKEY, 'static/cscgallery/',          'Gallery for CSC');




/**
 * Add Gallery to Organiser News
 */
if (t3lib_extMgm::isLoaded('org')) {
t3lib_div::loadTCA('tx_org_news');
	//  add type item
$TCA['tx_org_news']['ctrl']['typeicons']['newsgallery'] = t3lib_extMgm::extRelPath($_EXTKEY) . 'res/ico/newsgallery.gif';
$TCA['tx_org_news']['columns']['type']['config']['items']['newsgallery'] = array(
	0 => 'LLL:EXT:' . $_EXTKEY . '/locallang_db.xml:tx_org_news.type.newsgallery',
	1 => 'newsgallery',
	2 => 'EXT:' . $_EXTKEY . '/res/ico/newsgallery.gif',
);
$TCA['tx_org_news']['types']['newsgallery']['showitem'] = $TCA['tx_org_news']['types']['news']['showitem'];
##	$TCA['tx_org_news']['types']['newsgallery']['showitem'] = tx_scsgallery_tcahelper::TCAremoveFromShowitem('bodytext', $TCA['tx_org_news']['types']['newsgallery']['showitem']);
	$TCA['tx_org_news']['types']['newsgallery']['showitem'] = tx_scsgallery_tcahelper::TCAremoveFromShowitem('teaser_short', $TCA['tx_org_news']['types']['newsgallery']['showitem']);
	$TCA['tx_org_news']['types']['newsgallery']['showitem'] = tx_scsgallery_tcahelper::TCAremoveFromShowitem('--palette--;LLL:EXT:cms/locallang_ttc.xml:media;documents_upload', $TCA['tx_org_news']['types']['newsgallery']['showitem']);
	$TCA['tx_org_news']['types']['newsgallery']['showitem'] = tx_scsgallery_tcahelper::TCAremoveFromShowitem('--palette--;LLL:EXT:org/locallang_db.xml:palette.appearance', $TCA['tx_org_news']['types']['newsgallery']['showitem']);
	$TCA['tx_org_news']['types']['newsgallery']['showitem'] = tx_scsgallery_tcahelper::TCAremoveFromShowitem('embeddedcode', $TCA['tx_org_news']['types']['newsgallery']['showitem']);

	/**
	 * Add TypoScript
	 */
t3lib_extMgm::addStaticFile($_EXTKEY, 'static/cscgallery_org_news/', 'Gallery for Organiser News');
}
?>