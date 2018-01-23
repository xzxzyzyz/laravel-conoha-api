<?php

namespace Xzxzyzyz\ConohaAPI\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Xzxzyzyz\ConohaAPI\Facade\Conoha;
use Xzxzyzyz\ConohaAPI\Entities\Message;
use Illuminate\Pagination\LengthAwarePaginator;

class MessageList implements ShouldQueue
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
     * @var integer
     */
    protected $limit = 1000;

    /**
     * @var integer
     */
    protected $offset = 0;

    /**
     * @var integer
     */
    protected $currentPage = 1;

    protected $sortType = 'desc';

    /**
     * @var mixed
     */
    protected $response = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($emailId, array $options = [])
    {
        $this->emailId = $emailId;
        $this->options = $options;

        if (isset($this->options['limit'])) {
            $this->limit = $this->options['limit'];
        }

        if (isset($this->options['page'])) {
            $this->currentPage = (int) $this->options['page'];

            if ($this->currentPage > 1) {
                $this->offset = $this->limit * ($this->currentPage - 1);
            }
        }

        if (isset($this->options['sortType'])) {
            $this->limit = $this->options['sortType'];
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $options = array_merge($this->options, [
            'limit' => $this->limit,
            'offset' => $this->offset,
            'sort_type' => $this->sortType,
        ]);

        $this->response = Conoha::mailService()->getMessageList($this->emailId, $options);
    }

    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getResponse()
    {
        $arrMessages = array_map(function($domain) {
            $message = new Message($domain);
            $message->merge(['email_id' => $this->emailId]);

            return $message;
        }, $this->response->messages);

        $messages = collect($arrMessages);

        $paginator = new LengthAwarePaginator($messages, $this->response->total_count, $this->limit, $this->currentPage);

        return $paginator;
    }
}
