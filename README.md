# Laravel Japanese Validation


ConohaのAPIをLaravelで利用する (メール機能)

Laravel 5.5+

## Installation

```bash
composer require xzxzyzyz/laravel-conoha-api
```

※[keika299/chap](https://github.com/ezaki/chap)が必要だが現在非公開なので、ソースコードをダウンロードして`composer.json`へ追加して読み込む

```json
...
    "psr-4": {
        "App\\": "app/",
        "keika299\\ConohaAPI\\": "chap/src/"
    }
...
```

`config/app.php`へ追加

```php
    'providers' => [

        ...
        Xzxzyzyz\ConohaAPI\Providers\ConohaServiceProvider::class,
        Xzxzyzyz\ConohaAPI\Providers\RouteServiceProvider::class,

    ],
    
    ...
    
    'aliases' => [
    
        ...
        'Conoha' => Xzxzyzyz\ConohaAPI\Facade\Conoha::class,
    ],
```

`.env`へ追加

```env
CONOHA_SERVICE_ID=your_service_id # サーバー ->サーバー情報 -> UUID
CONOHA_TENANT_ID=your_tenant_id # API -> テナント情報 -> テナントID
CONOHA_API_USERNAME=your_api_username # API -> APIユーザー -> ユーザー名
CONOHA_API_PASSWORD=your_api_password # API -> APIユーザー -> パスワード
```

`config/conoha.php`

```php
<?php

return [
    'service_id' => env('CONOHA_SERVICE_ID'),
    'tenant_id' => env('CONOHA_TENANT_ID'),
    'username' => env('CONOHA_API_USERNAME'),
    'password' => env('CONOHA_API_PASSWORD'),

    'domain' => [
        'ignore_origin' => true
    ],

    'email' => [
        'auto_password' => true
    ]
];

```

## Usage

### ドメイン

|#|URL|METHOD|PARAMS|
|:---|:---|:---|:---|
|一覧|GET|api/domain| |
|作成|POST|api/domain|domain_name:ドメイン名|
|参照|GET|api/domain/{domain_name}| |
|削除|DELETE|api/domain/{domain_name}| |


### メールアドレス

`domian_id`はドメイン作成時にConoha上で作成されるドメインID (UUID)

|#|URL|METHOD|PARAMS|
|:---|:---|:---|:---|
|一覧|GET|api/domain/{domain_id}/email| |
|作成|POST|api/domain/{domain_id}/email|email:メールアドレス, password:パスワード|
|参照|GET|api/domain/{domain_id}/email/{email}| |
|削除|DELETE|api/domain/{domain_id}/email/{email}| |


### メッセージ

`email_id`はドメイン作成時にConoha上で作成されるメールID (UUID)

|#|URL|METHOD|PARAMS|
|:---|:---|:---|:---|
|一覧|GET|api/domain/{domain_id}/email/{email_id}/message| |
|参照|GET|api/domain/{domain_id}/email/{email_id}/message/{message_id}| |

※ routeについては`RouteServiceProvider`で読み込んでいる[api.php](https://github.com/xzxzyzyz/larave-conoha-api/src/Http/api.php)を参照


## Events

|#|EVENT|
|:---|:---|
|ドメイン作成時|\Xzxzyzyz\ConohaAPI\Events\DomainCreatedEvent|
|ドメイン削除時|\Xzxzyzyz\ConohaAPI\Events\DomainDeletedEvent|
|メールアドレス作成時|\Xzxzyzyz\ConohaAPI\Events\EmailCreatedEvent|
|メールアドレス削除時|\Xzxzyzyz\ConohaAPI\Events\EmailDeletedEvent|