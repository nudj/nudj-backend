<?php namespace App\Console\Commands;

/*
	This command exists to allow running Model functions from the command line.
*/

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use App\Models\UsersBlocked;
use App\Models\UsersReported;
use App\Models\JobsBlocked;

class PascalNSLOG extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'pascal:nslog';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generic nslog';

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
			To print something to the console: $this->info('nslog');
        */
		// $this->info('nslog');

		// UsersBlocked::block_user(13,14);
		$this->info( serialize(JobsBlocked::get_blocked_jobids_for_primary_user(1)) );
		$this->info( serialize(UsersBlocked::get_blocked_userids_for_primary_user(1)) );
		$this->info( serialize(UsersReported::get_reported_userids_for_primary_user(1)) );

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

}
