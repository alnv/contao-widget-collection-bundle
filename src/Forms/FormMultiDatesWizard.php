<?php

namespace Alnv\ContaoWidgetCollectionBundle\Forms;


class FormMultiDatesWizard extends \Widget {


    protected $blnSubmitInput = true;
    protected $blnForAttribute = true;
    protected $strTemplate = 'form_multi_dates_wizard';
    protected $strPrefix = 'widget multi-dates-wizard';


    public function __get($strKey) {

        switch ($strKey) {

            case 'value':

                return $this->varValue ?: '"[]"';

                break;
        }

        return parent::__get($strKey);
    }


    public function __set($strKey, $varValue) {

        switch ($strKey) {

            case 'value':

                $this->varValue = $this->varValue ?: '"[]"';

                break;
        }

        parent::__set($strKey, $varValue);
    }


    public function generate() {

        //
    }
}