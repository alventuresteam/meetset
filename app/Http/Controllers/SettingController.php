<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return Setting::first();
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'ip_address' => 'required',
            'port' => 'required'
        ]);

        Setting::query()
            ->first()
            ->update($request->only(['ip_address','port']));

        return response()->json(['success' => true]);
    }
}
