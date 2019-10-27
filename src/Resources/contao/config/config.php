<?php

$GLOBALS['BE_FFL']['comboWizard'] = 'Alnv\ContaoWidgetCollectionBundle\Widgets\ComboWizard';

$GLOBALS['TL_FFL']['ajaxSelect'] = 'Alnv\ContaoWidgetCollectionBundle\Forms\FormAjaxSelectMenu';

$GLOBALS['TL_HOOKS']['getAttributesFromDca'][] = [ 'Alnv\ContaoWidgetCollectionBundle\Hooks\Attributes', 'getAttributesFromDca' ];

$objWidgetsAssetsManager = \Alnv\ContaoAssetsManagerBundle\Library\AssetsManager::getInstance();
$objWidgetsAssetsManager->addIfNotExist( 'bundles/alnvcontaowidgetcollection/libs/vue-select/vue-select.js' );
$objWidgetsAssetsManager->addIfNotExist( 'bundles/alnvcontaowidgetcollection/libs/sorting/sortable.min.js' );
$objWidgetsAssetsManager->addIfNotExist( 'bundles/alnvcontaowidgetcollection/libs/sorting/vuedraggable.min.js' );
$objWidgetsAssetsManager->addIfNotExist( 'bundles/alnvcontaowidgetcollection/components/ajax-select-menu-component.js' );
$objWidgetsAssetsManager->addIfNotExist( 'bundles/alnvcontaowidgetcollection/components/combo-wizard-component.js' );