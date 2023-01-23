<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Microsoft\Graph\Graph;

class MicrosoftService
{
    protected $token = null;
    protected $tenant_id = '1bc7d8af-adb5-4aca-a275-4ca8185f8bb2';

    protected $app_id = 'ee58b5d2-1097-498e-b1bb-0a956260b511';
    protected $app_secret = 'WJa8Q~_KhHCdO.57VDi2rxKg_DUhQlMrLYluYbYU';
    public function login() {
        return Http::asForm()->post('https://login.microsoftonline.com/'.$this->tenant_id.'/oauth2/token', [
                'grant_type' => 'client_credentials',
                'client_id' => $this->app_id,
                'client_secret' => $this->app_secret,
                'resource' => 'https://graph.microsoft.com'
        ])->json()['access_token'];
    }
    public function subscribe()
    {
        $token = $this->login();

       return Http::withHeaders([
           'Authorization' => 'Bearer '.$token
       ])
        ->post('https://graph.microsoft.com/v1.0/subscriptions', [
            "changeType" => "created,updated",
            "notificationUrl" => "https://xxxxx.ngrok.io/notification-url",
            "resource" => "/me/calendar/events",
            "expirationDateTime" => "2018-11-14T09:40:10.933Z",
            "clientState"=>  "xee58b5d2-1097-498e-b1bb-0a956260b511"
        ])->json();
    }
}
