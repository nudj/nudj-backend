UUID: c965fca0-d0ad-47fa-a280-0d8e325e02c8

The elastic search is called 'nudge'

## What do we store?

Two pieces of data are stored in Elastic seach:

Job information

```
{
    'id' : $item->id,
    'type' : 'job',
    'index' : $index,
    'body' : [
         'title' : $item->title,
         'description' : $item->description,
         'user_id' : $item->user_id,
         'bonus' : $item->bonus,
         'active' : $item->active,
         'deleted' : $item->deleted_at ? 1 : 0,
         'skills' : array_column($item->skills->toArray(), 'name')
     ]    
}
```

Skill information

```
{
    'id' : $item->id,
    'type' : 'skill',
    'index' : $index,
    'body' : {
        'name' : $item->name
    }
}
``` 

The storage is done from class SearchEngineController, function repair.

## How do we store it?

The set of indices is created by giving to the client the following information

```
{
	"index" : "nudge",
	"body" : {
		"mappings" : { 
			"skill" : (skill)
			"job" : (job)
		}
	}
}
(skill) = [
    '_source' => [
        'enabled' => true
    ],
    'properties' => [
        'name' => [
            'type' => 'completion',
        ]
    ]
]
(job) = [
    '_source' => [
        'enabled' => true
    ],
    '_all' => [
        'enabled' => true
    ],
    'properties' => [
        'title' => [
            'type' => 'string',
            'index' => 'analyzed',
            'include_in_all' => true
        ],
        'description' => [
            'type' => 'string',
            'index' => 'analyzed',
            'include_in_all' => true
        ],
        'skills' => [
            'type' => 'string',
            'index' => 'analyzed',
            'include_in_all' => false
        ],
        'bonus' => [
            'type' => 'double',
            'index' => 'not_analyzed',
            'include_in_all' => false
        ],

        'active' => [
            'type' => 'integer',
            'index' => 'not_analyzed',
            'include_in_all' => false
        ],

        'deleted' => [
            'type' => 'integer',
            'index' => 'not_analyzed',
            'include_in_all' => false
        ],

        'user_id' => [
            'type' => 'integer',
            'index' => 'not_analyzed',
            'include_in_all' => false
        ]
    ]
]
```

## How do we query?

See Elasticsearch query DSL documentation: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl.html 

Code: 306f0fa3-3e64-4744-90bb-bda6c6c708ee

Example:

```
{
	"query": {
		"bool": {
			"must": [{
				"match": {
					"title": "Casting instructor"
				}
			}],
			"filter": [{
				"term": {
					"active": 1
				}
			}, {
				"term": {
					"deleted": 0
				}
			}]
		}
	}
}
```


