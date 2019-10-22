<?php

$GLOBALS['TL_FFL']['ajax_select'] = 'Alnv\ContaoWidgetCollectionBundle\Forms\FormAjaxSelectMenu';

$objWidgetsAssetsManager = \Alnv\ContaoAssetsManagerBundle\Library\AssetsManager::getInstance();
$objWidgetsAssetsManager->addIfNotExist( 'bundles/alnvcontaowidgetcollection/libs/vue-select/vue-select.js' );
$objWidgetsAssetsManager->addIfNotExist( 'bundles/alnvcontaowidgetcollection/components/ajax-select-menu-component.js' );