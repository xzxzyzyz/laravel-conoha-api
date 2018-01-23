<?php

namespace Xzxzyzyz\ConohaAPI\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Xzxzyzyz\ConohaAPI\Services\Mail\DomainService;
use Xzxzyzyz\ConohaAPI\Http\Resources\DomainResource;
use Xzxzyzyz\ConohaAPI\Entities\Domain;
use Xzxzyzyz\ConohaAPI\Http\Requests\DomainStoreRequest;
use Xzxzyzyz\ConohaAPI\Events\DomainCreatedEvent;
use Xzxzyzyz\ConohaAPI\Events\DomainDeletedEvent;

class DomainController extends Controller
{
    /**
     * @var \Xzxzyzyz\ConohaAPI\Services\Mail\DomainService
     */
    protected $domain;

    /**
     * DomainController constructor.
     *
     * @param \Xzxzyzyz\ConohaAPI\Services\Mail\DomainService $domain
     */
    public function __construct(DomainService $domain)
    {
        $this->domain = $domain;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $domains = $this->domain->all();

        return DomainResource::collection($domains);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Xzxzyzyz\ConohaAPI\Http\Requests\DomainStoreRequest  $request
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function store(DomainStoreRequest $request)
    {
        // TODO: Illuminate\Validation\ValidationException
        $existDomain = $this->domain->find($request->input('domain_name'));

        if (! empty($existDomain)) {
            $errors = ['domain_name' => ['Already registered.']];
            return response()->json(['errors' => $errors], 422);
        }

        $domain = $this->domain->create($request->input('domain_name'));

        // Fire domain created event.
        event(new DomainCreatedEvent($domain));

        return DomainResource::make($domain);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Xzxzyzyz\ConohaAPI\Entities\Domain $domain
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function show(Domain $domain)
    {
        return DomainResource::make($domain);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Xzxzyzyz\ConohaAPI\Entities\Domain $domain
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function destroy($domain)
    {
        $this->domain->destroy($domain);

        // Fire domain deleted event.
        event(new DomainDeletedEvent($domain));

        return DomainResource::make($domain);
    }
}
