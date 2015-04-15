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


class ContentRandomCEStart extends \ContentElement
{

	/**
	 * Generate the content element
	 */
	protected function compile()
	{
		if (TL_MODE == 'BE')
		{
			$this->strTemplate = 'be_wildcard';
			$this->Template = new \BackendTemplate($this->strTemplate);

		} else {

			// determine which element should be shown this time
			$closingElement = \Database::getInstance()->prepare("SELECT id,sorting FROM tl_content WHERE pid = ? AND sorting > ? AND type = 'randomCEStop'")->limit(1)->execute( $this->pid, $this->sorting );
			
			if( $closingElement->id ) {

				$contentElements = \Database::getInstance()->prepare("SELECT id FROM tl_content WHERE pid = ? AND sorting > ? AND sorting < ? AND invisible != 1 AND ptable = 'tl_article'")->execute( $this->pid, $this->sorting, $closingElement->sorting );

				$aElementIDs = $contentElements->fetchAllAssoc();
				$GLOBALS['random_ce_hide'] = array();

				// decide which will be shown
				$toBeShown = mt_rand(0, (count($aElementIDs)-1));

				foreach( $aElementIDs as $i => $v ) {

					if( $i != $toBeShown )
						$GLOBALS['random_ce_hide'][$i] = $v['id'];
				}
			}
		}
	}
}