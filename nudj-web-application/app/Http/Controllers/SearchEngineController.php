<?php namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Skill;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Facades\Shield;
use Elasticsearch\Client;
use Illuminate\Support\Facades\Config;

/*
	This controller performs the update of the ... TODO: 
*/

class SearchEngineController extends ApiController
{

    protected $types = ['skill', 'job'];

    public function repair()
    {
        if (!Shield::hasRole('admin'))
            throw new ApiException(ApiExceptionType::$UNAUTHORIZED);

        echo "Connectiong to Search Engine server ... <br/>";
        $client = new Client(['hosts' => Config::get('cfg.elastic_hosts')]);

        if ($client->indices()->exists(['index' => Config::get('cfg.elastic_index')]))
            $client->indices()->delete(['index' => Config::get('cfg.elastic_index')]);

        echo "Preparing mappings and creating index ... <br/>";
        $insert['index'] = Config::get('cfg.elastic_index');
        foreach ($this->types as $type) {
            $insert['body']['mappings'][$type] = Config::get("mappings.$type");
        }

        $client->indices()->create($insert);

        echo "Populating the Search Engine with data from the DB ... <br/>";
        foreach ($this->types as $type) {
            $this->$type($client, Config::get('cfg.elastic_index'));
        }

        echo "Finished! <br/>";

    }

    private function job($client, $index)
    {
        $items = Job::all();

        echo "Found" . count($items) ." jobs. <br/>";

        foreach ($items as $item) {

            $data = [
                'id' => $item->id,
                'type' => 'job',
                'index' => $index,
                'body' => [
                    'title' => $item->title,
                    'description' => $item->description,
                    'user_id' => $item->user_id,
                    'bonus' => $item->bonus,
                    'active' => $item->active,
                    'deleted' => $item->deleted_at ? 1 : 0,
                    'skills' => array_column($item->skills->toArray(), 'name')
                ]
            ];

            $client->index($data);
        }

    }

    private function skill($client, $index)
    {
        $items = Skill::all();

        echo "Found" . count($items) ." skills. <br/>";
        foreach ($items as $item) {

            $data = [
                'id' => $item->id,
                'type' => 'skill',
                'index' => $index,
                'body' => [
                    'name' => $item->name
                ]
            ];

            $client->index($data);
        }

    }

}
