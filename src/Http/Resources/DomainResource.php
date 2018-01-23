<?php

namespace Xzxzyzyz\ConohaAPI\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class DomainResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'dkim' => $this->dkim,
            'service_id' => $this->service_id,
            'domain_id' => $this->domain_id,
            'domain_name' => $this->domain_name,
        ];
    }
}
