<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function search(Request $request)
    {
        return Contact::query()
            ->where('email','LIKE','%'.$request->get('q').'%')
            ->limit(10)
            ->pluck('email');
    }
}
