<?php


use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum', 'web']], function(){
    Route::get('account/onboarding/{id}', 'AccountController@onboarding')->name('account.onboarding');
    Route::get('account/dashboard/{id}', 'AccountController@dashboard')->name('account.dashboard');
});
Route::post('webhook/connect', 'WebhookConnectController@handleWebhook')->name('webhook.connect');
