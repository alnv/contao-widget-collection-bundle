<?php

use Alnv\ContaoWidgetCollectionBundle\Widgets\ComboWizard;
use Alnv\ContaoWidgetCollectionBundle\Widgets\MultiDatesWizard;
use Alnv\ContaoWidgetCollectionBundle\Hooks\Attributes;

$GLOBALS['BE_FFL']['comboWizard'] = ComboWizard::class;
$GLOBALS['BE_FFL']['multiDatesWizard'] = MultiDatesWizard::class;

$GLOBALS['TL_HOOKS']['getAttributesFromDca'][] = [Attributes::class, 'getAttributesFromDca'];