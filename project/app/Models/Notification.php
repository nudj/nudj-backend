<?php namespace App\Models;

use App\Utility\Transformers\NotificationTransformer;

class Notification extends ApiModel {

    protected $table = 'notifications';
    protected $visible = ['type_id', 'meta', 'read'];

    protected $gettableFields = ['type', 'message', 'read'];
    protected $defaultFields = ['type', 'message', 'read'];

    protected $prefix = 'notify.';

    public function __construct() {
        $this->dependencies = NotificationTransformer::$dependencies;
    }

    /* Relations
    ----------------------------------------------------- */
    public function recipient()
    {
        return $this->belongsTo('App\Models\User', 'recipient_id');
    }

    public function sender()
    {
        return $this->belongsTo('App\Models\User', 'sender_id');
    }


    /* CRUD
    ----------------------------------------------------- */

}
