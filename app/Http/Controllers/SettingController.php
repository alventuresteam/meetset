<?php

namespace App\Http\Controllers;

use App\Classes\ICS;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\CalendarLinks\Link;

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

    public function ics()
    {
       $ics = new ICS();
       $start = '2023-04-10 18:00';
       $end = '2023-04-10 21:00';


       $ics->setOrganizer('Elchin','azer.m@al.ventures');
       $ics->setParticipiants([
           'azer.m@al.ventures',
           'ahmad.r@bestcomp.net'
       ]);

        $ics->ICS(
            $start,
            $end,
            'Event Name',
            'Description here',
            'Baku'
        );
       $ics->save();
    }
}
