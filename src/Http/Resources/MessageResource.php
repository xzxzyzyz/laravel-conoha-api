<?php

namespace Xzxzyzyz\ConohaAPI\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MessageResource extends Resource
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
            'message_id' => $this->message_id,
            'from' => $this->from,
            'subject' => $this->subject,
            'date' => $this->date,
            'size' => $this->size,
        ];
    }
}
