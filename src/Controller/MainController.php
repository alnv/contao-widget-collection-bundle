<?php

namespace Alnv\ContaoWidgetCollectionBundle\Controller;

use Alnv\ContaoWidgetCollectionBundle\Helpers\Toolkit;
use Contao\CoreBundle\Controller\AbstractController;
use Contao\Database;
use Contao\Input;
use Contao\System;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @Route("/widget-collection", defaults={"_token_check"=false,"_scope"="backend"})
 */
class MainController extends AbstractController
{

    /**
     *
     * @Route("/ajax-select-options", methods={"GET"}, name="ajaxSelectOptions")
     */
    public function getAjaxSelectOptions()
    {

        $arrReturn = ['options' => []];
        $this->container->get('contao.framework')->initialize();
        $objDatabase = Database::getInstance();
        $objField = $objDatabase->prepare('SELECT * FROM tl_form_field WHERE id = ?')->limit(1)->execute(Input::get('id'));

        if ($objField->numRows) {
            $strTable = $objField->table;
            $strValueColumn = $objField->vColumn;
            $strLabelColumn = $objField->lColumn;
            $objEntities = $objDatabase->prepare('SELECT * FROM ' . $strTable . ' WHERE `' . $strLabelColumn . '` REGEXP ? OR `' . $strValueColumn . '` REGEXP ?')->execute(Input::get('search'), Input::get('search'));

            if ($objEntities->numRows) {
                while ($objEntities->next()) {
                    $arrReturn['options'][] = [
                        'label' => $objEntities->{$strLabelColumn},
                        'value' => $objEntities->{$strValueColumn}
                    ];
                }
            }
        }

        return new JsonResponse($arrReturn);
    }

    /**
     *
     * @Route("/combo-wizard", methods={"POST"}, name="fetchComboWizard")
     */
    public function fetchComboWizard(Request $objRequest)
    {

        $this->container->get('contao.framework')->initialize();
        System::loadLanguageFile('default', $objRequest->request->get('language'));

        return new JsonResponse(Toolkit::getEvalByTableAndFieldname($objRequest->request->get('table'), $objRequest->request->get('name'), $objRequest->request->get('id')));
    }
}