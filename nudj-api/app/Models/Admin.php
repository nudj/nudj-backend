<?php

/*
	This class provides facilities to add new admins and edit (more exactly update)
	the attributes of an existing admin.
*/

namespace App\Models;

use App\Models\Contracts\HasRolesContract;
use App\Models\Traits\HasRoles;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Hash;

class Admin extends Model implements AuthenticatableContract, CanResetPasswordContract, HasRolesContract
{

    use Authenticatable, CanResetPassword, HasRoles;

    protected $table = 'admins';

    protected $fillable = ['name', 'email', 'password', 'roles'];

    protected $hidden = ['password', 'remember_token'];

    public static function add($request){
        $admin = new Admin();
        $admin->name = (string)$request->name;
        $admin->email = (string)$request->email;
        $admin->password = (string)Hash::make($request->password);
        $admin->save();
        return $admin;
    }

    public function edit($data)
    {

        if (isset($data['name']))
            $this->name = (string)$data['name'];

        if (isset($data['email']))
            $this->email = (string)$data['email'];

        if (strlen($data['password']) > 0)
            $this->password = (string)Hash::make($data['password']);

        $this->save();

        return true;
    }

}
