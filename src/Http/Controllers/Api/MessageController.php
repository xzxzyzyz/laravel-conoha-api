<?php

namespace Xzxzyzyz\ConohaAPI\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Xzxzyzyz\ConohaAPI\Http\Resources\MessageResource;
use Xzxzyzyz\ConohaAPI\Http\Resources\MessageDetailResource;
use Xzxzyzyz\ConohaAPI\Entities\Domain;
use Xzxzyzyz\ConohaAPI\Entities\Email;
use Xzxzyzyz\ConohaAPI\Entities\Message;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Xzxzyzyz\ConohaAPI\Entities\Domain $domain
     * @param  \Xzxzyzyz\ConohaAPI\Entities\Email $email
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Domain $domain, Email $email)
    {
        $messages = $email->messages()->all();

        return MessageResource::collection($messages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \Xzxzyzyz\ConohaAPI\Entities\Domain $domain
     * @param  \Xzxzyzyz\ConohaAPI\Entities\Email $email
     * @param  \Xzxzyzyz\ConohaAPI\Entities\Message $message
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function show(Domain $domain, Email $email, Message $message)
    {
        $messageDetail = $message->detail()->get();

        return MessageDetailResource::make($messageDetail);
    }
}
