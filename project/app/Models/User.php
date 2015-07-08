<?php namespace App\Models;


use App\Models\Traits\Imageable;
use App\Models\Traits\Social;
use App\Utility\Authenticator\Contracts\ShieldAuthServiceContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class User extends ApiModel implements ShieldAuthServiceContract
{
    use SoftDeletes;
    use Imageable;
    use Authenticatable;
    use Social;

    protected $table = 'users';
    protected $visible = ['id', 'phone', 'email', 'name', 'image', 'address', 'position', 'completed', 'status', 'about', 'settings'];

    protected $gettableFields = ['id', 'phone', 'email', 'name', 'image', 'address', 'position', 'completed', 'about', 'settings', 'status', 'skills', 'contacts', 'favourite'];
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

    public function likes()
    {
        return $this->belongsToMany('App\Models\Job', 'job_likes');
    }

    public function favourites()
    {
        return $this->belongsToMany('App\Models\User', 'user_favourites');
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
    public static function login($input, $mobile = true)
    {
        $user = User::where('phone', '=', $input['phone'])->first();

        if (!$user) {
            $user = new User;
            $user->phone = (string)$input['phone'];
            $user->country_code = (string)$input['country_code'];
            $user->token = (string)str_random(60);
            $user->verification = 1111; //(int)mt_rand(1000, 9999);
            $user->mobile = (bool)$mobile;
            $user->settings = json_encode(Config::get('cfg.user_default_settings'));
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

        if (isset($input['country_code']))
            $this->country_code = (string)$input['country_code'];

        if (isset($input['name']))
            $this->name = (string)$input['name'];

        if (isset($input['position']))
            $this->position = (string)$input['position'];

        if (isset($input['address']))
            $this->address = (string)$input['address'];

        if (isset($input['company']))
            $this->company = (string)$input['company'];

        if (isset($input['about']))
            $this->about = $input['about'];

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


    /* GET
    ----------------------------------------------------- */
    public function getBelongingContact($belongsTo = null)
    {
        return Contact::where('user_id', $this->id)
            ->where('contact_of', $belongsTo)
            ->first();
    }


    /* Sync
    ----------------------------------------------------- */
    private function syncSkills($skillList)
    {
        $ids = Skill::addMissing($skillList);
        $this->skills()->sync($ids);

        return $ids;
    }

    private function syncContacts($contactList)
    {

        Contact::addMissing($this->id, $contactList, $this->country_code);
    }

    private function syncSettings($settingsList)
    {

        if ($this->settings)
            $settingsList = array_replace(json_decode($this->settings, true), $settingsList);

        return json_encode($settingsList);
    }


    /* Modify actions
    ----------------------------------------------------- */
    public static function favourite($id, $userId, $remove = false)
    {

        $user = self::find($id);

        if (!$user)
            return false;

        if (!$remove)
            $user->favourites()->sync([$userId], false);
        else
            $user->favourites()->detach($id);

        return true;
    }

    /* Checks
    ----------------------------------------------------- */
    public function isNotificationAllowed($notificationTypeId = null)
    {
        $settings = (object)json_decode($this->settings);

        if (isset($settings->notifications->$notificationTypeId))
            return $settings->notifications->$notificationTypeId;

        return false;
    }

    public function isAskedToRefer($jobId)
    {

        return true;

        // @TODO: USE WHERE IN
        $referrals = Referral::where('job_id', '=', $jobId)->with('referrer')->get();

        $userIds = [];
        foreach($referrals as $referral) {
            if (count($referral->referrer->user))
                $userIds[] = $referral->referrer->user->id;
        }

        return in_array($this->id, $userIds);

    }

    public function isNudged($jobId)
    {

        return true;

        return DB::table('nudges')
            ->where('candidate_id', $this->id)
            ->where('job_id', $jobId)
            ->count();

    }



    /* Imposed by Contract in ApiUserRepository
    ----------------------------------------------------- */
    public function findByToken($token = null)
    {
        return $this->select(['id', 'roles'])->where('token', '=', $token)->first();
    }

}
