<?php namespace App\Http\Controllers;

use App\Http\Requests\ApiRequest;
use App\Http\Requests\ApplyRequest;
use App\NSX300\NSX300_ApplicationsX1;
use App\NSX300\NSX300_Configuration;
use Illuminate\Support\Facades\Mail;

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
        $jobid    = $request->jobIdentifier;
        $uuid = NSX300_ApplicationsX1::insertRecord($jobid,$name,$email,$link,$referrer,$request->ip());
        return response()->json([
            'success' => true,
            'application-uuid' => $uuid
        ]);
    }

    public function sendLinkToCandidate($applicationuuid){
        $application = NSX300_ApplicationsX1::getApplicationDetailsByUUID_orNull($applicationuuid);
        $jobId = $application['jobid'];
        $name = $application['name'];
        $emailAddress = $application['email'];
        $urlToJobPage = NSX300_Configuration::getApplicationURL().'/job/'.$jobId;
        Mail::send('emails.welcome', ['link' => $urlToJobPage], function($message){
            $message->to('pascal@alseyn.net', '');
            $message->from('no-reply@nudj.co', 'no-reply@nudj.co');
            $message->subject('Nudj job application');
        });
        Log::info("email sent to $emailAddress");
        return response()->json([
            'success' => true
        ]);
    }

}

