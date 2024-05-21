<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Setting::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSettingRequest $request)
    {
        $validated = $request->validate([
            'key' => 'required|unique:settings',
            'value' => 'required',
        ]);

        return Setting::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        return $setting->first();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        $validated = $request->validate([
            'key' => 'sometimes|required',
            'value' => 'sometimes|required',
        ]);
        $setting->update($validated);
        return $setting;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return Setting::destroy($id);
    }
}
