<?php

namespace App\Models\Traits;

use App\Utility\Server;
use App\Utility\Snafu;
use Elasticsearch\Client;
use Illuminate\Support\Facades\Config;

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
        $this->connect();

        $query['query']['match']['_all'] = $term;
        $query['filter']['bool']['must'][]['term'] = ['active' => 1, 'deleted' => 0];

        Snafu::show($query, 'searchQuery');

        $results = $this->searchEngineClient->search([
            'index' => $this->searchEngineIndex,
            'type' => $type,
            'body' => $query
            ]);

        Snafu::show($results, 'searchResults');

        if (!isset($results['hits']['hits']) || empty($results['hits']['hits']))
            return [];

        return array_column($results['hits']['hits'], '_id');
    }

}