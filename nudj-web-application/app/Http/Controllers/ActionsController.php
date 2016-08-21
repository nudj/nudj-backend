<?php namespace App\Http\Controllers;

use App\Http\Requests\ApiRequest;
use App\Http\Requests\ApplyRequest;
use App\NSX300\NSX300_ApplicationsX1;

use Log;

class ActionsController extends \Illuminate\Routing\Controller
{

    // -------------------------------------------------------------------
    // New implementation

    public function applicationDetails(ApplyRequest $request) {
        //Log::info("nameInput    : ".$request->nameInput);
        //Log::info("emailInput   : ".$request->emailInput);
        //Log::info("linkInput    : ".$request->linkInput);
        //Log::info("referrerInput: ".$request->referrerInput);
        $name     = $request->nameInput;
        $email    = $request->emailInput;
        $link     = $request->linkInput;
        $referrer = $request->referrerInput;
        NSX300_ApplicationsX1::insertRecord($name,$email,$link,$referrer,$request->ip());
        return response()->json([
            'success' => $request->all()
        ]);
    }
}

