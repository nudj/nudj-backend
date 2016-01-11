<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use App\Models\Job;
use App\Models\Skill;
use Elasticsearch\Client;
use Illuminate\Support\Facades\Config;

class LoadElasticSearch extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'elasticsearch:load';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Performs loading of the Elasticsearch dataset.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{

        /* 
            This code is essentially a copy of the similar code 
            found in SearchEngineController repair.
        */

		$this->types = ['skill', 'job'];

        $this->info('Connectiong to Search Engine server ... ');

        $client = new Client(['hosts' => Config::get('cfg.elastic_hosts')]);

        if ($client->indices()->exists(['index' => Config::get('cfg.elastic_index')]))
            $client->indices()->delete(['index' => Config::get('cfg.elastic_index')]);

        $this->info('Preparing mappings and creating index ... ');

        $insert['index'] = Config::get('cfg.elastic_index');
        foreach ($this->types as $type) {
            $insert['body']['mappings'][$type] = Config::get("mappings.$type");
        }

        $client->indices()->create($insert);

        $this->info('Populating the Search Engine with data from the DB ... ');

        foreach ($this->types as $type) {
            $this->$type($client, Config::get('cfg.elastic_index'));
        }

        $this->info('Finished!');

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			// ['example', InputArgument::REQUIRED, 'An example argument.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			// ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		];
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
