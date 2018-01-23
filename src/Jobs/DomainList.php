<?php

namespace Xzxzyzyz\ConohaAPI\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Xzxzyzyz\ConohaAPI\Facade\Conoha;
use Xzxzyzyz\ConohaAPI\Entities\Domain;
use Illuminate\Pagination\LengthAwarePaginator;

class DomainList implements ShouldQueue
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
     * @var boolean
     */
    protected $ignore;

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
    public function __construct(array $options = [], $ignore = false)
    {
        $this->options = $options;
        $this->ignore = $ignore;

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
        $options = array_merge($this->options, ['service_id' => Conoha::getServiceId(), 'limit' => $this->limit, 'offset' => $this->offset]);

        $this->response = Conoha::mailService()->getDomainList($options);
    }

    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getResponse()
    {
        $arrDomains = array_map(function($domain) {
            return new Domain($domain);
        }, $this->response->domains);

        $domains = collect($arrDomains);

        if (config('conoha.domain.ignore_origin') || $this->ignore) {
            $originDomain = Conoha::getOriginDomain();

            $domains = $domains->reject(function ($domain) use ($originDomain) {
                return ends_with($domain->domain_name, $originDomain);
            })->values();
        }

        $paginator = new LengthAwarePaginator($domains, $this->response->total_count, $this->limit, $this->currentPage);

        return $paginator;
    }
}
