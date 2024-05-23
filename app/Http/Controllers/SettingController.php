<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;
use App\Traits\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

class SettingController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return $this->success(['settings' => Setting::all()]);
        } catch (\Throwable $th) {
            return $this->failed([], $th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
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
        try {
            $setting = Setting::create($validated);
            return $this->success(['setting' => $setting]);
        } catch (\Throwable $th) {
            return $this->failed([], $th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        try {
            return $this->success(['setting' => $setting->first()]);
        } catch (\Throwable $th) {
            return $this->failed([], $th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingRequest $request, $id)
    {
        $validated = $request->validate([
            'key' => 'sometimes|required',
            'value' => 'sometimes|required',
        ]);
        try {
            if ($setting = Setting::find($id)) {
                $setting->update($validated);
                return $this->success(['setting' => $setting]);
            }
            return $this->failed([], 'Setting not found', Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            return $this->failed([], $th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            if (!!Setting::destroy($id)) {
                return $this->success([]);
            }
            return $this->failed([], 'Setting not found', Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            return $this->failed([], $th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
