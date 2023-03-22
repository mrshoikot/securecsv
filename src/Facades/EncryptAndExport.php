<?php

namespace Mrshoikot\EncryptAndExport\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mrshoikot\EncryptAndExport\EncryptAndExport
 */
class EncryptAndExport extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Mrshoikot\EncryptAndExport\EncryptAndExport::class;
    }
}
