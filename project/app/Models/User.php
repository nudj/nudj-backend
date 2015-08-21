<?php namespace App\Models;


use App\Models\Traits\Imageable;
use App\Models\Traits\Social;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Authenticator\Contracts\ShieldAuthServiceContract;
use App\Utility\Snafu;
use App\Utility\Transformers\UserTransformer;
use App\Utility\Util;
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
    protected $visible = ['id', 'phone', 'email', 'name', 'image', 'address', 'position', 'completed', 'status', 'about', 'settings', 'company', 'facebook_token', 'linkedin_token'];

    protected $gettableFields = ['id', 'phone', 'email', 'name', 'image', 'address', 'position', 'completed', 'about', 'settings', 'company',
        'facebook', 'linkedin', 'status', 'skills', 'contacts', 'favourite', 'contact'];
    protected $defaultFields = ['name'];

    protected $prefix = 'user.';


    public function __construct()
    {
        $this->aliases = UserTransformer::$aliases;
        $this->dependencies = UserTransformer::$dependencies;
    }

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
        return $this->belongsToMany('App\Models\User', 'user_favourites', 'user_id', 'favourite_id');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification', 'recipient_id');
    }

    public function devices()
    {
        return $this->hasMany('App\Models\Device', 'user_id');
    }

    public function chats()
    {
        return $this->belongsToMany('App\Models\Chat', 'chat_participants')->withPivot('mute');
    }



    /* CRUD
    ----------------------------------------------------- */

    public static function add($input, $mobile)
    {
        $user = new User();
        $user->phone = (string)$input['phone'];
        $user->country_code = (string)$input['country_code'];
        $user->mobile = (bool)$mobile;
        $user->token = (string)str_random(60);
        $user->verification = 1111; //(int)mt_rand(1000, 9999);
        $user->settings = json_encode(config('default.user_settings'));

        if(isset($input['name']))
            $user->name = (string)$input['name'];

        $user->save();

        return $user;
    }

    public static function login($input, $mobile = true)
    {

        $phoneData = Util::unifyPhoneNumber($input['phone'], $input['country_code']);

        $user = User::where('phone', '=', $phoneData->number)->active()->first();

        if ($user)
            return $user;

        $input['phone'] = $phoneData->number;
        $input['country_code'] = $phoneData->code;

        return self::add($input, $mobile);

    }

    public static function verify($input)
    {

        $phoneData = Util::unifyPhoneNumber($input['phone'], $input['country_code']);

        $user = User::where('phone', '=', $phoneData->number)
            ->where('verification', '=', $input['verification'])
            ->whereNull('deleted_at')
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

        //@TODO: refactor
        $favouritedUser = self::findOrFail($id);
        $currentUser = self::findOrFail($userId);


        if (!$favouritedUser)
            throw new ApiException(ApiExceptionType::$USER_MISSING);

        if (!$remove)
            $currentUser->favourites()->sync([$favouritedUser->id], false);
        else
            $currentUser->favourites()->detach($id);

        return true;
    }

    /* Checks
    ----------------------------------------------------- */
    public function isNotificationAllowed($notificationTypeId = null)
    {
        $settings = (object)json_decode($this->settings);

        if (isset($settings->notifications->$notificationTypeId) && !$settings->notifications->$notificationTypeId)
            return false;

        return true;
    }

    public function isAskedToRefer($jobId)
    {

        // @TODO: USE WHERE IN
        $referrals = Referral::where('job_id', '=', $jobId)->with('referrer')->get();

        $userIds = [];
        foreach ($referrals as $referral) {
            if (count($referral->referrer->user))
                $userIds[] = $referral->referrer->user->id;
        }


        return in_array($this->id, $userIds);

    }

    public function isNudged($jobId)
    {
        return false;

    }

    public function isFavouritedBy($userId)
    {
        $user = self::find($userId);

        return (bool) $user->favourites->contains($this->id);

    }


    /* Imposed by Contract in ApiUserRepository
    ----------------------------------------------------- */
    public function findByToken($token = null)
    {
        return $this->select(['id', 'roles', 'name'])
            ->where('token', '=', $token)
            ->whereNull('deleted_at')
            ->first();
    }

    // @TODO refactor and don;t overwrite parent, just use it
    public static function destroy($id)
    {
        Chat::deleteByParticipant($id);

        return parent::destroy($id);
    }

}
