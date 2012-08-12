<?php
/*
 @ToDo: uherrmann, 2012-07-07
		replace
			$GLOBALS['TSFE']->additionalHeaderData
		by
			$GLOBALS['TSFE']->additionalFooterData
		see http://www.traum-projekt.com/forum/112-typo3/128841-includejsfooter.html
*/

require_once(PATH_tslib.'class.tslib_pibase.php');

// checks if t3jquery is loaded
if (t3lib_extMgm::isLoaded('t3jquery')) {
    require_once(t3lib_extMgm::extPath('t3jquery').'class.tx_t3jquery.php');
}

class tx_cscgallery_pi1 extends tslib_pibase {

	var $prefixId      = 'tx_cscgallery';		// Same as class name
	var $scriptRelPath = 'scripts/class.tx_cscgallery.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'cscgallery';	// The extension key.
  var $cObj;
  var $templateCode;

  function addHeaderData($content, $conf) {

    $this->conf = $conf;
    $this->pi_initPIflexForm();
    $piFlexForm = $this->cObj->data['pi_flexform'];

		foreach ($piFlexForm['data'] as $sheet => $data) {
			foreach ($data as $lang => $value) {
				foreach ($value as $key => $val) {
					$this->lConf[$key] = $this->pi_getFFvalue($piFlexForm, $key, $sheet);
				}
			}
		}
		if ($this->cObj->data['image_zoom'])  { $this->conf['useLightbox']                    = 1;}
		if ($this->cObj->data['imageheight']) { $this->conf['singleheight']                   = $this->cObj->data['imageheight'];}
		if ($this->lConf['largectrls'])       { $this->conf['largectrls']                     = $this->lConf['largectrls'];}
		if ($this->lConf['showtitle'])        { $this->conf['showtitle']                      = $this->lConf['showtitle'];}
		if ($this->lConf['cyclespeed'])       { $this->conf['timeout']                        = $this->lConf['cyclespeed'];}
		if ($this->conf['largectrls'])        { $this->conf['pause']                          = 0;}
		if ($this->lConf['autostart'])        { $this->conf['autostart']                      = 'resume';}
		if ($this->lConf['singleViewOnly'])   { $GLOBALS['TSFE']->register['singleViewOnly']  = 'hidden';}
		if ($this->lConf['thumbwidth'])       { $GLOBALS['TSFE']->register['thumbwidth']      = $this->lConf['thumbwidth'];}
		if ($this->lConf['thumbheight'])      { $GLOBALS['TSFE']->register['thumbheight']     = $this->lConf['thumbheight'];}
		if ($this->lConf['cropscaling'])      { $GLOBALS['TSFE']->register['cropscaling']     = $this->lConf['cropscaling'];}


    if (!$GLOBALS['TSFE']->additionalHeaderData['tx_cscgallery']) {
    $GLOBALS['TSFE']->additionalHeaderData['tx_cscgallery'] .= '
<link type="text/css" media="screen" rel="stylesheet" href="'.$this->getPath($this->conf['pathToLightboxCSS']).'" />';

    $GLOBALS['TSFE']->additionalHeaderData['tx_cscgallery'] .= '
<link type="text/css" media="screen" rel="stylesheet" href="'.$this->getPath($this->conf['pathToCycleCSS']).'" />';


    // if t3jquery is loaded and the custom Library had been created
    if (T3JQUERY === true) {
        tx_t3jquery::addJqJS();
    } else {
        // if none of the previous is true, you need to include your own library
        // just as an example in this way
        $GLOBALS['TSFE']->additionalHeaderData['tx_cscgallery'] .= '
        <script src="'.$this->getPath($this->conf['pathToJquery']).'" type="text/javascript"></script>';
    }

    $GLOBALS['TSFE']->additionalHeaderData['tx_cscgallery'] .= '
<script src="'.$this->getPath($this->conf['pathToLightbox']).'" type="text/javascript"></script>';

    $GLOBALS['TSFE']->additionalHeaderData['tx_cscgallery'] .= '
<script src="'.$this->getPath($this->conf['pathToCycle']).'" type="text/javascript"></script>';

    }


    $this->templateCode = $this->cObj->fileResource($this->conf['templateFile']);
    $jsConf = $this->cObj->getSubpart($this->templateCode, '###CSCGALLERY_PARTS###');
// print_r($this->templateCode);
    if ($jsConf) {
      $jsConf = str_replace('###UID###',        $this->cObj->data['uid'],     $jsConf);
      $jsConf = str_replace('###LIGHTBOX###',   $this->conf['useLightbox'],   $jsConf);
      $jsConf = str_replace('###HEIGHT###',     $this->conf['singleheight'],  $jsConf);
      $jsConf = str_replace('###AUTOSTART###',  $this->conf['autostart'],     $jsConf);
      $jsConf = str_replace('###TIMEOUT###',    $this->conf['timeout'],       $jsConf);
      $jsConf = str_replace('###CTRLS###',      $this->conf['largectrls'],    $jsConf);
      $jsConf = str_replace('###PAUSE###',      $this->conf['pause'],         $jsConf);
      $jsConf = str_replace('###SHOWTITLE###',  $this->conf['showtitle'],     $jsConf);

      $inline2Tmpfile = TSpagegen::inline2TempFile($jsConf,'js');
    }

//     $GLOBALS['TSFE']->additionalHeaderData['tx_cscgallery'] .= '
// <script src="'.$this->getPath($this->conf['pathToTools']).'" type="text/javascript"></script>';
    $GLOBALS['TSFE']->additionalHeaderData['tx_cscgallery'] .= '
<script type="text/javascript" src="' . $inline2Tmpfile . '"></script>';

  }

  function fetchConfigurationValue($param) {
    $value = trim($this->pi_getFFvalue($this->cObj->data['pi_flexform'], $param));
    return $value ? $value : $this->conf[$param];
  }

	function getPath($path) {
		if (substr($path,0,4)=='EXT:') {
			$keyEndPos = strpos($path, '/', 6);
			$key = substr($path,4,$keyEndPos-4);
			$keyPath = t3lib_extMgm::siteRelpath($key);
			$newPath = $keyPath.substr($path,$keyEndPos+1);
		return $newPath;
		}	else {
			return $path;
		}
	}
}
?>