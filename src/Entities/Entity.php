<?php

namespace Xzxzyzyz\ConohaAPI\Entities;

use Illuminate\Contracts\Support\Arrayable;

class Entity implements Arrayable
{
    /**
     * Entity constructor.
     *
     * @param mixed $attributes
     */
    public function __construct($attributes)
    {
        $this->merge($attributes);
    }

    /**
     * @param mixed $attributes
     * @return void
     */
    public function merge($attributes)
    {
        $attributes = ($attributes instanceof Arrayable) ? $attributes->toArray() : (array) $attributes;

        foreach ($attributes as $property => $value) {
            if (property_exists($this, $property)) {
                if ($value === '') {
                    $value = null;
                }

                $this->{$property} = $value;
            }
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
}