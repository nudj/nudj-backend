<?php

// https://phpunit.de/manual/current/en/phpunit-book.html

class ModelJobTest extends TestCase {

	/*
		Testing Job Model
	 */
	public function test1()
	{

		// TODO: Improve by introducing variation in the parameters

		// -----------------------------
		// Need to be updated for skills
		$jobmodel = new App\Models\Job();
		$userId = 1;
		$input = [
			"title"            => "Test Title",
			"description"      => "Test Description",
			"location"         => "Test London",
			"company"          => "Test Company",
			"salary_amount"    => 999,
			"salary_currency"  => "GBP",
			"bonus"            => 666,
			"bonus_currency"   => 'GBP'
		];
		$job = $jobmodel->add($userId, $input);
		$jobidentifier = $job->id;

		// -----------------------------
		$jobmodel = new App\Models\Job();
		$job = $jobmodel::find($jobidentifier);
		$this->assertEquals($job->title, "Test Title");
		$this->assertEquals($job->description, "Test Description");
		$this->assertEquals($job->location, "Test London");
		$this->assertEquals($job->company, "Test Company");
		$this->assertEquals($job->salary2, 999);
		$this->assertEquals($job->salary2_currency, 'GBP');
		$this->assertEquals($job->bonus, 666);
		$this->assertEquals($job->bonus_currency, 'GBP');
	}

}
