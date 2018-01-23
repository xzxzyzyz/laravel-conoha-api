<?php

namespace Xzxzyzyz\ConohaAPI\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Xzxzyzyz\ConohaAPI\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Route::bind('domain', function ($domain) {
            $service = new \Xzxzyzyz\ConohaAPI\Services\Mail\DomainService;

            return $service->findorFail($domain);
        });

        Route::bind('email', function ($email, \Illuminate\Routing\Route $route) {
            $domain = $route->parameter('domain');

            if (is_null($domain)) {
                $domain = $route->parameter('domainId');
            }

            return $domain->emails()->findorFail($email);
        });

        Route::bind('domainId', function ($domainId, \Illuminate\Routing\Route $route) {
            $domain = new \Xzxzyzyz\ConohaAPI\Entities\Domain(['domain_id' => $domainId]);

            if (! $route->hasParameter('domain')) {
                $route->setParameter('domain', $domain);
            }

            return $domain;
        });

        Route::bind('emailId', function ($emailId, \Illuminate\Routing\Route $route) {
            $email =  new \Xzxzyzyz\ConohaAPI\Entities\Email(['email_id' => $emailId]);

            if (! $route->hasParameter('email')) {
                $route->setParameter('email', $email);
            }

            $email->domain_id = optional($route->parameter('domain'))->domain_id;

            return $email;
        });

        Route::bind('messageId', function ($messageId, \Illuminate\Routing\Route $route) {
            $message =  new \Xzxzyzyz\ConohaAPI\Entities\Message(['message_id' => $messageId]);

            if (! $route->hasParameter('message')) {
                $route->setParameter('message', $message);
            }

            $message->domain_id = optional($route->parameter('domain'))->domain_id;
            $message->email_id = optional($route->parameter('email'))->email_id;

            return $message;
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        //
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__.'/../Http/api.php');
    }
}
