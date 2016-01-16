## API (v1) Endpoints documentation

Note: The returned JSON answers will be pretty printed, but only for convenience, they are not pretty printed by the server

Note: Unless otherwise specified, keys are mandatory (only optional keys will be highlighted as such)

Note: An example of answer will be given when this doesn't prevent understanding. Otherwise the full grammar will be given.

- [GET  api/v1/jobs/search/{term?}](xf1001)
- [GET  api/v1/jobs/{filter}](xf1830)
- [GET  api/v1/jobs/{id}](xf1837)
- [POST api/v1/jobs](xf1306)
- [PUT  api/v1/jobs/{id}](xf1528)

.

- [GET  api/v1/users](xf1826)
- [GET  api/v1/users/{userid}](xf1825)
- [PUT  api/v1/users/verify](xf1827)

.

- [GET  api/v1/users/exists/{userid}](xf1841)
- [GET  api/v1/users/{userid}/contacts](xf1844)
- [GET  api/v1/users/{userid}/favourites](xf1848)
- [PUT  api/v1/users/{userid}/favourite](xf1856)
- [GET  api/v1/contacts/mine](xf1901)