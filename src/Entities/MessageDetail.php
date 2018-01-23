<?php

namespace Xzxzyzyz\ConohaAPI\Entities;

class MessageDetail extends Entity
{
    /**
     * メッセージID
     *
     * @var string
     */
    public $message_id;

    /**
     * メッセージ
     *
     * @var string
     */
    public $message;

    /**
     * 添付ファイル
     *
     * @var array
     */
    public $attachments;
}