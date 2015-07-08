<?php namespace App\Models;


use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Transformers\ContactTransformer;
use App\Utility\Util;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class Contact extends ApiModel
{
    public $timestamps = false;

    protected $table = 'contacts';
    protected $visible = ['id', 'phone', 'alias', 'user_id'];

    protected $gettableFields = ['id', 'phone', 'alias', 'favourite', 'user'];
    protected $defaultFields = ['phone', 'alias', 'favourite'];

    protected $prefix = 'contact.';

    public function __construct()
    {
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


    public static function addMissing($userId, $contactsList, $userCountryCode)
    {

        foreach ($contactsList as $record) {

            $record = (object)$record;

            if (!isset($record->phone) || !isset($record->alias))
                throw new ApiException(ApiExceptionType::$MISSING_PROPERTY);

            $phoneData = Util::unifyPhoneNumber($record->phone, $userCountryCode);
            $contact = Contact::where(['contact_of' => $userId, 'phone' => $phoneData->number])->first();

            if (!$contact) {

                $contact = new Contact();
                $contact->contact_of = $userId;
                $contact->alias = $record->alias;
                $contact->phone = $phoneData->number;
                $contact->country_code = $phoneData->code;
                $contact->suspicious = $phoneData->suspicious;

                if (isset($record->apple_id))
                    $contact->apple_id = $record->apple_id;

                $contact->save();
            }

        }
    }


    public static function findIfOwnedBy($contactId, $ownerId)
    {
        $contact = Contact::with('user')->find($contactId);

        if (isset($contact->user->id) && $ownerId == $contact->user->id)
            return $contact;

        return null;
    }


}
