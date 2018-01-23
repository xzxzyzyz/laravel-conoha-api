<?php

namespace Xzxzyzyz\ConohaAPI\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Xzxzyzyz\ConohaAPI\Http\Resources\EmailResource;
use Xzxzyzyz\ConohaAPI\Entities\Domain;
use Xzxzyzyz\ConohaAPI\Entities\Email;
use Xzxzyzyz\ConohaAPI\Http\Requests\EmailStoreRequest;
use Xzxzyzyz\ConohaAPI\Events\EmailCreatedEvent;
use Xzxzyzyz\ConohaAPI\Events\EmailDeletedEvent;

class EmailController extends Controller
{
    public function __construct()
    {
        // Password auto creator
        if (config('conoha.email.auto_password')) {
            $this->middleware(\Xzxzyzyz\ConohaAPI\Http\Middleware\AutoCreateEmailPassword::class)->only('store');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Xzxzyzyz\ConohaAPI\Entities\Domain $domain
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Domain $domain)
    {
        $emails = $domain->emails()->all();

        return EmailResource::collection($emails);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Xzxzyzyz\ConohaAPI\Entities\Domain $domain
     * @param  \Xzxzyzyz\ConohaAPI\Http\Requests\EmailStoreRequest  $request
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function store(EmailStoreRequest $request, Domain $domain)
    {
        $email = $domain->emails()->create($request->input('email'), $request->input('password'));

        // Fire email created event.
        event(new EmailCreatedEvent($email));

        return EmailResource::make($email);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Xzxzyzyz\ConohaAPI\Entities\Domain $domain
     * @param  \Xzxzyzyz\ConohaAPI\Entities\Email $email
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function show(Request $request, Domain $domain, Email $email)
    {
        return EmailResource::make($email);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Xzxzyzyz\ConohaAPI\Entities\Domain $domain
     * @param  \Xzxzyzyz\ConohaAPI\Entities\Email $email
     * @return @return \Illuminate\Http\Resources\Json\Resource
     */
    public function destroy(Request $request, Domain $domain, Email $email)
    {
        $domain->emails()->destroy($email);

        // Fire email deleted event.
        event(new EmailDeletedEvent($email));

        return EmailResource::make($email);
    }
}
