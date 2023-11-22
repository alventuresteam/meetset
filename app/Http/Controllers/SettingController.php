<?php

namespace App\Http\Controllers;

use App\Classes\ICS;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class SettingController extends Controller
{
    public function index()
    {
        $setting =  Setting::first();
        $setting->logo = $setting->getFirstMediaUrl('logo');
        $setting->logo_dark = $setting->getFirstMediaUrl('logo_dark');

        return $setting;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function updateServer(Request $request): JsonResponse
    {
        $this->validate($request, [
            'ip_address' => ['sometimes'],
            'port' => ['sometimes'],
            'kiosk_password' => ['sometimes'],
            'checked_invited' => ['sometimes'],
        ]);

        $setting = Setting::query()->first();

        $setting->update($request->only([
            'ip_address',
            'kiosk_password',
            'checked_invited',
            'port'
        ]));

        return response()->json(['success' => true]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function updateLoginPage(Request $request): JsonResponse
    {
        $this->validate($request, [
            'login_text' => ['sometimes'],
        ]);

        $setting = Setting::query()->first();

        if($request->has('logo')) {
            $logo = $request->file('logo');
            $setting->addMedia($logo)
                ->usingFileName(Str::uuid() .'.'. $logo->extension())
                ->toMediaCollection('logo');
        }

        if($request->has('logo_dark')) {
            $logoDark = $request->file('logo_dark');
            $setting->addMedia($logoDark)
                ->usingFileName(Str::uuid() .'.'. $logoDark->extension())
                ->toMediaCollection('logo_dark');
        }

        $setting->update($request->only([
            'login_text'
        ]));

        return response()->json(['success' => true]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function updateEmployer(Request $request): JsonResponse
    {
        $this->validate($request, [
            'type' => ['sometimes'],
            'ldap_host' => ['sometimes'],
            'ldap_username' => ['sometimes'],
            'ldap_password' => ['sometimes'],
            'ldap_port' => ['sometimes'],
            'ldap_base_dn' => ['sometimes'],
            'ldap_timeout' => ['sometimes'],
        ]);

        $setting = Setting::query()->first();

        $setting->update($request->only([
            'type',
            'ldap_host',
            'ldap_username',
            'ldap_password',
            'ldap_port',
            'ldap_base_dn',
            'ldap_timeout',
        ]));

        return response()->json(['success' => true]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request): JsonResponse
    {
        $this->validate($request, [
            'type' => ['sometimes'],
            'ip_address' => ['sometimes'],
            'port' => ['sometimes'],
            'ldap_host' => ['sometimes'],
            'ldap_username' => ['sometimes'],
            'ldap_password' => ['sometimes'],
            'ldap_port' => ['sometimes'],
            'ldap_base_dn' => ['sometimes'],
            'ldap_timeout' => ['sometimes'],
        ]);


        $setting = Setting::query()->first();

        if($request->has('logo')) {
            $logo = $request->file('logo');
            $setting->addMedia($logo)
                ->usingFileName(Str::uuid() .'.'. $logo->extension())
                ->toMediaCollection('logo');
        }

            $setting->update($request->only([
                'type',
                'ip_address',
                'port',
                'ldap_host',
                'ldap_username',
                'ldap_password',
                'ldap_port',
                'ldap_base_dn',
                'ldap_timeout',
            ]));

        return response()->json(['success' => true]);
    }

    /**
     * @return void
     */
    public function ics(): void
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
