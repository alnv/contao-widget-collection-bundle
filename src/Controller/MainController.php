<?php

namespace Alnv\ContaoWidgetCollectionBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Alnv\ContaoWidgetCollectionBundle\Helpers\Toolkit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 *
 * @Route("/widget-collection", defaults={"_token_check" = false})
 */
class MainController extends Controller {


    /**
     *
     * @Route("/ajax-select-options", name="ajaxSelectOptions")
     * @Method({"GET"})
     */
    public function getAjaxSelectOptions() {

        $arrReturn = [
            'options' => []
        ];
        $this->container->get( 'contao.framework' )->initialize();

        $objDatabase = \Database::getInstance();
        $objField = $objDatabase->prepare('SELECT * FROM tl_form_field WHERE id = ?')->limit( 1 )->execute( \Input::get('id') );

        if ( $objField->numRows ) {

            $strTable = $objField->table;
            $strValueColumn = $objField->vColumn;
            $strLabelColumn = $objField->lColumn;

            $objEntities= $objDatabase->prepare('SELECT * FROM '. $strTable . ' WHERE `'. $strLabelColumn .'` REGEXP ? OR `'. $strValueColumn .'` REGEXP ?' )->execute( \Input::get('search'), \Input::get('search') );

            if ( $objEntities->numRows ) {

                while ( $objEntities->next() ) {

                    $arrReturn['options'][] = [
                        'label' => $objEntities->{$strLabelColumn},
                        'value' => $objEntities->{$strValueColumn}
                    ];
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode( $arrReturn, 512 );
        exit;
    }


    /**
     *
     * @Route("/combo-wizard", name="fetchComboWizard")
     * @Method({"POST"})
     */
    public function fetchComboWizard() {

        $this->container->get( 'contao.framework' )->initialize();
        header('Content-Type: application/json');
        echo json_encode( Toolkit::getEvalByTableAndFieldname( \Input::post('table'), \Input::post('name') ), 512 );
        exit;
    }
}