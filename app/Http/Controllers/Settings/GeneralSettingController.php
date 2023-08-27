<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings\GeneralSetting;

class GeneralSettingController extends Controller
{
    public function index()
    {
        try {
            $data = GeneralSetting::first();
            return view('settings.general_setting', compact('data'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            if (!$request->id) {
                $request->validate([
                    'name' => 'required',
                    'website' => 'required',
                    'email' => 'required',
                    'phone' => 'required',
                    'address' => 'required',
                    'favicon' => 'required',
                    'logo' => 'required',
                ]);

                $data = new GeneralSetting();
            } else {
                $data = GeneralSetting::findOrFail($request->id);
            }
            if ($request->file('logo')) {
                $file = $request->file('logo');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'), $filename);
                $data->logo = $filename;
            }
            if ($request->file('favicon')) {
                $file = $request->file('favicon');
                $filenamefavicon = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'),  $filenamefavicon);
                $data->favicon =  $filenamefavicon;
            }
            $data->name = $request->name;
            $data->website = $request->website;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $data->map = $request->map;
            $data->description = $request->description;

            if (!$request->id) {
                $data->save();
                return redirect()->route('general-settings')->with('success', ' General settings created successfull');
            } else {
                $data->update();
                return redirect()->route('general-settings')->with('success', 'General settings updated successfull');
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
