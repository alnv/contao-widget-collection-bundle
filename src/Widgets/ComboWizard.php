<?php

namespace Alnv\ContaoWidgetCollectionBundle\Widgets;

use Alnv\ContaoWidgetCollectionBundle\Helpers\Toolkit;
use Contao\Combiner;
use Contao\FrontendTemplate;
use Contao\Input;
use Contao\StringUtil;
use Contao\Widget;

class ComboWizard extends Widget
{

    protected $blnSubmitInput = true;
    protected $strTemplate = 'be_widget';

    public function __set($strKey, $varValue)
    {

        parent::__set($strKey, $varValue);
    }

    public function validator($varInput)
    {

        $varInput = parent::validator($varInput);

        return StringUtil::decodeEntities($varInput);
    }

    public function validate(): void
    {

        $varValue = $this->getPost($this->strName);

        if (is_string($varValue)) {
            $varValue = StringUtil::decodeEntities($varValue);
        }

        if ($this->mandatory && !$this->hasValue($varValue)) {
            $this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['mandatory'], $this->strLabel));
        }

        parent::validate();
    }

    protected function hasValue($strJson): bool
    {

        if (!$strJson) {
            return false;
        }

        $arrJson = json_decode($strJson, true);

        if (!is_array($arrJson) || empty($arrJson)) {
            return false;
        }

        if (isset($arrJson[0]) && $arrJson[0]['option'] === null || $arrJson[0]['option'] === '') {
            return false;
        }

        return true;
    }

    protected function setResources(): void
    {

        $objCombiner = new Combiner();
        $objCombiner->add('bundles/alnvcontaowidgetcollection/libs/vue-select/vue-select.js');
        $objCombiner->add('bundles/alnvcontaowidgetcollection/components/combo-wizard-component.js');
        $GLOBALS['TL_JAVASCRIPT']['combo-wizard-component'] = $objCombiner->getCombinedFile();

        $objCombiner = new Combiner();
        $objCombiner->add('bundles/alnvcontaowidgetcollection/css/combo-wizard.scss');
        $objCombiner->add('bundles/alnvcontaowidgetcollection/libs/vue-select/vue-select.scss');
        $GLOBALS['TL_CSS']['combo-wizard-component'] = $objCombiner->getCombinedFile();
    }

    public function generate(): string
    {

        Toolkit::addVueJsScript('TL_JAVASCRIPT');

        $this->setResources();

        $objTemplate = new FrontendTemplate('form_combo_wizard');
        $objTemplate->name = $this->name;
        $objTemplate->id = Input::get('id');
        $objTemplate->table = $this->strTable;
        $objTemplate->value = $this->value ? Toolkit::parseJSObject($this->value) : '[{}]';
        $objTemplate->enableGroup = $this->enableGroup ? 'true' : 'false';
        $objTemplate->enableField = $this->enableField ? 'true' : 'false';

        return $objTemplate->parse();
    }
}