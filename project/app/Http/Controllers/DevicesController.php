<?php namespace App\Http\Controllers;

use App\Http\Requests\RegisterDeviceRequest;
use App\Models\Device;
use App\Http\Requests;
use App\Utility\Facades\Shield;

class DevicesController extends ApiController
{

    public function register(RegisterDeviceRequest $request)
    {
        $device = Device::add(Shield::getUserId(), $request->all());

        return $this->respondWithStatus($device->id);
    }

}
