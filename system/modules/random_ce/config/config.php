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


/**
 * Content elements
 */
$GLOBALS['TL_CTE']['random_ce'] = array(
	'randomCEStart'  => 'ContentRandomCEStart',
	'randomCEStop'   => 'ContentRandomCEStop'
);


/**
 * Wrapper elements
 */
$GLOBALS['TL_WRAPPERS']['start'][] = 'randomCEStart';
$GLOBALS['TL_WRAPPERS']['stop'][] = 'randomCEStop';


/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['getContentElement'][] = array('ContentElementTest','checkContentElement');