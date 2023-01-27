<?php

/**
 * Random CE Bundle for Contao Open Source CMS
 *
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   Commercial
 * @copyright Copyright (c) 2023, numero2 - Agentur für digitales Marketing GbR
 */


namespace numero2\RandomCEBundle\EventListener\Hook;

use Contao\ContentModel;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\CoreBundle\ServiceAnnotation\Hook;
use Symfony\Component\HttpFoundation\RequestStack;


class ContentElementListener {


    /**
     * @var Symfony\Component\HttpFoundation\RequestStack
     */
    private $requestStack;

    /**
     * @var Contao\CoreBundle\Routing\ScopeMatcher
     */
    private $scopeMatcher;


    public function __construct( RequestStack $requestStack, ScopeMatcher $scopeMatcher ) {

        $this->requestStack = $requestStack;
        $this->scopeMatcher = $scopeMatcher;
    }


    /**
     * Check if this content element should be visible on this request
     *
     * @param Contao\ContentModel $row
     * @param string $strBuffer
     * @param Contao\Form|Contao\ContentElement $element
     *
     * @return string
     *
     * @Hook("getContentElement")
     */
    public function checkContentElement( ContentModel $model, string $strBuffer, $element ): string {

        $request = $this->requestStack->getCurrentRequest();

        if( !$request || $this->scopeMatcher->isBackendRequest($request) ) {
            return $strBuffer;
        }

        if( !$request->attributes->has('randomCEHide') ) {
            return $strBuffer;
        }

        if( in_array($model->id, $request->attributes->get('randomCEHide')) ) {
            return '';
        }

        return $strBuffer;
    }
}
