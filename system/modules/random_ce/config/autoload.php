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
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'RandomCE',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Elements
	'RandomCE\ContentElementTest'	=> 'system/modules/random_ce/classes/ContentElementTest.php',
	'RandomCE\ContentRandomCEStart'	=> 'system/modules/random_ce/elements/ContentRandomCEStart.php',
	'RandomCE\ContentRandomCEStop'	=> 'system/modules/random_ce/elements/ContentRandomCEStop.php',
));