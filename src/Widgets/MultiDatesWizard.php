<?php

namespace Alnv\ContaoWidgetCollectionBundle\Widgets;

class MultiDatesWizard extends \Widget {

    protected $blnSubmitInput = true;
    protected $strTemplate = 'be_widget';

    public function __set( $strKey, $varValue ) {

        parent::__set( $strKey, $varValue );
    }

    protected function hasValue( $strJson ) {

        if (!$strJson) {
            return false;
        }

        if (is_string($strJson)) {
            $strJson = \StringUtil::decodeEntities($strJson);
        }

        $arrJson = json_decode($strJson, true);

        if (!is_array($arrJson) || empty($arrJson)) {
            return false;
        }
        
        if (isset($arrJson[0]) && $arrJson[0]['to'] === null || $arrJson[0]['from'] === '') {
            return false;
        }

        return true;
    }

    public function validate() {

        $varValue = $this->getPost($this->strName);
        if ( $this->mandatory && !$this->hasValue($varValue)) {
            $this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['mandatory'], $this->strLabel));
        }

        parent::validate();
    }

    public function generate() {

        $objTemplate = new \FrontendTemplate('form_multi_dates_wizard');
        $objTemplate->name = $this->name;
        $objTemplate->useDay = $this->useDay ?: false;
        $objTemplate->dateFormat = $this->dateFormat ?: 'DD.MM.YYYY';
        $objTemplate->name = $this->name;
        $objTemplate->id = \Input::get('id');
        $objTemplate->table = $this->strTable;
        $objTemplate->value = $this->value ?: '"[]"';
        return $objTemplate->parse();
    }
}