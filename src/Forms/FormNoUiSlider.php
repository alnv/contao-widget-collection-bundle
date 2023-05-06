<?php

namespace Alnv\ContaoWidgetCollectionBundle\Forms;

use Contao\Widget;

class FormNoUiSlider extends Widget
{

    protected $blnSubmitInput = true;

    protected $blnForAttribute = true;

    protected $strTemplate = 'form_nouislider';

    protected $strPrefix = 'widget widget-nouislider';

    public function generate()
    {

        //
    }
}