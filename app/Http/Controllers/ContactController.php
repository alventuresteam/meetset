<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function search(Request $request): Collection
    {
        $this->validate($request, [
            'q' => ['required']
        ]);
        return Contact::query()
            ->where('email','LIKE','%'.$request->get('q').'%')
            ->limit(10)
            ->pluck('email');
    }

    public function index()
    {
        $setting = Setting::first();

        return Contact::query()->pluck('email');
    }
}
