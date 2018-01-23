<?php

namespace Xzxzyzyz\ConohaAPI\Providers;

use Illuminate\Support\ServiceProvider;
use Xzxzyzyz\ConohaAPI\ConohaClient;

class ConohaServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('conoha.client', function ($app) {
            $data = [
                'username' => config('conoha.username'),
                'password' => config('conoha.password'),
                'tenantId' => config('conoha.tenant_id'),
                'serviceId' => config('conoha.service_id'),
                'originDomain' => 'conoha.io',
            ];

            $conoha =  new ConohaClient($data);

            return $conoha;
        });

        $this->app->alias('conoha.client', ConohaClient::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'conoha.client',
            ConohaClient::class,
        ];
    }
}