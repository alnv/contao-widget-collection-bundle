<?php

namespace Alnv\ContaoWidgetCollectionBundle\Helpers;


class VDataContainer extends \DataContainer {


    public function __construct() {

        parent::__construct();
    }


    protected function save( $varValue ) {

        return null;
    }


    public function getPalette() {

        return '';
    }
}