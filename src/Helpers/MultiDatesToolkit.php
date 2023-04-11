<?php

namespace Alnv\ContaoWidgetCollectionBundle\Helpers;


class MultiDatesToolkit {


    public static function findDate( $varDate, $strJson, $blnIsTstamp = true, $strMethod = '' ) {

        global $objPage;

        $arrReturn = [];

        if ( $strJson === null ) {

            return $arrReturn;
        }

        $arrDates = Toolkit::decodeJson($strJson, [
            'option' => 'from',
            'option2' => 'to'
        ]);

        if ( empty( $arrDates ) ) {

            return $arrReturn;
        }

        if ( !$blnIsTstamp ) {

            $objDate = new \Date( $varDate );
            $varDate = $objDate->tstamp;
        }

        $varDate = (int) $varDate;

        if ( $strMethod && !in_array( $strMethod, [ 'dayBegin', 'dayEnd', 'monthBegin', 'monthEnd' ] ) ) {

            $strMethod = '';
        }

        foreach ( $arrDates as $arrDate ) {

            $arrDate['from'] = $arrDate['from'] ?? '';
            $arrDate['to'] = $arrDate['to'] ?? '';
            
            if (!$arrDate['from'] || !$arrDate['to']) {

                continue;
            }

            $intFrom = (int) $arrDate['from'];
            $intTo = (int) $arrDate['to'];

            if ( $strMethod ) {

                $objFromDate = new \Date( \Date::parse( $objPage->dateFormat, $intFrom ) );
                $intFrom = $objFromDate->{$strMethod};

                $objToDate = new \Date( \Date::parse( $objPage->dateFormat, $intTo ) );
                $intTo = $objToDate->{$strMethod};
            }

            if ( $varDate >= $intFrom && $varDate <= $intTo ) {

                $arrReturn[] = $arrDate;
            }
        }

        return static::parseDates($arrReturn);
    }


    public static function parseDates($varValues, $strFormat = '') {

        $arrReturn = [];

        if (!$strFormat) {
            global $objPage;
            $strFormat = $objPage->dateFormat;
        }

        if (!is_array($varValues) && is_string($varValues)) {
            $varValues = Toolkit::decodeJson($varValues, [
                'option' => 'from',
                'option2' => 'to'
            ]);
        }

        if ( empty( $varValues ) ) {

            return $arrReturn;
        }

        foreach ( $varValues as $varValue ) {

            $arrDate = [];

            foreach ( $varValue as $strName => $strDate ) {

                if ( $strDate === null || $strDate === '' ) {

                    continue;
                }

                $arrDate[ $strName ] = \Date::parse( $strFormat, (int) $strDate );
            }

            if ( empty( $arrDate ) ) {

                continue;
            }

            $arrReturn[] = $arrDate;
        }

        return $arrReturn;
    }
}
