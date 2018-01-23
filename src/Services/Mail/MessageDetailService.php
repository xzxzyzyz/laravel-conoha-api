<?php

namespace Xzxzyzyz\ConohaAPI\Services\Mail;

use Xzxzyzyz\ConohaAPI\Entities\Message;
use Xzxzyzyz\ConohaAPI\Jobs\MessageDetail;

class MessageDetailService
{
    /**
     * @var \Xzxzyzyz\ConohaAPI\Entities\Message
     */
    protected $message;

    /**
     * MessageService constructor.
     *
     * @param \Xzxzyzyz\ConohaAPI\Entities\Message $message
     */
    public function __construct(Message $message = null)
    {
        if (! is_null($message)) {
            $this->setMessage($message);
        }
    }

    /**
     * @param \Xzxzyzyz\ConohaAPI\Entities\Message $message
     */
    public function setMessage(Message $message)
    {
        $this->message = $message;
    }

    /**
     * @return \Xzxzyzyz\ConohaAPI\Entities\MessageDetail;
     */
    public function get()
    {
        $job = new MessageDetail($this->message->email_id, $this->message->message_id);
        $job->handle();

        return $job->getResponse();
    }
}