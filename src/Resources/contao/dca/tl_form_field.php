<?php

$GLOBALS['TL_DCA']['tl_form_field']['palettes']['ajax_select'] = '{type_legend},type,name,label;{fconfig_legend},mandatory,multiple;{options_legend},table,vColumn,lColumn;{expert_legend:hide},class,accesskey,tabindex;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';

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