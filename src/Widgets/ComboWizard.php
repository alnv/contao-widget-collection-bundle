<?php

namespace Alnv\ContaoWidgetCollectionBundle\Widgets;


class ComboWizard extends \Widget {


    protected $blnSubmitInput = true;
    protected $strTemplate = 'be_widget';


    public function __set( $strKey, $varValue ) {

        parent::__set( $strKey, $varValue );
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