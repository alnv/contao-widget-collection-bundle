<?php

namespace Alnv\ContaoWidgetCollectionBundle\Widgets;

use Alnv\ContaoWidgetCollectionBundle\Helpers\Toolkit;
use Contao\Combiner;
use Contao\FrontendTemplate;
use Contao\Input;
use Contao\StringUtil;
use Contao\Widget;

class MultiDatesWizard extends Widget
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

    protected function hasValue($strJson)
    {

        if (!$strJson) {
            return false;
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

    protected function setResources(): void
    {

        $objCombiner = new Combiner();
        $objCombiner->add('bundles/alnvcontaowidgetcollection/libs/moment/moment.min.js');
        $objCombiner->add('bundles/alnvcontaowidgetcollection/libs/nouislider/nouislider.js');
        $objCombiner->add('bundles/alnvcontaowidgetcollection/libs/pikaday/pikaday.min.js');
        $objCombiner->add('bundles/alnvcontaowidgetcollection/libs/sorting/sortable.min.js');
        $objCombiner->add('bundles/alnvcontaowidgetcollection/libs/sorting/vuedraggable.min.js');

        $objCombiner->add('bundles/alnvcontaowidgetcollection/components/sorting/pikaday-directive.js');
        $objCombiner->add('bundles/alnvcontaowidgetcollection/components/sorting/nouislider-directive.js');
        $objCombiner->add('bundles/alnvcontaowidgetcollection/components/sorting/multi-dates-wizard-component.js');

        $GLOBALS['TL_JAVASCRIPT']['form_multi_dates_wizard'] = $objCombiner->getCombinedFile();

        $objCombiner = new Combiner();
        $objCombiner->add('bundles/alnvcontaowidgetcollection/libs/pikaday/pikaday.min.css');
        $objCombiner->add('bundles/alnvcontaowidgetcollection/libs/nouislider/nouislider.css');
        $GLOBALS['TL_CSS']['form_multi_dates_wizard_libs'] = $objCombiner->getCombinedFile();

        $objCombiner = new Combiner();
        $objCombiner->add('bundles/alnvcontaowidgetcollection/css/multi-dates-wizard.scss');
        $GLOBALS['TL_CSS']['form_multi_dates_wizard'] = $objCombiner->getCombinedFile();
    }

    public function validate()
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

    public function generate(): string
    {

        Toolkit::addVueJsScript('TL_JAVASCRIPT');

        $this->setResources();

        $objTemplate = new FrontendTemplate('form_multi_dates_wizard');
        $objTemplate->useDay = $this->useDay ?: false;
        $objTemplate->dateFormat = $this->dateFormat ?: 'DD.MM.YYYY';
        $objTemplate->name = $this->name;
        $objTemplate->id = Input::get('id');
        $objTemplate->table = $this->strTable;
        $objTemplate->value = $this->value ?: '"[]"';

        return $objTemplate->parse();
    }
}