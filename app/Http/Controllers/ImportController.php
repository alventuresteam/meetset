<?php

namespace App\Http\Controllers;

use App\Imports\ContactsImport;
use App\Ldap\Contact;
use Illuminate\Http\Request;
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
        $ldapContacts =  Contact::query()
            ->select('mail','name')
            ->get();

        foreach($ldapContacts as $contact) {
            ContactEloquent::query()->updateOrCreate([
                'email' => $contact['mail'][0]
            ],[
                'name' => Str::before($contact['name'][0],' '),
                'surname' => Str::after($contact['name'][0],' '),
            ]);
        }
        return response()->json();
    }
}
