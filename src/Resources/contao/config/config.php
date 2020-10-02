<?php

$GLOBALS['BE_FFL']['comboWizard'] = 'Alnv\ContaoWidgetCollectionBundle\Widgets\ComboWizard';
$GLOBALS['BE_FFL']['multiDatesWizard'] = 'Alnv\ContaoWidgetCollectionBundle\Widgets\MultiDatesWizard';

$GLOBALS['TL_FFL']['nouislider'] = 'Alnv\ContaoWidgetCollectionBundle\Forms\FormNoUiSlider';
$GLOBALS['TL_FFL']['ajaxSelect'] = 'Alnv\ContaoWidgetCollectionBundle\Forms\FormAjaxSelectMenu';
$GLOBALS['TL_FFL']['multiDatesWizard'] = 'Alnv\ContaoWidgetCollectionBundle\Forms\FormMultiDatesWizard';

$GLOBALS['TL_HOOKS']['getAttributesFromDca'][] = [ 'Alnv\ContaoWidgetCollectionBundle\Hooks\Attributes', 'getAttributesFromDca' ];

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

if (\Config::get('doNotUseWidgetStylesNScriptsInFrontend') && TL_MODE == 'FE') {
    $GLOBALS['CM_WIDGET_SCRIPT_N_STYLES']['SCRIPTS'] = [];
    $GLOBALS['CM_WIDGET_SCRIPT_N_STYLES']['STYLES'] = [];
}

$objCssCombiner = new \Combiner();
$objWidgetsAssetsManager = \Alnv\ContaoAssetsManagerBundle\Library\AssetsManager::getInstance();
foreach ($GLOBALS['CM_WIDGET_SCRIPT_N_STYLES']['SCRIPTS'] as $strScript) {
    $objWidgetsAssetsManager->addIfNotExist($strScript);
}
foreach ($GLOBALS['CM_WIDGET_SCRIPT_N_STYLES']['STYLES'] as $strStyle) {
    $objCssCombiner->add($strStyle);
}
if ($strCombinedStyles = $objCssCombiner->getCombinedFile()) {
    $GLOBALS['TL_CSS']['widget-collection-bundle'] = $strCombinedStyles;
}
// $objWidgetsAssetsManager = \Alnv\ContaoAssetsManagerBundle\Library\AssetsManager::getInstance();
// $objWidgetsAssetsManager->addIfNotExist( 'bundles/alnvcontaowidgetcollection/libs/vue-select/vue-select.js' );
// $objWidgetsAssetsManager->addIfNotExist( 'bundles/alnvcontaowidgetcollection/libs/nouislider/nouislider.min.js' );
// $objWidgetsAssetsManager->addIfNotExist( 'bundles/alnvcontaowidgetcollection/libs/sorting/sortable.min.js' );
// $objWidgetsAssetsManager->addIfNotExist( 'bundles/alnvcontaowidgetcollection/libs/sorting/vuedraggable.min.js' );
// $objWidgetsAssetsManager->addIfNotExist( 'bundles/alnvcontaowidgetcollection/libs/moment/moment.min.js' );
// $objWidgetsAssetsManager->addIfNotExist( 'bundles/alnvcontaowidgetcollection/components/combo-wizard-component.js' );
// $objWidgetsAssetsManager->addIfNotExist( 'bundles/alnvcontaowidgetcollection/components/ajax-select-menu-component.js' );
// $objWidgetsAssetsManager->addIfNotExist( 'bundles/alnvcontaowidgetcollection/components/multi-dates-wizard-component.js' );
// $objWidgetsAssetsManager->addIfNotExist( 'bundles/alnvcontaowidgetcollection/components/nouislider-directive.js' );
// $objCssCombiner = new \Combiner();
// $objCssCombiner->add( 'bundles/alnvcontaowidgetcollection/libs/vue-select/vue-select.scss' );
// $objCssCombiner->add( 'bundles/alnvcontaowidgetcollection/css/combo-wizard.scss' );
// $objCssCombiner->add( 'bundles/alnvcontaowidgetcollection/css/multi-dates-wizard.scss' );
// $objCssCombiner->add( 'bundles/alnvcontaowidgetcollection/libs/nouislider/nouislider.min.css' );
// $GLOBALS['TL_CSS']['widget-collection-bundle'] = $objCssCombiner->getCombinedFile();