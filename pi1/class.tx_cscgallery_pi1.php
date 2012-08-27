<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Lars Hayer <typo3@larshayer.com>
*  (c) 2012 Ulfried Herrmann <herrmann.at.die-netzmacher.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */

require_once(PATH_tslib.'class.tslib_pibase.php');
	//  checks if t3jquery is loaded
if (t3lib_extMgm::isLoaded('t3jquery')) {
	require_once(t3lib_extMgm::extPath('t3jquery').'class.tx_t3jquery.php');
}

/**
 * Plugin 'Image Gallery' for the 'Gallery for CSS_styled_content' extension.
 *
 * @author	Lars Hayer <typo3@larshayer.com>
 * @author	Ulfried Herrmann <herrmann.at.die-netzmacher.de>
 * @package	TYPO3
 * @subpackage	cscgallery
 */
class tx_cscgallery_pi1 extends tslib_pibase {
	public    $prefixId         = 'tx_cscgallery_pi1';		          // Same as class name
	public    $scriptRelPath    = 'pi1/class.tx_cscgallery_pi1.php';  // Path to this script relative to the extension dir.
	public    $extKey           = 'cscgallery';                       // The extension key.

	protected $includeResources = array(                              // include resources like page.includeCSS.[array]
		'includeCSS',
		'includeJS',
		'includeJSFooter',
	);
	protected $lConf            = array();                            // conf array local used4

	// -------------------------------------------------------------------------
	/**
	 * Main method of the PlugIn
	 *
	 * @param	string		$content: The content of the PlugIn
	 * @param	array		$conf: The PlugIn Configuration
	 * @return	The content that should be displayed on the website
	 */
	function addHeaderData($content, $conf) {
			//  prepare Plugin config
		$this->prepareConfig($conf);

			//  include jQuery core
			//  if t3jquery is loaded and the custom Library had been created
		if (T3JQUERY === true) {
			tx_t3jquery::addJqJS();
		} else {
				// if none of the previous is true, you need to include your own library
			$includeJSlibs = (empty ($this->conf['pathToJquery.']['includeInFooter'])) ? 'includeJSlibs' : 'includeJSFooterlibs';
			$GLOBALS['TSFE']->pSetup[$includeJSlibs . '.'][$this->extKey . 'jQueryCore'] = $this->conf['pathToJquery'];
		}

			//  include cycle + lightbox
			//  works like page.includeCSS.[array]
			//  @see http://blog.joergboesche.de/typo3-extension-spezifische-css-datei-laden
		foreach ($this->includeResources as $resVal) {
			if (is_array($this->conf[$resVal . '.']) AND count($this->conf[$resVal . '.']) > 0) {
				foreach ($this->conf[$resVal . '.'] as $cssKey => $cssVal) {
					$GLOBALS['TSFE']->pSetup[$resVal . '.'][$this->extKey . $cssKey] = $cssVal;
					if (isset ($this->conf[$resVal . '.'][$cssKey . '.'])) {
						$GLOBALS['TSFE']->pSetup[$resVal . '.'][$this->extKey . $cssKey . '.'] = $this->conf['includeCSS.'][$cssKey . '.'];
					}
				}
			}
		}

			//  include gallery configuration
		$templateCode = $this->cObj->fileResource($this->conf['templateFile']);
		$jsConf = $this->cObj->getSubpart($templateCode, '###CSCGALLERY_PARTS###');
		if ($jsConf) {
			$cscGalleryConf =& $GLOBALS['TSFE']->tmpl->setup['tt_content.']['cscgallery_pi1.'];
			$markerArray = array(
				'###UID###'        => $this->cObj->data['uid'],
				'###LIGHTBOX###'   => $this->conf['useLightbox'],
				'###HEIGHT###'     => $this->conf['singleheight'],
				'###AUTOSTART###'  => $this->conf['autostart'],
				'###TIMEOUT###'    => $this->conf['timeout'],
				'###CTRLS###'      => $this->conf['largectrls'],
				'###PAUSE###'      => $this->conf['pause'],
				'###SHOWTITLE###'  => $this->conf['showtitle'],

			##	'###COLSPACE###'   => $cscGalleryConf['20.']['colSpace'],
				'###ROWSPACE###'   => $cscGalleryConf['20.']['rowSpace'],
			##	'###TEXTMARGIN###' => $cscGalleryConf['20.']['textMargin'],
			);
			$jsConf = $this->cObj->substituteMarkerArray($jsConf, $markerArray);

				//  @see http://sigi-schweizer.de/blog/2009/01/30/inline-javascript-und-css-typo3-extensions/
			$inline2Tmpfile = TSpagegen::inline2TempFile($jsConf, 'js');
			$jsInline = (empty ($this->conf['templateFile.']['includeInFooter'])) ? 'includeJS' : 'includeJSFooter';
			$GLOBALS['TSFE']->pSetup[$jsInline . '.'][$this->extKey . 'inline' . $this->cObj->data['uid']] = $inline2Tmpfile;
		}
	}


