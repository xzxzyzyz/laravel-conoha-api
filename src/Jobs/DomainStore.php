<?php

namespace Xzxzyzyz\ConohaAPI\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Xzxzyzyz\ConohaAPI\Facade\Conoha;
use Xzxzyzyz\ConohaAPI\Entities\Domain;

class DomainStore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \Xzxzyzyz\ConohaAPI\ConohaClient
     */
    protected $client;

    /**
     * @var string
     */
    protected $domain;

    /**
     * @var mixed
     */
    protected $response = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($domain)
    {
        $this->domain = $domain;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $serviceId = Conoha::getServiceId();

        $this->response = Conoha::mailService()->postDomain($serviceId, $this->domain);
    }

    /**
     * @return \Xzxzyzyz\ConohaAPI\Entities\Domain
     */
    public function getResponse()
    {
        return new Domain($this->response->domain);
    }
}
