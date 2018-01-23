<?php

namespace Xzxzyzyz\ConohaAPI\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class EmailResource extends Resource
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
            'domain_id' => $this->domain_id,
            'email_id' => $this->email_id,
            'email' => $this->email,
            'virus_check' => $this->virus_check,
            'spam_filter' => $this->spam_filter,
            'spam_filter_type' => $this->spam_filter_type,
            'forwarding_copy' => $this->forwarding_copy,
            'dkim' => $this->dkim
        ];
    }
}
