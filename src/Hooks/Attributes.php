<?php

namespace Alnv\ContaoWidgetCollectionBundle\Hooks;


class Attributes extends \Controller {


    public function getAttributesFromDca( $arrAttributes, $objDca ) {

        if ( $arrAttributes['type'] == 'comboWizard' ) {

            $arrAttributes['options2'] = $arrAttributes['options2'] ?: [];
            $arrOptions = [];

            if (is_array( $arrAttributes['options2_callback'] ) ) {

                $arrCallback = $arrAttributes['options2_callback'];
                $arrOptions = static::importStatic( $arrCallback[0] )->{ $arrCallback[1] }( $objDca );

            } elseif ( is_callable( $arrAttributes['options2_callback'] ) ) {

                $arrOptions = $arrAttributes['options2_callback']( $objDca );

            } elseif ( isset( $arrAttributes['foreignKey2'] ) ) {

                $arrKey = explode( '.', $arrAttributes['foreignKey2'], 2 );
                $objOptions = \Database::getInstance()->query("SELECT id, " . $arrKey[1] . " AS value FROM " . $arrKey[0] . " WHERE tstamp>0 ORDER BY value");
                $arrOptions = [];

                while ( $objOptions->next() ) {

                    $arrOptions[$objOptions->id] = $objOptions->value;
                }
            }

            if ( is_array( $arrOptions ) ) {

                $blnIsAssociative = ( $arrAttributes['isAssociative'] || array_is_assoc( $arrOptions ));
                $blnUseReference = isset( $arrAttributes['reference'] );

                if ( $arrAttributes['includeBlankOption'] && !$arrAttributes['multiple'] ) {

                    $strLabel = $arrAttributes['blankOptionLabel'] ?? '-';
                    $arrAttributes['options2'][] = [ 'value' => '', 'label' => $strLabel  ];
                }

                foreach ( $arrOptions as $k => $v ) {

                    if ( !is_array( $v ) ) {

                        $arrAttributes['options2'][] = ['value'=>($blnIsAssociative ? $k : $v), 'label'=>($blnUseReference ? ((($ref = (is_array($arrAttributes['reference'][$v]) ? $arrAttributes['reference'][$v][0] : $arrAttributes['reference'][$v])) != false) ? $ref : $v) : $v)];

                        continue;
                    }

                    $key = $blnUseReference ? ((($ref = (is_array($arrAttributes['reference2'][$k]) ? $arrAttributes['reference'][$k][0] : $arrAttributes['reference'][$k])) != false) ? $ref : $k) : $k;
                    $blnIsAssoc = array_is_assoc($v);

                    foreach ( $v as $kk=>$vv ) {

                        $arrAttributes['options2'][$key][] = ['value'=>($blnIsAssoc ? $kk : $vv), 'label'=>($blnUseReference ? ((($ref = (\is_array($arrAttributes['reference'][$vv]) ? $arrAttributes['reference'][$vv][0] : $arrAttributes['reference'][$vv])) != false) ? $ref : $vv) : $vv)];
                    }
                }
            }
        }

        return $arrAttributes;
    }
}