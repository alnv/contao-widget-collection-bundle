<?php

namespace Alnv\ContaoWidgetCollectionBundle\Forms;

use Contao\Widget;

class FormAjaxSelectMenu extends Widget
{

    protected $blnSubmitInput = true;

    protected $blnForAttribute = true;

    protected $strTemplate = 'form_ajax_select';

    protected $strPrefix = 'widget widget-ajax-select';


    public function generate()
    {

        //
    }
}