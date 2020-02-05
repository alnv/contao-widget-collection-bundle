<?php

$GLOBALS['TL_DCA']['tl_form_field']['palettes']['ajaxSelect'] = '{type_legend},type,name,label,noOptions;{fconfig_legend},mandatory,multiple;{options_legend},table,vColumn,lColumn;{expert_legend:hide},class,accesskey,tabindex;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['multiDatesWizard'] = '{type_legend},type,name,label;{fconfig_legend},mandatory;{expert_legend:hide},class,value,accesskey,tabindex;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['nouislider'] = '{type_legend},type,name,label;{fconfig_legend},mandatory,useBetweenRange;{expert_legend:hide},class,accesskey,tabindex;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';

$GLOBALS['TL_DCA']['tl_form_field']['fields']['useBetweenRange'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['useBetweenRange'],
    'inputType' => 'checkbox',
    'eval' => [
        'multiple' => false,
        'tl_class' => 'w50'
    ],
    'exclude' => true,
    'sql' => "char(1) default ''"
];
$GLOBALS['TL_DCA']['tl_form_field']['fields']['table'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['table'],
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 128,
        'tl_class' => 'w50',
        'mandatory' => true
    ],
    'exclude' => true,
    'sql' => "varchar(128) NOT NULL default ''"
];
$GLOBALS['TL_DCA']['tl_form_field']['fields']['vColumn'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['vColumn'],
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 128,
        'tl_class' => 'w50',
        'mandatory' => true
    ],
    'exclude' => true,
    'sql' => "varchar(128) NOT NULL default ''"
];
$GLOBALS['TL_DCA']['tl_form_field']['fields']['lColumn'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['lColumn'],
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 128,
        'tl_class' => 'w50',
        'mandatory' => true
    ],
    'exclude' => true,
    'sql' => "varchar(128) NOT NULL default ''"
];
$GLOBALS['TL_DCA']['tl_form_field']['fields']['noOptions'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['noOptions'],
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 255,
        'tl_class' => 'long clr'
    ],
    'exclude' => true,
    'sql' => "varchar(255) NOT NULL default ''"
];