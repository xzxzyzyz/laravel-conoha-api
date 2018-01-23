<?php

namespace Xzxzyzyz\ConohaAPI\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Xzxzyzyz\ConohaAPI\Facade\Conoha;
use Xzxzyzyz\ConohaAPI\Entities\MessageDetail as Message;

class MessageDetail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \Xzxzyzyz\ConohaAPI\ConohaClient
     */
    protected $client;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var string
     */
    protected $emailId;

    /**
     * @var string
     */
    protected $messageId;

    /**
     * @var mixed
     */
    protected $response = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($emailId, $messageId)
    {
        $this->emailId = $emailId;
        $this->messageId = $messageId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->response = Conoha::mailService()->getMessage($this->emailId, $this->messageId);
    }

    /**
     * @return \Xzxzyzyz\ConohaAPI\Entities\MessageDetail
     */
    public function getResponse()
    {
        $message = new Message($this->response->message);

        return $message;
    }
}
