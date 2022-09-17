<?php

namespace App\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Jenssegers\Optimus\Optimus;

/**
 * @method static int encode(int $value)
 */
class Snowflake extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return Optimus::class;
    }
}
