<?php

namespace Alnv\ContaoWidgetCollectionBundle\Helpers;


class Toolkit {


    public static function getEvalByTableAndFieldname( $strTable, $strFieldname ) {

        \Controller::loadDataContainer( $strTable );
        \System::loadLanguageFile( $strTable );

        $objVDataContainer = new VDataContainer();
        $objVDataContainer->activeRecord = static::getActiveRecordFromRouting();

        $arrField = \Widget::getAttributesFromDca( $GLOBALS['TL_DCA'][ $strTable ]['fields'][ $strFieldname ], $strFieldname, '', $strFieldname, $strTable, $objVDataContainer );

        return $arrField;
    }


    protected function getActiveRecordFromRouting() {

        $objActiveRecord = new \stdClass();
        $strTable = \Input::post('table');
        $strId = \Input::post('id');

        if ( !$strTable || !$strId ) {

            return $objActiveRecord;
        }

        $objDatabase = \Database::getInstance();
        $objEntity = $objDatabase->prepare('SELECT * FROM ' . $strTable . ' WHERE id = ?' )->limit(1)->execute( $strId );

        if ( $objEntity->numRows ) {

            $objActiveRecord = $objEntity;
        }

        return $objActiveRecord;
    }
}