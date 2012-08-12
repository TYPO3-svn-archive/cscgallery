<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
/*
$tempColumns = array (
    'tx_dg_gallery' => array (        
        'exclude' => 0,        
        'label' => 'Alternative single view images',        
        'config' => array (
            'type' => 'flex',
            'ds' => array (
                'default' => 'FILE:EXT:lh_gallery/pi1/flexform_ds.xml',
            ),
        )
    ),
);



t3lib_div::loadTCA('tt_content');
t3lib_extMgm::addTCAcolumns('tt_content',$tempColumns,1);
*/

	//  uherrmann, 2012-01-13: defining this array here disables all modification by other extensions or core updates
##$TCA['tt_content']['columns']['CType']['config']['items'] = Array (
##					array('LLL:EXT:cms/locallang_ttc.xml:CType.div.standard', '--div--'),
##					array('LLL:EXT:cms/locallang_ttc.xml:CType.I.0', 'header', 'i/tt_content_header.gif'),
##					array('LLL:EXT:cms/locallang_ttc.xml:CType.I.1', 'text', 'i/tt_content.gif'),
##					array('LLL:EXT:cms/locallang_ttc.xml:CType.I.2', 'textpic', 'i/tt_content_textpic.gif'),
##					array('LLL:EXT:cms/locallang_ttc.xml:CType.I.3', 'image', 'i/tt_content_image.gif'),
##					array('Image gallery', 'gallery', 'i/tt_content_textpic.gif'),
##					array('LLL:EXT:cms/locallang_ttc.xml:CType.div.lists', '--div--'),
##					array('LLL:EXT:cms/locallang_ttc.xml:CType.I.4', 'bullets', 'i/tt_content_bullets.gif'),
##					array('LLL:EXT:cms/locallang_ttc.xml:CType.I.5', 'table', 'i/tt_content_table.gif'),
##					array('LLL:EXT:cms/locallang_ttc.xml:CType.I.6', 'uploads', 'i/tt_content_uploads.gif'),
##					array('LLL:EXT:cms/locallang_ttc.xml:CType.div.forms', '--div--'),
##					array('LLL:EXT:cms/locallang_ttc.xml:CType.I.8', 'mailform', 'i/tt_content_form.gif'),
##					array('LLL:EXT:cms/locallang_ttc.xml:CType.I.9', 'search', 'i/tt_content_search.gif'),
##					array('LLL:EXT:cms/locallang_ttc.xml:CType.I.10', 'login', 'i/tt_content_login.gif'),
##					array('LLL:EXT:cms/locallang_ttc.xml:CType.div.special', '--div--'),
##					array('LLL:EXT:cms/locallang_ttc.xml:CType.I.7', 'multimedia', 'i/tt_content_mm.gif'),
##					array('LLL:EXT:cms/locallang_ttc.xml:CType.I.11', 'splash', 'i/tt_content_news.gif'),
##					array('LLL:EXT:cms/locallang_ttc.xml:CType.I.12', 'menu', 'i/tt_content_menu.gif'),
##					array('LLL:EXT:cms/locallang_ttc.xml:CType.I.13', 'shortcut', 'i/tt_content_shortcut.gif'),
##					array('LLL:EXT:cms/locallang_ttc.xml:CType.I.14', 'list', 'i/tt_content_list.gif'),
##					array('LLL:EXT:cms/locallang_ttc.xml:CType.I.15', 'script', 'i/tt_content_script.gif'),
##					array('LLL:EXT:cms/locallang_ttc.xml:CType.I.16', 'div', 'i/tt_content_div.gif'),
##					array('LLL:EXT:cms/locallang_ttc.xml:CType.I.17', 'html', 'i/tt_content_html.gif')
##				);
	//  temporary array
$ttcCTypeItems = array();
	//  loop through present items
foreach ($TCA['tt_content']['columns']['CType']['config']['items'] as $iVal) {
	if (preg_match('/CType\.div\.lists$/', $iVal[0])) {
			//  add image gallery before div.lists
		$ttcCTypeItems[] = array('Image gallery', 'gallery', 'i/tt_content_textpic.gif');
	}
		//  add all present items
	$ttcCTypeItems[] = $iVal;
}
	//  replace present items array by extended array
$TCA['tt_content']['columns']['CType']['config']['items'] = $ttcCTypeItems;

/*
$GLOBALS['TCA']['tt_content']['types']['gallery']['showitem'] = 'CType;;4;;1-1-1, hidden, header;;3;;2-2-2, linkToTop;;;;3-3-3,
							--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.text, bodytext;;9;richtext:rte_transform[flag=rte_enabled|mode=ts_css];3-3-3, rte_enabled, text_properties,
							--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.media, image;;;;5-5-5, imageorient;;2,
							--palette--;LLL:EXT:cms/locallang_ttc.php:ALT.imgDimensions;13, tx_dg_gallery;;;;5-5-5,
							--palette--;LLL:EXT:cms/locallang_ttc.php:ALT.imgLinks;7;;6-6-6,
							imagecaption;;5,altText;;;;7-7-7, titleText, longdescURL,
							--palette--;LLL:EXT:cms/locallang_ttc.php:ALT.imgOptions;11;;8-8-8,
							--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access, starttime, endtime';
*/

t3lib_extMgm::addPiFlexFormValue('*', 'FILE:EXT:cscgallery/pi1/flexform_ds.xml','gallery');
$TCA['tt_content']['types']['gallery']['showitem']='
              CType;;4;;1-1-1, hidden, header;;3;;2-2-2, linkToTop;;;;3-3-3,
							--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.media, image;;;;5-5-5, imageorient;;2,
							--palette--;LLL:EXT:cms/locallang_ttc.php:ALT.imgDimensions;13, pi_flexform;;;;5-5-5,
							--palette--;LLL:EXT:cms/locallang_ttc.php:ALT.imgLinks;7;;6-6-6, imagecaption;;5,altText;;;;7-7-7, titleText, longdescURL,
							--palette--;LLL:EXT:cms/locallang_ttc.php:ALT.imgOptions;11;;8-8-8,
							--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access, starttime, endtime';
//S$TCA['tt_content']['palettes']['3']['showitem'] = 'imagecols, image_noRows, imageborder';
t3lib_extMgm::addStaticFile($_EXTKEY,'static/cscgallery/', 'Gallery for CSC');
// 							--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.text, bodytext;;9;richtext:rte_transform[flag=rte_enabled|mode=ts_css];3-3-3, rte_enabled, text_properties,
?>
