<?php

namespace Alnv\ContaoWidgetCollectionBundle\Hooks;

use Contao\ArrayUtil;
use Contao\Controller;
use Contao\Database;
use Contao\System;

class Attributes extends Controller
{

    public function getAttributesFromDca($arrAttributes, $objDca)
    {

        if ($arrAttributes['type'] == 'comboWizard' || (isset($arrAttributes['options2_callback']) && $arrAttributes['options2_callback'])) {

            if (!isset($arrAttributes['options2']) || is_array($arrAttributes['options2'])) {
                $arrAttributes['options2'] = [];
            }

            if (is_array($arrAttributes['options2_callback'])) {
                $arrCallback = $arrAttributes['options2_callback'];
                $arrOptions = static::importStatic($arrCallback[0])->{$arrCallback[1]}($objDca);
                $this->parseOptions($arrOptions, 'options2', $arrAttributes);
            } elseif (is_callable($arrAttributes['options2_callback'])) {
                $arrOptions = $arrAttributes['options2_callback']($objDca);
                $this->parseOptions($arrOptions, 'options2', $arrAttributes);
            } elseif (isset($arrAttributes['foreignKey2'])) {
                $arrKey = explode('.', $arrAttributes['foreignKey2'], 2);
                $objOptions = Database::getInstance()->query("SELECT id, " . $arrKey[1] . " AS value FROM " . $arrKey[0] . " WHERE tstamp>0 ORDER BY value");
                $arrOptions = [];
                while ($objOptions->next()) {
                    $arrOptions[$objOptions->id] = $objOptions->value;
                }
                $this->parseOptions($arrOptions, 'options2', $arrAttributes);
            }

            if (!isset($arrAttributes['options']) && !empty($arrAttributes['options_callback'])) {
                if (is_array($arrAttributes['options_callback'])) {
                    $arrCallback = $arrAttributes['options_callback'];
                    $arrOptions = static::importStatic($arrCallback[0])->{$arrCallback[1]}($objDca);
                    $this->parseOptions($arrOptions, 'options', $arrAttributes);
                } elseif (is_callable($arrAttributes['options_callback'])) {
                    $arrOptions = $arrAttributes['options_callback']($objDca);
                    $this->parseOptions($arrOptions, 'options', $arrAttributes);
                }
            }

        }

        return $arrAttributes;
    }

    protected function parseOptions($arrOptions, $strKey, &$arrAttributes)
    {

        if (empty($arrOptions)) {
            return null;
        }

        $blnIsAssociative = (($arrAttributes['isAssociative']??false) || ArrayUtil::isAssoc($arrOptions));
        $blnUseReference = isset($arrAttributes['reference']);

        if (($arrAttributes['includeBlankOption']??false) && !($arrAttributes['multiple']??false)) {

            $parser = System::getContainer()->get('contao.insert_tag.parser');
            $strLabel = $parser->replaceInline((string)($arrAttributes['blankOptionLabel'] ?? '-'));
            $arrAttributes[$strKey][] = ['value' => '', 'label' => $strLabel];
        }

        foreach ($arrOptions as $k => $v) {

            if (!is_array($v)) {
                $arrAttributes[$strKey][] = ['value' => ($blnIsAssociative ? $k : $v), 'label' => ($blnUseReference ? ((($ref = (is_array($arrAttributes['reference'][$v]) ? $arrAttributes['reference'][$v][0] : $arrAttributes['reference'][$v])) != false) ? $ref : $v) : $v)];
                continue;
            }

            $key = $blnUseReference ? ((($ref = (is_array($arrAttributes['reference2'][$k]) ? $arrAttributes['reference'][$k][0] : $arrAttributes['reference'][$k])) != false) ? $ref : $k) : $k;
            $blnIsAssoc = ArrayUtil::isAssoc($v);

            foreach ($v as $kk => $vv) {
                $arrAttributes[$strKey][$key][] = ['value' => ($blnIsAssoc ? $kk : $vv), 'label' => ($blnUseReference ? ((($ref = (\is_array($arrAttributes['reference'][$vv]) ? $arrAttributes['reference'][$vv][0] : $arrAttributes['reference'][$vv])) != false) ? $ref : $vv) : $vv)];
            }
        }
    }
}