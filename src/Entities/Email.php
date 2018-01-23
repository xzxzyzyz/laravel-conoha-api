<?php

namespace Xzxzyzyz\ConohaAPI\Entities;

use Xzxzyzyz\ConohaAPI\Services\Mail\MessageService;

class Email extends Entity
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
     * メールアドレス
     *
     * @var string
     */
    public $email;

    /**
     * パスワード
     *
     * @var string
     */
    public $password;

    /**
     * true:ウィルスチェック有効、false:ウィルスチェック無効
     *
     * @var string
     */
    public $virus_check;

    /**
     * true:迷惑メールフィルタ有効、false:迷惑メールフィルタ無効
     *
     * @var string
     */
    public $spam_filter;

    /**
     * subject:スパムメールに件名を付与する、tray:スパムメールをスパムディレクトリに隔離する
     *
     * @var string
     */
    public $spam_filter_type;

    /**
     * true:転送メールを受信トレイに残す、false:転送メールを受信トレイに残さない
     *
     * @var string
     */
    public $forwarding_copy;

    /**
     * 設定済:TXTレコードを表示 未設定:空
     *
     * @var string
     */
    public $dkim;

    /**
     * @return \Xzxzyzyz\ConohaAPI\Services\Mail\MessageService
     */
    public function messages()
    {
        return new MessageService($this);
    }
}