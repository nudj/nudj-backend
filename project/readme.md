# nudj-api

Laravel Framework version 5.0.34

Note: When env is set to LOGGING we have the logging of the request and their answers. (The Api Controller fires up the corresponding events.)  

## NUDJ API (v1)

```
NUDJ API (v1):

	// JOBS
	GET     api/v1/jobs/search/{term?}
    GET     api/v1/jobs/{filter}
    GET     api/v1/jobs/{id}
    POST    api/v1/jobs
    PUT     api/v1/jobs/{id}
    DELETE  api/v1/jobs/{id}
    PUT     api/v1/jobs/{id}/like
    DELETE  api/v1/jobs/{id}/like

    // USERS
    GET     api/v1/users
    GET     api/v1/users/{userid}
    POST    api/v1/users
    PUT     api/v1/users/{userid?}
    DELETE  api/v1/users/{userid}
    PUT     api/v1/users/verify
    GET     api/v1/users/exists/{userid}
    GET     api/v1/users/{userid}/contacts
    GET     api/v1/users/{userid}/favourites
    PUT     api/v1/users/{userid}/favourite
    DELETE  api/v1/users/{userid}/favourite

    // NUDGE
    PUT     api/v1/nudge
    PUT     api/v1/nudge/ask
    PUT     api/v1/nudge/apply
    PUT     api/v1/nudge/chat

    // CONTACTS
    GET     api/v1/contacts/mine
    PUT     api/v1/contacts/{id}
    DELETE  api/v1/contacts/{id}
    POST    api/v1/contacts/{id}/invite

    //CHAT
    GET     api/v1/chat/{filter}
    GET     api/v1/chat/{id}
    DELETE  api/v1/chat/{id}
    PUT     api/v1/chat/{id}/archive
    DELETE  api/v1/chat/{id}/archive
    PUT     api/v1/chat/{id}/mute
    DELETE  api/v1/chat/{id}/mute
    PUT     api/v1/chat/notification

    // NOTIFICATION
    GET     api/v1/notifications
    PUT     api/v1/notifications/{id}/read

    // SOCIAL
    PUT     api/v1/connect/facebook
    PUT     api/v1/connect/linkedin
    DELETE  api/v1/connect/facebook
    DELETE  api/v1/connect/linkedin

    // CONFIG
    GET     api/v1/config
    GET     api/v1/config/{key}

    // MISC
    GET     api/v1/countries
    PUT     api/v1/devices
    POST    api/v1/feedback
    GET     api/v1/skills/suggest/{term?}

    // SERVICE
    GET     api/v1/elastic/repair
    GET     api/v1/cloud/empty

    // TEMP
    GET     api/v1/services/test
	GET     api/v1/services/message

    PUT     api/v1/chat
    DELETE  api/v1/chat/all

```



