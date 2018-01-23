<?php

namespace Xzxzyzyz\ConohaAPI\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MessageDetailResource extends Resource
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
            'message_id' => $this->message_id,
            'message' => $this->message,
            'attachments' => $this->attachments,
        ];
    }
}
