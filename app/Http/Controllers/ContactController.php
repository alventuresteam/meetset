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

    /**
     * @return Collection
     */
    public function index(): Collection
    {
        $setting = Setting::first();

        if ($setting->type == 'ldap') {
            return Contact::query()->pluck('email');
        } else{
            return Contact::query()->pluck('email');
        }
    }
}
