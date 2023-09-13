<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function search(Request $request)
    {
        $this->validate($request, [
            'q' => ['required']
        ]);
        return Contact::query()
            ->where('email','LIKE','%'.$request->get('q').'%')
            ->limit(10)
            ->pluck('email');
    }
}
