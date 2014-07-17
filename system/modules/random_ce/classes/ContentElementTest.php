<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package   Random ContentElement
 * @author    Benny Born <benny.born@numero2.de>
 * @license   LGPL
 * @copyright 2014 numero2 - Agentur für Internetdienstleistungen
 */


namespace RandomCE;


class ContentElementTest extends \Controller
{

	/**
	 * Check if this content element should be visible this time
	 * @param $row
	 * @param $strBuffer
	 */
	public function checkContentElement( $row, $strBuffer )
	{

		if( TL_MODE == 'BE' || empty($GLOBALS['random_ce_hide']) || !in_array($row->id,$GLOBALS['random_ce_hide']) )
			return $strBuffer;

		return '';
	}
}