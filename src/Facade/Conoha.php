<?php

namespace Xzxzyzyz\ConohaAPI\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Xzxzyzyz\ConohaAPI\Conoha
 */
class Conoha extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'conoha.client';
    }
}