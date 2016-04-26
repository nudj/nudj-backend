<?php

namespace App\Http\Controllers\Desk;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use App\Models\User;
use App\NSX300\NSX300_AdminUserOperations_v1 as NSX300_AdminUserOperations_v1;

class UsersController extends DeskController
{

    public function index()
    {
        return view('desk/pages/users/list');
    }

    public function show($id)
    {
        $records = User::findOrFail($id);

        if(NSX300_AdminUserOperations_v1::true_if_user_identified_by_id_is_currently_blocked_by_admin($id)){
            $userBlockedDisplay = '<div style="background-color:red;padding:10px;color:white;margin:10px 0px 20px 0px;">User in blocked by admin</div>';            
        }else{
            $userBlockedDisplay = '';
        }

        if(NSX300_AdminUserOperations_v1::true_if_user_identified_by_id_is_currently_a_special_access_1_user($id)){
            $userSpecialAccessDisplay = '<div style="background-color:#FF00FF;padding:10px;color:white;margin:10px 0px 20px 0px;">User hash special access v1</div>';            
        }else{
            $userSpecialAccessDisplay = '';
        }


        $params = [
            "user" => $records,
            "jobs" => $records->jobs()->count(),
            "user_job" => \App\Models\Job::where('user_id', '=', $id)->get(),
            "applications" => \App\Models\Application::where('candidate_id', '=', $id)->get(),
            "userBlockedDisplay" => $userBlockedDisplay,
            "userSpecialAccessDisplay" => $userSpecialAccessDisplay,
            "true_if_user_is_blocked" => NSX300_AdminUserOperations_v1::true_if_user_identified_by_id_is_currently_blocked_by_admin($id) ? 'true' : 'false',
            "true_if_user_is_special_access_1" => NSX300_AdminUserOperations_v1::true_if_user_identified_by_id_is_currently_a_special_access_1_user($id) ? 'true' : 'false'
        ];

        return view('desk/pages/users/show', $params);
    }

    public function ajax_update_user($id){
        $user = User::find($id);
        if (!$user){
            return '[false]';
        }

        $input = Input::all();

        if (isset($input['email']))
            $user->email = (string)$input['email'];

        if (isset($input['phone']))
            $user->phone = (string)$input['phone'];

        if (isset($input['country_code']))
            $user->country_code = (string)$input['country_code'];

        if (isset($input['name']))
            $user->name = (string)$input['name'];

        if (isset($input['position']))
            $user->position = (string)$input['position'];

        if (isset($input['address']))
            $user->address = (string)$input['address'];

        if (isset($input['company']))
            $user->company = (string)$input['company'];

        if (isset($input['about']))
            $user->about = $input['about'];

        if (isset($input['completed']))
            $user->completed = (string)$input['completed'];

        if (isset($input['status']))
            $user->status = (int)$input['status'];

        $user->save();

        return '[true]';
    }

    public function admin_block_user($userid){
        NSX300_AdminUserOperations_v1::block_user($userid);
        return '[true]';
    }

    public function admin_unblock_user($userid){
        NSX300_AdminUserOperations_v1::unblock_user($userid);
        return '[true]';
    }

    public function admin_enable_special_access($userid){
        NSX300_AdminUserOperations_v1::enable_special_access($userid);
        return '[true]';
    }

    public function admin_disable_special_access($userid){
        NSX300_AdminUserOperations_v1::disable_special_access($userid);
        return '[true]';
    }

}