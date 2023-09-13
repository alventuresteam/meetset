<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $setting = Setting::first();
        Config::set('ldap.connections.default.hosts', $setting->ldap_host);
        Config::set('ldap.connections.default.username', $setting->ldap_username);
        Config::set('ldap.connections.default.base_dn', $setting->ldap_base_dn);
        Config::set('ldap.connections.default.password', $setting->ldap_password);
        Config::set('ldap.connections.default.port', $setting->ldap_port);
        Config::set('ldap.connections.default.timeout', $setting->ldap_timeout);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
