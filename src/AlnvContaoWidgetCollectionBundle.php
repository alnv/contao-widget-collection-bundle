<?php

namespace Alnv\ContaoWidgetCollectionBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AlnvContaoWidgetCollectionBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}