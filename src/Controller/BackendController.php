<?php

namespace Alnv\ContaoWidgetCollectionBundle\Controller;

use Alnv\ContaoWidgetCollectionBundle\Helpers\Toolkit;
use Contao\CoreBundle\Controller\AbstractController;
use Contao\System;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: 'widget-collection', name: 'widget-collection-backend-controller', defaults: ['_scope' => 'backend'])]
class BackendController extends AbstractController
{

    #[Route(path: '/combo-wizard', methods: ["POST"])]
    public function fetchComboWizard(Request $objRequest): JsonResponse
    {

        $this->container->get('contao.framework')->initialize();

        System::loadLanguageFile('default', $objRequest->request->get('language'));

        return new JsonResponse(Toolkit::getEvalByTableAndFieldname($objRequest->request->get('table'), $objRequest->request->get('name'), $objRequest->request->get('id')));
    }
}