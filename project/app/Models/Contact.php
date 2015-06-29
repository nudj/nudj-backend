<?php namespace App\Models;


use App\Utility\ImageHelper;
use App\Utility\Transformers\ContactTransformer;
use App\Utility\Util;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends ApiModel
{
    public $timestamps = false;

    protected $table = 'contacts';
    protected $visible = ['id', 'phone', 'alias', 'user_id'];

    protected $gettableFields = ['id', 'phone', 'alias', 'favourite', 'user'];
    protected $defaultFields = ['phone', 'alias', 'favourite'];

    protected $prefix = 'contact.';

    public function __construct() {
        $this->dependencies = ContactTransformer::$dependencies;
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function contact()
    {
        return $this->belongsTo('App\Models\User', 'contact_of');
    }

    public function edit($input)
    {

        if (isset($input['alias']))
            $this->alias = (string)$input['alias'];

        if (isset($input['favourite']))
            $this->favourite = (string)$input['favourite'];

        if (isset($input['mute']))
            $this->mute = (string)$input['mute'];

        return $this->save();
    }


    public static function addMissing($userId, $list)
    {
        foreach($list as $phone => $alias) {

            $contact = Contact::where(['contact_of' => $userId, 'phone' => $phone])->first();

            if (!$contact) {
                $contact = new Contact;
                $contact->phone = $phone;
                $contact->contact_of = $userId;
                $contact->alias = $alias;
                $contact->save();
            }

        }
    }

    public static function findIfOwnedBy($contactId, $ownerId)
    {
        $contact = Contact::with('user')->find($contactId);

        if(isset($contact->user->id) && $ownerId == $contact->user->id)
            return $contact;

        return null;
    }


}
