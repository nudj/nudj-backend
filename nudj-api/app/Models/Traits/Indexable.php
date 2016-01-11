<?php

namespace App\Models\Traits;

use App\Utility\Server;
use App\Utility\Snafu;
use Elasticsearch\Client;
use Illuminate\Support\Facades\Config;
use Log;

trait Indexable {

    protected $searchEngineClient;
    protected $searchEngineIndex;

    private function connect()
    {
        $this->searchEngineIndex = Config::get('cfg.elastic_index');

        if(!Server::getServerStatus(Config::get('cfg.elastic_ip'), Config::get('cfg.elastic_port')))
            return false;

        $this->searchEngineClient = new Client(['hosts' => Config::get('cfg.elastic_hosts')]);

    }

    public function addToIndex($type, $id, $body)
    {
        $this->connect();

        $data = [
            'index' => $this->searchEngineIndex,
            'type' => $type,
            'id' => $id,
            'body' => $body
        ];

        $this->searchEngineClient->index($data);
    }

    public function updateToIndex($type, $id, $body)
    {
        $this->connect();

        $data = [
            'index' => $this->searchEngineIndex,
            'type' => $type,
            'id' => $id,
            'body' => ['doc' => $body]
        ];

        $this->searchEngineClient->update($data);
    }

    public function softDeleteFromIndex($type, $id)
    {
       $this->updateToIndex($type, $id, ['deleted' => 1]);
    }

    public function deleteFromIndex($type, $id)
    {
        $this->connect();

        $data = [
            'index' => $this->searchEngineIndex,
            'type' => $type,
            'id' => $id,
        ];

        $this->searchEngineClient->delete($data);
    }

    public function suggestFromIndex($term, $type, $field)
    {
        $this->connect();

        $results = $this->searchEngineClient->suggest([
            'index' => $this->searchEngineIndex,
            'body' => [
                $type => [
                    'text' => $term,
                    'completion' => [
                        'field' => $field
                    ]
                ]
            ]
        ]);

        $suggestions = [];
        foreach ($results[$type][0]['options'] as $result) {
            $suggestions[] = $result['text'];
        }

        return $suggestions;
    }

    public function searchIndex($type, $term)
    {

    	// marker: 306f0fa3-3e64-4744-90bb-bda6c6c708ee

        $this->connect();

        $body['query']['bool']['must'][]['match'] = ['title' => $term];
        $body['query']['bool']['filter'][]['term'] = ['active' => 1];
        $body['query']['bool']['filter'][]['term'] = ['deleted' => 0];

        // Log::debug(json_encode($body));

        /*
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
        */

        Snafu::show($body, 'searchQuery');

        $results = $this->searchEngineClient->search([
            'index' => $this->searchEngineIndex,
            'type' => $type,
            'body' => $body
        ]);

        // Log::debug(json_encode($results));

        /*
			{
				"took": 2,
				"timed_out": false,
				"_shards": {
					"total": 5,
					"successful": 5,
					"failed": 0
				},
				"hits": {
					"total": 1,
					"max_score": 4.2286663,
					"hits": [{
						"_index": "nudge",
						"_type": "job",
						"_id": "3",
						"_score": 4.2286663,
						"_source": {
							"title": "Casting instructor ",
							"description": "Man who advises and guide the candidates for a film ",
							"user_id": 3,
							"bonus": 500,
							"active": 1,
							"deleted": 0,
							"skills": ["\u200bgardening", "\u200bacting", "\u200bfilming"]
						}
					}]
				}
			}
        */

        Snafu::show($results, 'searchResults');

        if (!isset($results['hits']['hits']) || empty($results['hits']['hits']))
            return [];

        $answer = array_column($results['hits']['hits'], '_id');
        return $answer;

        // $answer : ["3"] # array of identifiers

    }

}