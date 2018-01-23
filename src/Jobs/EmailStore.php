<?php

namespace Xzxzyzyz\ConohaAPI\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Xzxzyzyz\ConohaAPI\Facade\Conoha;
use Xzxzyzyz\ConohaAPI\Entities\Email;

class EmailStore implements ShouldQueue
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
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var mixed
     */
    protected $response = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($domainId, $email, $password)
    {
        $this->domainId = $domainId;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->response = Conoha::mailService()->postEmail($this->domainId, $this->email, $this->password);
    }

    /**
     * @return \Xzxzyzyz\ConohaAPI\Entities\Email
     */
    public function getResponse()
    {
        $email = new Email($this->response->email);
        $email->merge(['password' => $this->password]);

        return $email;
    }
}
