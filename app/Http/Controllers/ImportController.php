<?php

namespace App\Http\Controllers;

use App\Imports\ContactsImport;
use App\Ldap\Contact;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Contact as ContactEloquent;
class ImportController extends Controller
{
    public function importFromExcel(Request $request)
    {
        $this->validate($request, [
            'file' => ['required','file']
        ]);

        Excel::import(new ContactsImport, $request->file('file')->store('files'));

        return response()->json();
    }

    public function importFromLdap()
    {
//        $setting = Setting::first();
//        Config::set('ldap.connections.default.hosts', $setting->ldap_host);
//        Config::set('ldap.connections.default.username', $setting->ldap_username);
//        Config::set('ldap.connections.default.base_dn', $setting->ldap_base_dn);
//        Config::set('ldap.connections.default.password', $setting->ldap_password);
//        Config::set('ldap.connections.default.port', $setting->ldap_port);
//        Config::set('ldap.connections.default.timeout', $setting->ldap_timeout);
//        $ldapContacts =  Contact::query()
//            ->select('mail','name')
//            ->get();
//
//        foreach($ldapContacts as $contact) {
//            if(isset($contact['mail'][0])) {
//                ContactEloquent::query()->updateOrCreate([
//                    'email' => $contact['mail'][0]
//                ],[
//                    'name' => Str::before($contact['name'][0],' '),
//                    'surname' => Str::after($contact['name'][0],' '),
//                ]);
//            }
//
//        }
        return response()->json();
    }
}
