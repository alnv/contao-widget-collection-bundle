<?php

namespace Alnv\ContaoWidgetCollectionBundle\Helpers;

class Toolkit {

    public static function getEvalByTableAndFieldname($strTable, $strFieldname, $strId=null) {

        \Controller::loadDataContainer($strTable);
        \System::loadLanguageFile($strTable);

        if (strpos($strFieldname, '[') !== false && strpos($strFieldname, ']') !== false) {
            $strFieldname = strtok($strFieldname, '[');
        }

        $objVDataContainer = new VDataContainer();
        $objVDataContainer->activeRecord = static::getActiveRecordFromRouting($strTable, $strId);

        return \Widget::getAttributesFromDca($GLOBALS['TL_DCA'][$strTable]['fields'][$strFieldname], $strFieldname, '', $strFieldname, $strTable, $objVDataContainer);
    }

    protected static function getActiveRecordFromRouting($strTable=null,$strId=null) {

        $objActiveRecord = new \stdClass();
        $strTable = $strTable ?: \Input::post('table');
        $strId = $strId ?: \Input::post('id');

        if (!$strTable || !$strId) {
            return $objActiveRecord;
        }

        $objEntity = \Database::getInstance()->prepare('SELECT * FROM ' . $strTable . ' WHERE id = ?' )->limit(1)->execute($strId);

        if ( $objEntity->numRows ) {
            $objActiveRecord = $objEntity;
        }

        return $objActiveRecord;
    }

    public static function decodeJson($strJson, $arrMap = []) {

        if (!$strJson) {
            return [];
        }

        $arrJson = json_decode($strJson, true);

        if (!is_array($arrJson) || empty($arrJson)) {
            return [];
        }

        $arrReturn = [];

        foreach ($arrJson as $arrOptions) {
            $arrOption = [];
            foreach ($arrOptions as $strKey => $strValue) {
                if ($strValue === null) {
                    continue;
                }
                $strKey = $arrMap[$strKey] ?: $strKey;
                $arrOption[$strKey] = (string) $strValue;
            }

            if (empty($arrOption)) {
                continue;
            }
            $arrReturn[] = $arrOption;
        }

        return $arrReturn;
    }

    public static function parseJSObject($varObject) {

        if (is_string($varObject)) {
            $varObject = \StringUtil::decodeEntities($varObject);
        }

        return htmlspecialchars($varObject,ENT_QUOTES,'UTF-8');
    }
}