<?php

use Alnv\ContaoAssetsManagerBundle\Library\AssetsManager;
use Contao\Combiner;
use Contao\Config;
use Contao\System;
use Symfony\Component\HttpFoundation\Request;

$GLOBALS['BE_FFL']['comboWizard'] = 'Alnv\ContaoWidgetCollectionBundle\Widgets\ComboWizard';
$GLOBALS['BE_FFL']['multiDatesWizard'] = 'Alnv\ContaoWidgetCollectionBundle\Widgets\MultiDatesWizard';

$GLOBALS['TL_FFL']['nouislider'] = 'Alnv\ContaoWidgetCollectionBundle\Forms\FormNoUiSlider';
$GLOBALS['TL_FFL']['ajaxSelect'] = 'Alnv\ContaoWidgetCollectionBundle\Forms\FormAjaxSelectMenu';
$GLOBALS['TL_FFL']['multiDatesWizard'] = 'Alnv\ContaoWidgetCollectionBundle\Forms\FormMultiDatesWizard';

$GLOBALS['TL_HOOKS']['getAttributesFromDca'][] = ['Alnv\ContaoWidgetCollectionBundle\Hooks\Attributes', 'getAttributesFromDca'];

$GLOBALS['CM_WIDGET_SCRIPT_N_STYLES'] = [
    'SCRIPTS' => [
        'bundles/alnvcontaowidgetcollection/libs/vue-select/vue-select.js',
        'bundles/alnvcontaowidgetcollection/libs/nouislider/nouislider.min.js',
        'bundles/alnvcontaowidgetcollection/libs/sorting/sortable.min.js',
        'bundles/alnvcontaowidgetcollection/libs/sorting/vuedraggable.min.js',
        'bundles/alnvcontaowidgetcollection/libs/moment/moment.min.js',
        'bundles/alnvcontaowidgetcollection/components/combo-wizard-component.js',
        'bundles/alnvcontaowidgetcollection/components/ajax-select-menu-component.js',
        'bundles/alnvcontaowidgetcollection/components/multi-dates-wizard-component.js',
        'bundles/alnvcontaowidgetcollection/components/nouislider-directive.js'
    ],
    'STYLES' => [
        'bundles/alnvcontaowidgetcollection/libs/vue-select/vue-select.scss',
        'bundles/alnvcontaowidgetcollection/css/combo-wizard.scss',
        'bundles/alnvcontaowidgetcollection/css/multi-dates-wizard.scss',
        'bundles/alnvcontaowidgetcollection/libs/nouislider/nouislider.min.css'
    ]
];

if (Config::get('doNotUseWidgetStylesNScriptsInFrontend') && System::getContainer()->get('contao.routing.scope_matcher')->isFrontendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create(''))) {
    $GLOBALS['CM_WIDGET_SCRIPT_N_STYLES']['SCRIPTS'] = [];
    $GLOBALS['CM_WIDGET_SCRIPT_N_STYLES']['STYLES'] = [];
}

if (class_exists('Alnv\ContaoAssetsManagerBundle\Library\AssetsManager')) {
    $objCssCombiner = new Combiner();
    $objWidgetsAssetsManager = AssetsManager::getInstance();
    if (!empty($GLOBALS['CM_WIDGET_SCRIPT_N_STYLES']['SCRIPTS'])) {
        foreach ($GLOBALS['CM_WIDGET_SCRIPT_N_STYLES']['SCRIPTS'] as $strScript) {
            $objWidgetsAssetsManager->addIfNotExist($strScript);
        }
    }
    foreach ($GLOBALS['CM_WIDGET_SCRIPT_N_STYLES']['STYLES'] as $strStyle) {
        $objCssCombiner->add($strStyle);
    }
    if (!empty($GLOBALS['CM_WIDGET_SCRIPT_N_STYLES']['STYLES'])) {
        if ($strCombinedStyles = $objCssCombiner->getCombinedFile()) {
            $GLOBALS['TL_CSS']['widget-collection-bundle'] = $strCombinedStyles;
        }
    }
}