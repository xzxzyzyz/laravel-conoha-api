<?php

namespace Xzxzyzyz\ConohaAPI\Services\Mail;

use Xzxzyzyz\ConohaAPI\Entities\Domain;
use Xzxzyzyz\ConohaAPI\Entities\Email;
use Xzxzyzyz\ConohaAPI\Jobs\MessageList;
use Xzxzyzyz\ConohaAPI\Jobs\MessageDetail;

class MessageService
{
    /**
     * @var \Xzxzyzyz\ConohaAPI\Entities\Email
     */
    protected $email;

    /**
     * EmailService constructor.
     *
     * @param \Xzxzyzyz\ConohaAPI\Entities\Email $email
     */
    public function __construct(Email $email = null)
    {
        if (! is_null($email)) {
            $this->setEmail($email);
        }
    }

    /**
     * @param \Xzxzyzyz\ConohaAPI\Entities\Email $email
     */
    public function setEmail(Email $email)
    {
        $this->email = $email;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function all(array $options = [])
    {
        $job = new MessageList($this->email->email_id, $options);
        $job->handle();

        $messages = $job->getResponse()->getCollection();

        $messages->transform(function ($item) {
            $item->domain_id = $this->email->domain_id;

            return $item;
        });

        return $messages;
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