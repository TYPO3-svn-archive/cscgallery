<?php
/***************************************************************
*  Copyright notice
*
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

class tx_scsgallery_tcahelper {

	/**
	 * Removes items from showitem
	 *
	 * @param string item
	 * @param string showitem
	 * @return string
	 */
	public static function TCAremoveFromShowitem($item, $showitem) {
		$showitem = t3lib_div::trimExplode(',', $showitem);
		foreach ($showitem as $sKey => $sVal) {
			if (preg_match('%^' . $item . '%', $sVal)) {
				unset($showitem[$sKey]);
			} else {
			}
		}

		return implode(',', $showitem);
	}
}
?>