<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api', 'namespace' => 'Api'], function() {

   Route::apiResource('domain', 'DomainController')
       ->only(['index', 'store', 'show', 'destroy']);

   Route::apiResource('domain/{domainId}/email', 'EmailController')
       ->only(['index', 'store', 'show', 'destroy']);

    Route::apiResource('domain/{domainId}/email/{emailId}/message', 'MessageController')
        ->parameters(['message' => 'messageId'])
        ->only(['index', 'store', 'show']);
});
