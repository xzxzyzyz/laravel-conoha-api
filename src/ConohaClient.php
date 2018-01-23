<?php

namespace Xzxzyzyz\ConohaAPI;

use keika299\ConohaAPI\Conoha as Base;

class ConohaClient extends Base
{
    /**
     * Get service id
     *
     * @return string|null
     */
    public function getServiceId()
    {
        return $this->data['serviceId'];
    }

    /**
     * Get service id
     *
     * @return string|null
     */
    public function getOriginDomain()
    {
        return $this->data['originDomain'];
    }
}