<?php

namespace Xzxzyzyz\ConohaAPI\Services\Mail;

use Xzxzyzyz\ConohaAPI\Jobs\DomainList;
use Xzxzyzyz\ConohaAPI\Jobs\DomainStore;
use Xzxzyzyz\ConohaAPI\Jobs\DomainDestroy;
use Xzxzyzyz\ConohaAPI\Entities\Domain;

class DomainService
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function all(array $options = [])
    {
        $job = new DomainList($options);
        $job->handle();

        return $job->getResponse()->getCollection();
    }

    /**
     * @param string $domainName
     * @return \Xzxzyzyz\ConohaAPI\Entities\Domain
     */
    public function find($domainName)
    {
        $domains = $this->all();

        $domain = $domains->where('domain_name', $domainName)->first();

        return $domain;
    }

    /**
     * @param $domainName
     * @return \Xzxzyzyz\ConohaAPI\Entities\Domain
     * @throws \Throwable
     */
    public function findOrFail($domainName)
    {
        $domain = $this->find($domainName);

        throw_unless($domain, 'Exception', 'Domain is not found.');

        return $domain;
    }

    /**
     * @param string $domainName
     * @return \Xzxzyzyz\ConohaAPI\Entities\Domain
     */
    public function create($domainName)
    {
        $job = new DomainStore($domainName);
        $job->handle();

        return $job->getResponse();
    }

    /**
     * @param mixed $domainName
     * @return bool
     */
    public function destroy($domain)
    {
        if ($domain instanceof Domain) {
            //
        }
        else {
            $domain = $this->find($domain);
        }

        if (empty($domain)) {
            return false;
        }

        $job = new DomainDestroy($domain->domain_id);
        $job->handle();

        return true;
    }
}