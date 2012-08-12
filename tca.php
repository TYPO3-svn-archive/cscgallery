<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_lhgallery_images'] = array (
	'ctrl' => $TCA['tx_lhgallery_images']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'image'
	),
	'feInterface' => $TCA['tx_lhgallery_images']['feInterface'],
	'columns' => array (
		'image' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:lh_gallery/locallang_db.xml:tx_lhgallery_images.image',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => 'gif,png,jpeg,jpg',	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_lhgallery',
				'show_thumbs' => 1,	
				'size' => 5,	
				'minitems' => 0,
				'maxitems' => 100,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'image;;;;1-1-1')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>