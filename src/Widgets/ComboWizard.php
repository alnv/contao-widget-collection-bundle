<?php

namespace Alnv\ContaoWidgetCollectionBundle\Widgets;

class ComboWizard extends \Widget {


    protected $blnSubmitInput = true;
    protected $strTemplate = 'be_widget';


    public function __set( $strKey, $varValue ) {

        parent::__set( $strKey, $varValue );
    }

    public function validate() {

        $varValue = $this->getPost( $this->strName );

        if ( $this->mandatory && !$this->hasValue( $varValue ) ) {

            $this->addError( sprintf($GLOBALS['TL_LANG']['ERR']['mandatory'], $this->strLabel ) );
        }

        parent::validate();
    }

    protected function hasValue( $strJson ) {

        if ( !$strJson ) {

            return false;
        }

        $arrJson = json_decode( $strJson );

        if ( !is_array( $arrJson ) || empty( $arrJson ) ) {

            return false;
        }

        if ( isset( $arrJson[0] ) && $arrJson[0]->option === null || $arrJson[0]->option === '' ) {

            return false;
        }

        return true;
    }


    public function generate() {

        $objTemplate = new \FrontendTemplate( 'form_combo_wizard' );
        $objTemplate->name = $this->name;
        $objTemplate->id = \Input::get('id');
        $objTemplate->table = $this->strTable;
        $objTemplate->value = $this->value ?: '"[{}]"';

        return $objTemplate->parse();
    }
}