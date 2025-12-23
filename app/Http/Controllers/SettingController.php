<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{

    public function index(Request $request)
    {
        $auth = authResource($request);
        return Inertia::render('Admin/Setting/index', compact('auth'));
    }



    public function getAttendence(Request $request)
    {
        $admin = $request->user('web');
        $company_id = $admin->company_id;
        $prop = Setting::DAY_LIMIT;
        return Setting::getModel($company_id, $prop);
    }

    public function attendenceStore(Request $request)
    {
        $admin = $request->user('web');
        $company_id = $admin->company_id;
        $request->validate([
            'start' => ['required', 'string'],
            'end' => ['required', 'string'],
        ]);
        $prop = Setting::DAY_LIMIT;
        $value = $request->toArray();
        Setting::updateOrCreate(compact('company_id', 'prop'), compact('value'));
    }
}
