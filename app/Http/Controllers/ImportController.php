<?php

namespace App\Http\Controllers;

use App\Imports\ContactsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
}
