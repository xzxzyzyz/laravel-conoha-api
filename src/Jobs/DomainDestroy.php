<?php

namespace Xzxzyzyz\ConohaAPI\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Xzxzyzyz\ConohaAPI\Facade\Conoha;

class DomainDestroy implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \Xzxzyzyz\ConohaAPI\ConohaClient
     */
    protected $client;

    /**
     * @var string
     */
    protected $domainId;

    /**
     * @var mixed
     */
    protected $response;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($domainId)
    {
        $this->domainId = $domainId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->response = Conoha::mailService()->deleteDomain($this->domainId);
    }

}
