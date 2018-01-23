<?php

namespace Xzxzyzyz\ConohaAPI\Services\Mail;

use Xzxzyzyz\ConohaAPI\Entities\Domain;
use Xzxzyzyz\ConohaAPI\Entities\Email;
use Xzxzyzyz\ConohaAPI\Jobs\EmailList;
use Xzxzyzyz\ConohaAPI\Jobs\EmailStore;
use Xzxzyzyz\ConohaAPI\Jobs\EmailDestroy;

class EmailService
{
    /**
     * @var \Xzxzyzyz\ConohaAPI\Entities\Domain
     */
    protected $domain;

    /**
     * EmailService constructor.
     *
     * @param \Xzxzyzyz\ConohaAPI\Entities\Domain $domain
     */
    public function __construct(Domain $domain = null)
    {
        if (! is_null($domain)) {
            $this->setDomain($domain);
        }
    }

    /**
     * @param \Xzxzyzyz\ConohaAPI\Entities\Domain $domain
     */
    public function setDomain(Domain $domain)
    {
        $this->domain = $domain;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function all(array $options = [])
    {
        $job = new EmailList($this->domain->domain_id, $options);
        $job->handle();

        return $job->getResponse()->getCollection();
    }

    /**
     * @param $emailAddress
     * @return \Xzxzyzyz\ConohaAPI\Entities\Email;
     */
    public function find($emailAddress)
    {
        $emails = $this->all();

        $email = $emails->where('email', $emailAddress)->first();

        return $email;
    }

    /**
     * @param $emailAddress
     * @return \Xzxzyzyz\ConohaAPI\Entities\Email
     * @throws \Throwable
     */
    public function findOrFail($emailAddress)
    {
        $email = $this->find($emailAddress);

        throw_unless($email, 'Exception', 'Email is not found.');

        return $email;
    }

    /**
     * @param string $email
     * @param string $password
     * @return \Xzxzyzyz\ConohaAPI\Entities\Email;
     */
    public function create($email, $password)
    {
        $job = new EmailStore($this->domain->domain_id, $email, $password);
        $job->handle();

        return $job->getResponse();
    }

    /**
     * @param mixed $email
     * @return bool
     */
    public function destroy($email)
    {
        if ($email instanceof Email) {
            //
        }
        else {
            $email = $this->find($email);
        }

        if (empty($email)) {
            return false;
        }

        $job = new EmailDestroy($email->email_id);
        $job->handle();

        return true;
    }
}