<?php

use App\Models\NotificationType;

return [

    // General Errors
    NotificationType::$ASK_TO_REFER => ':employer : :message',
    NotificationType::$APP_APPLICATION => ':candidate referred by :referrer is interested in the :position position',
    NotificationType::$WEB_APPLICATION => ':candidate referred by :referrer is interested in the :position position',
    NotificationType::$MATCHING_CONTACT => ':candidate might be a good match for the position of :job, posted by :employer',
    NotificationType::$APP_APPLICATION_NOREF => ':candidate is interested in the :position position',
    NotificationType::$WEB_APPLICATION_NOREF => ':candidate is interested in the :position position',

];
