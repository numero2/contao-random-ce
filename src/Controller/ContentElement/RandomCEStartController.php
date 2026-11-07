<?php

/**
 * Random CE Bundle for Contao Open Source CMS
 *
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   Commercial
 * @copyright Copyright (c) 2024, numero2 - Agentur für digitales Marketing GbR
 */


namespace numero2\RandomCEBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\ServiceAnnotation\ContentElement;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @ContentElement("randomCEStart",
 *   category="random_ce"
 * )
 */
class RandomCEStartController extends InvisibleWrapperController {


    /**
     * @var Doctrine\DBAL\Connection
     */
    private $connection;


    public function __construct( Connection $connection ) {

        $this->connection = $connection;
    }


    /**
     * {@inheritdoc}
     */
    protected function getResponse( FragmentTemplate $template, ContentModel $model, Request $request ): Response {

		// determine which element should be shown this time
		$closingElement = $this->connection->fetchAssociative(
			"SELECT id, sorting FROM tl_content WHERE pid=:pid AND ptable=:ptable AND sorting>:sorting AND type=:type ORDER BY sorting ASC LIMIT 1",
			['pid'=>$model->pid, 'ptable'=>'tl_article', 'sorting'=>$model->sorting, 'type'=>'randomCEStop']
		);

		if( $closingElement && !empty($closingElement['id']) ) {

			$aElementIDs = $this->connection->fetchFirstColumn(
				"SELECT id FROM tl_content WHERE pid=:pid AND ptable=:ptable AND sorting>:sortingStart AND sorting<:sortingEnd AND invisible!=:invisible ORDER BY sorting ASC",
				['pid'=> $model->pid, 'ptable'=> 'tl_article', 'sortingStart'=> $model->sorting, 'sortingEnd'=> $closingElement['sorting'], 'invisible'=> 1]
			);

			if( !empty($aElementIDs) ) {

				// decide which will be shown
				$toBeShown = mt_rand(0, (count($aElementIDs)-1));
				unset($aElementIDs[$toBeShown]);

				// save in master request
				$masterRequest = $this->container->get('request_stack')->getMainRequest();
				$masterRequest->attributes->set('randomCEHide', array_values($aElementIDs));
			}
		}

		return parent::getResponse($template, $model, $request);
	}

}
