## API (v1) Endpoints documentation

Note: The returned JSON answers will be pretty printed, but only for convenience, they are not pretty printed by the server

Note: Unless otherwise specified, keys are mandatory (only optional keys will be highlighted as such)

Note: An example of answer will be given when this doesn't prevent understanding. Otherwise the full grammar will be given.

- [GET     api/v1/chat/all](xf1258)
- [GET     api/v1/chat/319](xf1259)
- [GET     api/v1/jobs/search/{term?}](xf1001)
- [GET     api/v1/jobs/{filter}](xf1830)
- [GET     api/v1/jobs/{id}](xf1837)
- [POST    api/v1/jobs](xf1306)
- [PUT     api/v1/jobs/{id}](xf1528)
- [PUT     api/v1/jobs/{id}/like](xf1634)
- [DELETE  api/v1/jobs/{id}](xf1554)
- [DELETE  api/v1/jobs/{id}/like](xf1649)

.

- [GET     api/v1/users](xf1826)
- [GET     api/v1/users/{userid}](xf1825)
- [GET     api/v1/users/exists/{userid}](xf1841)
- [GET     api/v1/users/{userid}/contacts](xf1844)
- [GET     api/v1/users/{userid}/favourites](xf1848)
- [POST    api/v1/users](xf1905)
- [PUT     api/v1/users/{userid?}](xf2250)
- [PUT     api/v1/users/verify](xf1827)
- [PUT     api/v1/users/{userid}/favourite](xf1856)
- [DELETE  api/v1/users/{userid?}](xf0937)
- [DELETE  api/v1/users/{userid}/favourite](xf1201)

.

- [PUT     api/v1/nudge](xf1251)
- [PUT     api/v1/nudge/ask](xf1408)
- [PUT     api/v1/nudge/apply](xf1428)
- [PUT     api/v1/nudge/chat](xf1443)

.

- [GET     api/v1/contacts/mine](xf1901)
- [POST    api/v1/contacts/{id}/invite](xf1904)
- [PUT     api/v1/contacts/{id}](xf1902)
- [DELETE  api/v1/contacts/{id}](xf1903)

.

- [GET     api/v1/config](xf1536)
- [GET     api/v1/notifications/test](xf2112)
- [PUT     api/v1/notifications/{id}/read](xf1537)

.

- [GET     api/v1/config](xf1559)
- [GET     api/v1/config/{key}](xf1606)

.

- [GET     api/v1/countries](xf1618)

.

- [GET     api/v1/skills/suggest/{term}](xf1629)

.

- [GET     api/v1/nsx300/send-sms-notification-to-number](xf1257)