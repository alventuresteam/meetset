<?php

namespace App\Http\Controllers;

use App\Ldap\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class HomeController extends Controller
{
    public function index() {

        Config::set('ldap.connections.default.hosts', env('LDAP_HOST', '127.0.0.1'));
        Config::set('ldap.connections.default.username', env('LDAP_USERNAME', 'cn=user,dc=local,dc=com'));
        Config::set('ldap.connections.default.base_dn', env('LDAP_BASE_DN', 'dc=local,dc=com'));
        Config::set('ldap.connections.default.password', env('LDAP_PASSWORD', 'secret'));
        Config::set('ldap.connections.default.port', env('LDAP_PORT', 389));
        Config::set('ldap.connections.default.timeout', env('LDAP_TIMEOUT', 5));

        $ldapContacts =  Contact::query()
            ->select('mail','name')
            ->get();

        dd($ldapContacts[0]);
    }
}
