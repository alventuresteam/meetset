<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function index()
    {
        $setting =  Setting::first();
        $setting->logo = $setting->getFirstMediaUrl('logo');

        return $setting;
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'ip_address' => 'required',
            'port' => 'required'
        ]);


        $setting = Setting::query()->first();

        if($request->has('logo')) {
            $logo = $request->file('logo');
            $setting->addMedia($logo)
                ->usingFileName(Str::uuid() .'.'. $logo->extension())
                ->toMediaCollection('logo');
        }

            $setting->update($request->only(['ip_address','port']));

        return response()->json(['success' => true]);
    }
}
