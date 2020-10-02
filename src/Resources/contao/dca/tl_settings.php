<?php

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{cm_widget_legend},doNotUseWidgetStylesNScriptsInFrontend,doNotUseThirdPartyStylesNScriptsInFrontend';

$GLOBALS['TL_DCA']['tl_settings']['fields']['doNotUseWidgetStylesNScriptsInFrontend'] = [
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'clr'
    ]
];
$GLOBALS['TL_DCA']['tl_settings']['fields']['doNotUseThirdPartyStylesNScriptsInFrontend'] = [
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'clr'
    ]
];