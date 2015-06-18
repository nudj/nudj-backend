<?php namespace App\Http\Controllers;

use App\Http\Requests\RegisterDeviceRequest;
use App\Models\Device;
use App\Http\Requests;


class DevicesController extends ApiController
{

    public function register(RegisterDeviceRequest $request)
    {
        $device = Device::add($this->authenticator->getUserId(), $request->all());

        return $this->respondWithStatus($device->id);
    }


}
