<?php

namespace Xzxzyzyz\ConohaAPI\Entities;

use Xzxzyzyz\ConohaAPI\Services\Mail\EmailService;

class Domain extends Entity
{
    /**
     * @var string
     */
    public $dkim;

    /**
     * @var string
     */
    public $service_id;

    /**
     * @var string
     */
    public $domain_id;

    /**
     * @var string
     */
    public $domain_name;

    /**
     * @return \Xzxzyzyz\ConohaAPI\Services\Mail\EmailService
     */
    public function emails()
    {
        return new EmailService($this);
    }
}