	// -------------------------------------------------------------------------
	/**
	 * prepare plugin config
	 *
	 * @param	array		$conf: The PlugIn Configuration
	 * @return	void
	 * @version 1.0.0
	 */
	protected function prepareConfig(&$conf) {
		$this->conf = $conf;
		$this->pi_initPIflexForm();
		$piFlexForm = $this->cObj->data['pi_flexform'];

		foreach ($piFlexForm['data'] as $sheet => $data) {
			foreach ($data as $lang => $value) {
				foreach ($value as $key => $val) {
					$ffVal = $this->pi_getFFvalue($piFlexForm, $key, $sheet);
					if ($ffVal != -1) {
						$this->lConf[$key] = $ffVal;
					}
				}
			}
		}

		if ($this->cObj->data['image_zoom']) {
			$this->conf['useLightbox'] = 1;
		}
		if ($this->cObj->data['imageheight']) {
			$this->conf['singleheight'] = $this->cObj->data['imageheight'];
		}

		if (isset ($this->lConf['largectrls'])) {
			$this->conf['largectrls'] = $this->lConf['largectrls'];
		}
		if (isset ($this->lConf['showtitle'])) {
			$this->conf['showtitle'] = $this->lConf['showtitle'];
		}
		if (!empty ($this->conf['cyclespeed'])) {
			$this->conf['timeout'] = $this->conf['cyclespeed'];
		}
		if (!empty ($this->lConf['cyclespeed'])) {
			$this->conf['timeout'] = $this->lConf['cyclespeed'];
		}
		if ($this->conf['largectrls']) {
			$this->conf['pause'] = 0;
		}
		if (!empty ($this->lConf['autostart'])) {
			$this->conf['autostart'] = 'resume';
		}
		if (isset ($this->lConf['singleViewOnly'])) {
			$GLOBALS['TSFE']->register['singleViewOnly'] = 'hidden';
		}
		if (!empty ($this->lConf['thumbwidth'])) {
			$GLOBALS['TSFE']->register['thumbwidth'] = $this->lConf['thumbwidth'];
		}
		if (!empty ($this->lConf['thumbheight'])) {
			$GLOBALS['TSFE']->register['thumbheight'] = $this->lConf['thumbheight'];
		}
		if (!empty ($this->lConf['cropscaling'])) {
			$GLOBALS['TSFE']->register['cropscaling'] = $this->lConf['cropscaling'];
		}
/*
echo '<pre><b>$this->lConf @ ' . __FILE__ . '::' . __LINE__ . ':</b> ' . print_r($this->lConf, 1) . '</pre>';
echo '<pre><b>$this->conf @ ' . __FILE__ . '::' . __LINE__ . ':</b> ' . print_r($this->conf, 1) . '</pre>';
echo '<pre><b>$GLOBALS[TSFE]->register @ ' . __FILE__ . '::' . __LINE__ . ':</b> ' . htmlspecialchars(print_r($GLOBALS['TSFE']->register, 1)) . '</pre>';
exit;
*/
	}


	// -------------------------------------------------------------------------
	/**
	 * Replaces 'EXT:' in path
	 *
	 * @param	string    $path: path from configuration
	 * @return	string    path
	 * @version 0.0.1
	 */
	function getPath($path) {
		if (substr($path, 0, 4) == 'EXT:') {
			$keyEndPos = strpos($path, '/', 6);
			$key       = substr($path, 4, $keyEndPos - 4);
			$keyPath   = t3lib_extMgm::siteRelpath($key);
			$newPath   = $keyPath . substr($path, $keyEndPos + 1);
			return $newPath;
		}	else {
			return $path;
		}
	}
}
?>