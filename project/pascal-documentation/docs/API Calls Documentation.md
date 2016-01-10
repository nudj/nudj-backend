### GET api/v1/jobs/search/{term?}

Description: Performs an Elastic Search against the job details

```
curl --header "token:nD3a0i6S0OehXwVnANEAHhqjnofPAR7AzXOGDwPSlP5voqndSWoa9PFLR7TU" \
    "http://localhost:8000/api/v1/jobs/search/Casting+instructor"
```

Answer (Example):

```
{
    "data": [{
        "id": "3",
        "title": "Casting instructor ",
        "user": {
            "id": "3",
            "name": "Lachezar Todorov"
        }
    }],
    "count": 1,
    "timestamp": 1452417473.1581
}
```

Answer (Formal): Essentially an array of job titles and corresponding users.

### GET api/v1/users

Description: Lists the users, results are returned with pagination.

```
curl --header "token:nD3a0i6S0OehXwVnANEAHhqjnofPAR7AzXOGDwPSlP5voqndSWoa9PFLR7TU" \
    http://localhost:8000/api/v1/users
```

```
{
	"data": [{
		"id": "1",
		"name": "Lachezar Todorov"
	}, {
		"id": "2",
		"name": "Lacho"
	}, {
		"id": "3",
		"name": "Lachezar Todorov"
	}, {
		"id": "4",
		"name": "Antonio Tester"
	}, {
		"id": "5",
		"name": "Eugene Kouumdjieff"
	}, {
		"id": "6",
		"name": "Eleanor H"
	}, {
		"id": "7",
		"name": "Nicolas Leclercq"
	}, {
		"id": "8",
		"name": "Robyn "
	}, {
		"id": "9",
		"name": "Imriel Morgan"
	}, {
		"id": "10",
		"name": "Imriel Morgan"
	}],
	"pagination": {
		"total": 196,
		"count": 10,
		"next": "/api/v1/users/?page=2",
		"previous": false
	},
	"timestamp": 1452451244.759
}
```

### GET api/v1/users/{userid}

Description: Returns information on a given user

Request:

```
curl --header "token:nD3a0i6S0OehXwVnANEAHhqjnofPAR7AzXOGDwPSlP5voqndSWoa9PFLR7TU" \
    http://localhost:8000/api/v1/users/1
```

Answer:

```
{
	"data": {
		"id": "1",
		"name": "Lachezar Todorov"
	},
	"timestamp": 1452451924.4747
}
```

Request:

```
curl --header "token:nD3a0i6S0OehXwVnANEAHhqjnofPAR7AzXOGDwPSlP5voqndSWoa9PFLR7TU" \
    http://localhost:8000/api/v1/users/me
```

Answer:

```
{
	"data": {
		"id": "188",
		"name": "Robyn McGirl"
	},
	"timestamp": 1452451924.4747
}
```

Request:

```
curl --header "token:nD3a0i6S0OehXwVnANEAHhqjnofPAR7AzXOGDwPSlP5voqndSWoa9PFLR7TU" \
    http://localhost:8000/api/v1/users/1000000
```

Answer:

```
{
	"error": {
		"message": "User not found in our database",
		"code": 14201
	},
	"timestamp": 1452452071.6972
}
```

### PUT api/v1/users/verify

Context: When a user downloads the app, they provide (manually) their phone number. A record is created in the database for that phone number, a four digit pin is generated that is saved against the phone number, and the four digit pin is sent by sms to the phone number. 

Then if/when a `verify` call is made that contains both the phone number and the correct pin, the user record is set to "verified".

See API call description for more details.

Description: Performs the step of verifying a user.

Request: 

```
curl -X PUT \
    -d phone=07920549291 \
    -d country_code=GB \
    -d verification=5153 \
    http://localhost:8000/api/v1/users/verify
```
Answer:

```
{
	"status": true,
	"data": {
		"id": 188,
		"token": "nD3a0i6S0OehXwVnANEAHhqjnofPAR7AzXOGDwPSlP5voqndSWoa9PFLR7TU",
		"completed": true
	},
	"timestamp": 1452454228.3914
}
```

Request: 

```
curl -X PUT \
    -d phone=07920549291 \
    -d country_code=GB \
    -d verification=3802 \ 
    http://localhost:8000/api/v1/users/verify
```

Answer:

```
{
	"error": {
		"message": "Wrong Verification Code",
		"code": 14101
	},
	"timestamp": 1452454333.3674
}
```