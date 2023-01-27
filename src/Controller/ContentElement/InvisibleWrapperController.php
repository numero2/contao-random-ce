<?php

/**
 * Random CE Bundle for Contao Open Source CMS
 *
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   Commercial
 * @copyright Copyright (c) 2023, numero2 - Agentur für digitales Marketing GbR
 */


namespace numero2\RandomCEBundle\Controller\ContentElement;

use Contao\BackendTemplate;
use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;


class InvisibleWrapperController extends AbstractContentElementController {


    public function __invoke( Request $request, ContentModel $model, string $section, array $classes = null ): Response {

        if( $this->container->get('contao.routing.scope_matcher')->isBackendRequest($request) ) {
            return $this->getBackendWildcard($model);
        }

        $template = $this->createTemplate($model, '');

        $this->tagResponse($model);

        $this->getResponse($template, $model, $request);

        return new Response('');
    }


    public static function getSubscribedServices(): array {

        $services = parent::getSubscribedServices();

        $services['translator'] = TranslatorInterface::class;

        return $services;
    }


    protected function getBackendWildcard( ContentModel $module ): Response {

        $name = $this->container->get('translator')->trans('CTE.'.$this->getType().'.0', [], 'contao_modules');

        $template = new BackendTemplate('be_wildcard');
        $template->wildcard = '### '.strtoupper($name).' ###';

        return new Response($template->parse());
    }


    /**
     * {@inheritdoc}
     */
    protected function getResponse( Template $template, ContentModel $model, Request $request ): ?Response {

        return new Response('');
    }
}
