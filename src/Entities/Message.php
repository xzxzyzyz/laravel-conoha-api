<?php

namespace Xzxzyzyz\ConohaAPI\Entities;

use Xzxzyzyz\ConohaAPI\Services\Mail\MessageDetailService;

class Message extends Entity
{
    /**
     * ドメインID
     *
     * @var string
     */
    public $domain_id;

    /**
     * メールID
     *
     * @var string
     */
    public $email_id;

    /**
     * メッセージID
     *
     * @var string
     */
    public $message_id;

    /**
     * 送信者
     *
     * @var string
     */
    public $from;

    /**
     * 件名
     *
     * @var string
     */
    public $subject;

    /**
     * メール受信日付
     *
     * @var string
     */
    public $date;

    /**
     * メールサイズ
     *
     * @var string
     */
    public $size;

    /**
     * @return \Xzxzyzyz\ConohaAPI\Services\Mail\MessageDetailService
     */
    public function detail()
    {
        return new MessageDetailService($this);
    }
}