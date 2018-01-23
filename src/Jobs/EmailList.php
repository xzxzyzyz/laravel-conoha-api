<?php

namespace Xzxzyzyz\ConohaAPI\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Xzxzyzyz\ConohaAPI\Facade\Conoha;
use Xzxzyzyz\ConohaAPI\Entities\Email;
use Illuminate\Pagination\LengthAwarePaginator;

class EmailList implements ShouldQueue
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
    protected $domainId;

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

    /**
     * @var mixed
     */
    protected $response = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($domainId, array $options = [])
    {
        $this->domainId = $domainId;
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
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $options = array_merge($this->options, ['domain_id' => $this->domainId, 'limit' => $this->limit, 'offset' => $this->offset]);

        $this->response = Conoha::mailService()->getEmailList($options);
    }

    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getResponse()
    {
        $arrEmails = array_map(function($domain) {
            return new Email($domain);
        }, $this->response->emails);

        $emails = collect($arrEmails);

        $paginator = new LengthAwarePaginator($emails, $this->response->total_count, $this->limit, $this->currentPage);

        return $paginator;
    }
}
