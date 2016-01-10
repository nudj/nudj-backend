### GET api/v1/jobs/search/{term?}

Description: Performs an Elastic Search against the job details

```
curl "http://localhost:8000/api/v1/jobs/search/Casting+instructor"
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