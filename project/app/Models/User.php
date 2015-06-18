<?php namespace App\Models;


use App\Models\Traits\Imageable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends ApiModel
{
    use SoftDeletes, Imageable;

    protected $table = 'users';
    protected $visible = ['id', 'phone', 'email', 'name', 'image', 'address', 'position', 'completed', 'status', 'about', 'findme'];

    protected $gettableFields = ['id', 'phone', 'email', 'name', 'image', 'address', 'position', 'completed', 'about', 'findme', 'status', 'skills', 'contacts'];
    protected $defaultFields = ['name'];

    protected $prefix = 'user.';


    /* Relations
    ----------------------------------------------------- */
    public function skills()
    {
        return $this->belongsToMany('App\Models\Skill', 'user_skill');
    }

    public function contacts()
    {
        return $this->hasMany('App\Models\Contact', 'contact_of');
    }

    public function jobs()
    {
        return $this->hasMany('App\Models\Job', 'user_id');
    }

    public function favourites()
    {
        return $this->belongsToMany('App\Models\Job', 'job_favourites');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification', 'recipient_id');
    }

    public function devices()
    {
        return $this->hasMany('App\Models\Device', 'user_id');
    }

    /* CRUD
    ----------------------------------------------------- */
    public static function login($input)
    {
        $user = User::where('phone', '=', $input['phone'])->first();

        if (!$user) {
            $user = new User;
            $user->phone = (string)$input['phone'];
            $user->token = (string)str_random(60);
            $user->verification = (int)mt_rand(1000, 9999);
            $user->save();
        }

        return $user;
    }

    public static function verify($input)
    {
        $user = User::where('phone', '=', $input['phone'])
            ->where('verification', '=', $input['verification'])
            ->first();

        if ($user) {
            $user->verified = true;
            $user->save();

            return $user;
        }

        return false;
    }

    public function edit($input)
    {

        if (isset($input['email']))
            $this->email = (string)$input['email'];

        if (isset($input['phone']))
            $this->phone = (string)$input['phone'];

        if (isset($input['name']))
            $this->name = (string)$input['name'];

        if (isset($input['position']))
            $this->position = (string)$input['position'];

        if (isset($input['address']))
            $this->address = (string)$input['address'];

        if (isset($input['findme']))
            $this->findme = (string)json_encode($input['findme']);

        if (isset($input['about']))
            $this->about = (string)json_encode($input['about']);

        if (isset($input['completed']))
            $this->completed = (string)$input['completed'];

        if (isset($input['status']))
            $this->status = (int)$input['status'];

        if (isset($input['skills']))
            $this->syncSkills($input['skills']);

        if (isset($input['contacts']))
            $this->syncContacts($input['contacts']);

        if (isset($input['settings']))
            $this->settings = $this->syncSettings($input['settings']);

        if (isset($input['image'])) {
           $images = $this->updateImage($input['image']);
           $this->image = json_encode($images);
        }

        $this->save();

        return $this;
    }


    private function syncSkills($skillList)
    {
        $ids = Skill::addMissing($skillList);
        $this->skills()->sync($ids);

        return $ids;
    }

    private function syncContacts($contactList)
    {
        Contact::addMissing($this->id, $contactList);
    }

    private function syncSettings($settingsList)
    {
        $settings = json_encode($settingsList);

        return $settings;
    }


}
