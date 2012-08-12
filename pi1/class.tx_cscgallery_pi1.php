<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Lars Hayer <typo3@larshayer.com>
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


/**
 * Plugin 'Image Gallery Browser' for the 'lh_gallery' extension.
 *
 * @author	Lars Hayer <typo3@larshayer.com>
 * @package	TYPO3
 * @subpackage	tx_lhgallery
 */
class tx_lhgallery_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_lhgallery_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_lhgallery_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'lh_gallery';	// The extension key.
	var $pi_checkCHash = true;
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();

    $this->ttSetup = Array();
		
		// Check environment
    /*
    if (!isset($conf['usersPid'])) {
      return $this->pi_wrapInBaseClass($this->pi_getLL('no_ts_template'));
    }
	  */
		// Init
		$this->init();

		if ($this->conf['jsView'] != '1') {
  		if (t3lib_div::testInt($this->piVars['single']) || $this->conf['singleViewOnly'] == '1') {
  			$content = $this->singleView();
  		}
  		else {
  			$content = $this->listView();
  		}
    }
    else {
  			$content = $this->jsView();
    }

    if ($content) {
      return $content;
		  //return $this->pi_wrapInBaseClass($content);
		}
	}
	
  	/**
  * Initializes plugin configuration.
  *
  * @return string Generated HTML
  */
  function init() {
		$this->pi_initPIflexForm();
		// Get values
		$this->conf['listView'] = $this->cObj->data['image'];
		$this->conf['singleView'] = ($this->fetchConfigurationValue('singleView')) ? $this->fetchConfigurationValue('singleView') : $this->cObj->data['image'];
		
		$this->listViewList = t3lib_div::trimExplode(',',$this->conf['listView']);
		$this->singleViewList = t3lib_div::trimExplode(',',$this->conf['singleView']);
		
		$this->conf['singleView'] = t3lib_div::array_merge_recursive_overrule($this->singleViewList,$this->listViewList,0,false);
		$this->conf['jsView.'] = t3lib_div::array_merge_recursive_overrule($this->listViewList,$this->singleViewList,0,false);
		
    $this->ttSetupList = $this->conf['ttSetupList.'];
    $this->ttSetupSingle = $this->conf['ttSetupSingle.'];
    $this->ttSetupJS = $this->conf['ttSetupJS.'];
    
    $this->conf['listView.']['pageSize'] = ($this->fetchConfigurationValue('pageSize')) ? $this->fetchConfigurationValue('pageSize') : $this->conf['listView.']['pageSize'];
    $this->conf['singleView.']['showTextOnSingle'] = ($this->fetchConfigurationValue('showTextOnSingle')) ? $this->fetchConfigurationValue('showTextOnSingle') : false;
    $this->conf['singleView.']['imagewidth'] = ($this->fetchConfigurationValue('imagewidth')) ? $this->fetchConfigurationValue('imagewidth') : $this->conf['singleView.']['imagewidth'];
    $this->conf['singleViewOnly'] = ($this->fetchConfigurationValue('singleViewOnly')) ? $this->fetchConfigurationValue('singleViewOnly') : $this->conf['singleViewOnly'];
    $this->conf['jsView'] = ($this->fetchConfigurationValue('jsView')) ? $this->fetchConfigurationValue('jsView') : $this->conf['jsView'];
  }
  
  
	/**
	 * Fetches configuration value given its name. Merges flexform and TS configuration values.
	 *
	 * @param	string	$param	Configuration value name
	 * @return	string	Parameter value
	 */
	function fetchConfigurationValue($param) {
		$value = trim($this->pi_getFFvalue($this->cObj->data['pi_flexform'], $param));
		return $value ? $value : $this->conf[$param];
	}

  
  /**
  * Shows single user card.
  *
  * @return string Generated HTML
  */
  
  function singleView() {
    $singleView = '';
    if ($this->conf['singleView']) {
    
      $singleImgList =  $this->conf['singleView'];
      
      unset($this->ttSetupSingle['imgList.']);
      $singleImgItem = ($this->piVars['single']) ? $this->piVars['single'] : '0';
      $this->ttSetupSingle['imgList'] = $singleImgList[$singleImgItem];
      
      unset($this->ttSetupList['cols.']);
      $this->ttSetupList['cols'] = '1';
      
      if ($this->conf['singleView.']['imagewidth']) {
        unset($this->ttSetupSingle['1.']['file.']['width.']);
        $this->ttSetupSingle['1.']['file.']['width'] = $this->conf['singleView.']['imagewidth'];
        $this->ttSetupSingle['maxWInText'] = $this->ttSetupSingle['maxW'];
        $this->ttSetupSingle['maxWInText.'] = $this->ttSetupSingle['maxW.'];
      }
      
      if (!$this->conf['singleView.']['showTextOnSingle']) {
        unset($this->ttSetupSingle['text']);
        unset($this->ttSetupSingle['text.']);
      }

      if (count($singleImgList) > 1) {
        
        if ($this->piVars['page'] && $this->conf['useBackPid'] == '1') {
          $this->ttSetupSingle['1.']['imageLinkWrap.']['typolink.']['additionalParams.']['stdWrap.']['cObject.']['2'] = 'TEXT';
          $this->ttSetupSingle['1.']['imageLinkWrap.']['typolink.']['additionalParams.']['stdWrap.']['cObject.']['2.']['value'] = '&' . $this->prefixId . '[page]=' . $this->piVars['page'];
        }
        
        if ((!$this->conf['singleViewOnly'] == 1) || ($this->conf['singleViewOnly'] == 1 && $this->piVars['single'] != count($singleImgList)-1)) {
          $this->ttSetupSingle['1.']['imageLinkWrap.']['typolink.']['additionalParams.']['stdWrap.']['cObject'] = 'COA';
          $this->ttSetupSingle['1.']['imageLinkWrap.']['typolink.']['additionalParams.']['stdWrap.']['cObject.']['5'] = 'TEXT';
          $this->ttSetupSingle['1.']['imageLinkWrap.']['typolink.']['additionalParams.']['stdWrap.']['cObject.']['5.']['value'] = '&' . $this->prefixId . '[single]=';
  
          $this->ttSetupSingle['1.']['imageLinkWrap.']['typolink.']['additionalParams.']['stdWrap.']['cObject.']['10'] = 'TEXT';
          
          if ($this->piVars['single'] < count($singleImgList)-1 && $this->piVars['single'] >= 0 ) {
            $this->ttSetupSingle['1.']['imageLinkWrap.']['typolink.']['additionalParams.']['stdWrap.']['cObject.']['10.']['value'] = $this->piVars['single']+1;
          } else {
            $this->ttSetupSingle['1.']['imageLinkWrap.']['typolink.']['additionalParams.']['stdWrap.']['cObject.']['10.']['value'] = '0';
          }
        }
      }
      
      $this->ttSetupSingle['1.']['imageLinkWrap.']['typolink.']['useCacheHash'] = '1';

      $singleView = $this->singleViewGetPager($singleImgList);
    }
 
    return $singleView;
  }
  
	/**
	 * Returns pager for single view
	 *
	 * @param string $template	Template to get subsection from
	 * @param int $page	Current page number
	 * @param int $pageSize	Maximum number of items in the list
	 * @return string	Generated HTML
	 */
	function singleViewGetPager($singleImgList) {
    
    $singleViewPageBrowser = '';
    
    if (count($singleImgList) > 1) {
      $piVarsTemp = $this->piVars;
      
      $linkPrev = Array();
      
      if ($this->conf['singleViewOnly'] == '1' && $this->piVars['single'] == 1) {
        unset($this->piVars['single']);
      } 
      elseif ($this->conf['singleViewOnly'] != '1' && $this->piVars['single'] == 1) {
        $linkPrev['single'] = '0';
      } 
      elseif ($this->piVars['single'] > 0 && $this->piVars['single'] != 1) {
        $linkPrev['single'] = $this->piVars['single']-1;
      }
      else {
        $linkPrev['single'] = count($singleImgList)-1;
      }
  		$singleViewPageBrowser .= $this->cObj->stdWrap($this->pi_linkTP_keepPIvars($this->pi_getLL('link_prev','link_prev'), $linkPrev, true), $this->conf['singleView.']['prev_stdWrap.']);
      $this->piVars = $piVarsTemp;
  	}

    if ($this->conf['singleViewOnly'] != '1') {
  		if ($this->conf['useBackPid'] == '1' && $this->piVars['page']) {
  		    $singleViewPageBrowser .= $this->cObj->stdWrap($this->pi_linkTP_keepPIvars($this->pi_getLL('link_up','up'), array('page' => $this->piVars['page']), true, true), $this->conf['singleView.']['up_stdWrap.']);
  	  } 
      else {
        $singleViewPageBrowser .= $this->cObj->stdWrap($this->pi_linkTP($this->pi_getLL('link_up','up'),array(),true), $this->conf['singleView.']['up_stdWrap.']);
      }
    } 

    if (count($singleImgList) > 1) {
      $linkNext = Array();
      if ($this->piVars['single'] < count($singleImgList)-1) {
        $linkNext['single'] = $this->piVars['single']+1;
      } 
      elseif ($this->conf['singleViewOnly'] == '1' && $this->piVars['single'] == count($singleImgList)-1) {
        unset($this->piVars['single']);
      } 
      else {
        $linkNext['single'] = 0;
      }
  		#$singleViewPageBrowser .= $this->pi_linkTP_keepPIvars($this->pi_getLL('link_next','link_next'), $linkNext, true);
      $singleViewPageBrowser .= $this->cObj->stdWrap($this->pi_linkTP_keepPIvars($this->pi_getLL('link_next','link_next'), $linkNext, true), $this->conf['singleView.']['prev_stdWrap.']);
    }
    
    if ($singleViewPageBrowser != '') {
      $singleViewPageBrowser = $this->cObj->stdWrap($singleViewPageBrowser, $this->conf['singleView.']['pagebrowser_stdWrap.']);
    }

  	$this->ttSetupSingle['imageStdWrapNoWidth.']['wrap'] = '<div class="csc-textpic-imagewrap">' . $singleViewPageBrowser . ' | </div>';
  	$this->ttSetupSingle['imageStdWrap.']['dataWrap'] = '<div class="csc-textpic-imagewrap" style="width:{register:totalwidth}px;">' . $singleViewPageBrowser . ' | </div>';
    $singleView = $this->cObj->USER($this->ttSetupSingle);

    return $singleView;
	}



  /**
  * Shows user list.
  *
  * @return string Generated HTML
  */
  function listView() {
    $listView = '';
    if ($this->conf['listView']) {
    
      $pageSize = t3lib_div::testInt($this->conf['listView.']['pageSize']) ? intval($this->conf['listView.']['pageSize']) : 10;
		  $page = max(1, intval($this->piVars['page']));
		  
      unset($this->ttSetupList['imgList.']);

      $this->ttSetupList['1.']['imageLinkWrap.']['typolink.']['additionalParams.']['stdWrap.']['cObject'] = 'COA';
      $this->ttSetupList['1.']['imageLinkWrap.']['typolink.']['additionalParams.']['stdWrap.']['cObject.']['5'] = 'TEXT';
      $this->ttSetupList['1.']['imageLinkWrap.']['typolink.']['additionalParams.']['stdWrap.']['cObject.']['5.']['value'] = '&' . $this->prefixId . '[single]=';
      $this->ttSetupList['1.']['imageLinkWrap.']['typolink.']['additionalParams.']['stdWrap.']['cObject.']['10'] = 'TEXT';
      $this->ttSetupList['1.']['imageLinkWrap.']['typolink.']['additionalParams.']['stdWrap.']['cObject.']['10.']['stdWrap.']['dataWrap'] = '(' . $page . '-1)*' . $pageSize . '+{register:IMAGE_NUM_CURRENT}';
      $this->ttSetupList['1.']['imageLinkWrap.']['typolink.']['additionalParams.']['stdWrap.']['cObject.']['10.']['prioriCalc'] = '1';

      if ($this->conf['useBackPid'] == '1' && $page > 1) {
        $this->ttSetupList['1.']['imageLinkWrap.']['typolink.']['additionalParams.']['stdWrap.']['cObject.']['2'] = 'TEXT';
        $this->ttSetupList['1.']['imageLinkWrap.']['typolink.']['additionalParams.']['stdWrap.']['cObject.']['2.']['value'] = '&' . $this->prefixId . '[page]=' . $page;
      }
      
      $this->ttSetupList['1.']['imageLinkWrap.']['typolink.']['useCacheHash'] = '1';

      $listView = $this->listViewGetPager($page, $pageSize);
    } else {
      $listView = 'Sorry, no images found!';
    }

    return $listView;
  }


	/**
	 * Returns pager for list view
	 *
	 * @param string $template	Template to get subsection from
	 * @param int $page	Current page number
	 * @param int $pageSize	Maximum number of items in the list
	 * @return string	Generated HTML
	 */
	function listViewGetPager($page, $pageSize) {
    #$imgList = t3lib_div::trimExplode(',',$this->ttSetupList['imgList']);
    $imgList = $this->conf['jsView.'];
    $imgListLength = count($imgList);

    // Little hack for class.tx_cssstyledcontent -> avoid blank columns and larger images
    $imgCols = intval($this->cObj->data['imagecols']);
    $imgBlanksToAdd = round(( ceil($imgListLength/$imgCols) - ($imgListLength/$imgCols) ) * $imgCols);
#settype($imgBlanksToAdd, "integer");
    $i = 1;
#debug($imgBlanksToAdd);
    while ($i <= $imgBlanksToAdd) {
      array_push($imgList, '.');
      $i++;
    }
    $pager = ''; 

		if ($imgListLength < $pageSize) {
			// Remove pager completely
			$imgRows = implode(',',$imgList);
			$this->ttSetupList['imgList'] = $imgRows;
			return $this->cObj->USER($this->ttSetupList);
		} else {

		  $imgRowsArray = array_slice($imgList,$pageSize*($page-1),$pageSize,true);
		  $imgRows = implode(',',$imgRowsArray);
		  $this->ttSetupList['imgList'] = $imgRows;
  		if ($page == 1) {
  		}
  		elseif ($page == 2) {
  		  unset($this->piVars['page']);
  		  $pager .= $this->cObj->stdWrap(
  		    $this->pi_linkTP_keepPIvars(
            $this->pi_getLL('link_prev','link_prev'),
            array(),
            true),
          $this->conf['singleView.']['prev_stdWrap.']);
  		}
  		else {
  		  $pager .= $this->cObj->stdWrap(
  		    $this->pi_linkTP_keepPIvars(
            $this->pi_getLL('link_prev','link_prev'), array('page' => $page - 1), true),
          $this->conf['singleView.']['prev_stdWrap.']);
  		}
  		if ($imgListLength <= $page*$pageSize) {
  		}
  		else {
        $pager .= $this->cObj->stdWrap(
          $this->pi_linkTP_keepPIvars(
            $this->pi_getLL('link_next','link_next'), array('page' => $page + 1), true),
          $this->conf['singleView.']['prev_stdWrap.']);
  		}

      if ($pager != '') {
        $pager = $this->cObj->stdWrap($pager, $this->conf['singleView.']['pagebrowser_stdWrap.']);
      }

  		$this->ttSetupList['imageStdWrapNoWidth.']['wrap'] = '<div class="csc-textpic-imagewrap">' . $pager . ' | </div>';
  		$this->ttSetupList['imageStdWrap.']['dataWrap'] = '<div class="csc-textpic-imagewrap" style="width:{register:totalwidth}px;"><div>' . $pager . ' | </div></div>';
      $listView = $this->cObj->USER($this->ttSetupList);
    }


    #$listView .= $page;

    return $listView;
	}



  /**
  * Shows user list.
  *
  * @return string Generated HTML
  */
  function jsView() {
    $jsView = '';

    if ($this->conf['jsView.']) {
    
      unset($this->ttSetupJS['imgList.']);
			      $this->ttSetupJS['imgList'] = implode(',',$this->conf['jsView.']);

  		if ($this->conf['singleView.']['imagewidth']) {
        unset($this->ttSetupJS['1.']['imageLinkWrap.']['typolink.']['parameter.']['cObject.']['file.']['width.']);
			        $this->ttSetupJS['1.']['imageLinkWrap.']['typolink.']['parameter.']['cObject.']['file.']['width'] = $this->conf['singleView.']['imagewidth'];
      }

  		$this->ttSetupJS['imageStdWrap.']['dataWrap'] = '<div class="csc-textpic-imagewrap" style="width:{register:totalwidth}px;"><div id="navi"></div><div id="singleView"></div> | </div>';
      
      //if ($this->conf['singleViewOnly'])
      
      $jsView = $this->cObj->USER($this->ttSetupJS);
      
    } else {
      $jsView = 'Sorry, no images found!';
    }

		if (!$this->conf['jQueryJS']) {
			$this->conf['jQueryJS'] =  t3lib_extMgm::siteRelpath($this->extKey) . 'res/jquery-1.3.2.min.js'; 
		}

		if (!$this->conf['jColorboxJS']) {
			$this->conf['jColorboxJS'] =  t3lib_extMgm::siteRelpath($this->extKey) . 'res/jquery.colorbox-min.js'; 
		}
		
		if (!$this->conf['jColorboxCSS']) {
			$this->conf['jColorboxCSS'] =  t3lib_extMgm::siteRelpath($this->extKey) . 'res/colorbox.css'; 
		}

		if (!$this->conf['jPaginationJS']) {
			$this->conf['jPaginationJS'] =  t3lib_extMgm::siteRelpath($this->extKey) . 'res/jquery.pagination.js'; 
		}

/*
     else {
      $this->conf['paginationJS'] = $this->conf['paginationJS'];
    }
*/

		$GLOBALS['TSFE']->additionalHeaderData[$this->extKey] = '
        <script type="text/javascript" src="'.$this->conf['jQueryJS'].'"></script>';

		$GLOBALS['TSFE']->additionalHeaderData[$this->extKey] .= '
        <script type="text/javascript" src="'.$this->conf['jColorboxJS'].'"></script>';

		$GLOBALS['TSFE']->additionalHeaderData[$this->extKey] .= '
        <link type="text/css" media="screen" rel="stylesheet" href="'.$this->conf['jColorboxCSS'].'" />';

		$GLOBALS['TSFE']->additionalHeaderData[$this->extKey] .= '
        <script type="text/javascript" src="'.$this->conf['jPaginationJS'].'"></script>';

    $confJS = '
(function($) {
					
				
					function pageSelectCallback(page_index, container){
							var start = page_index * 3;
							var ende = start + 3;
							
							$(".csc-textpic-image").hide().slice(start,ende).show();
							
							return false;
					};
					
          // Pagination Settings
					var pagination_settings = {
							num_edge_entries: 0,
							num_display_entries: 0,
							callback: pageSelectCallback,
							current_page: 0,
							next_show_always: 0,
							prev_show_always: 0,
							items_per_page :3,
							show: true
					}
					
          // Fancybox Settings
					var colorbox_settings = {
							"positionCSS":"absolute",
							"slideshow":false,
							"open":false,
							"single_float":true,
							"target":".csc-textpic-imagewrap"
					}
					
          // Run lhGallery         
          jQuery(document).ready(function(){
							if (pagination_settings.show) {
									var num_entries = $(".csc-textpic-image").length;
									
									$("#navi").pagination(num_entries, pagination_settings);
							}
							
							if (colorbox_settings.single_float) {
								$(colorbox_settings.target).css({"position":"relative"});
								$("#cboxOverlay").remove();
								$("#colorbox").prependTo(colorbox_settings.target).css({"top":"0!important","left":"0!important"});
							}

							$(".lhgallery_trigger").colorbox(colorbox_settings);

          });
					
})(jQuery);
';

    $confObjJS = TSpagegen::inline2TempFile($confJS,'js');
	  $GLOBALS['TSFE']->additionalHeaderData[$this->extKey] .= $confObjJS;

    return $jsView;
  }

}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lh_gallery/pi1/class.tx_lhgallery_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lh_gallery/pi1/class.tx_lhgallery_pi1.php']);
}

?>
