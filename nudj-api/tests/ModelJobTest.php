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
			"title"       => "Test Title",
			"description" => "Test Description",
			"bonus"       => "666",
			"location"    => "Test London",
			"company"     => "Test Company",
			"salary"      => "£ 999"
		];
		$job = $jobmodel->add($userId, $input);
		$jobidentifier = $job->id;

		// -----------------------------
		$jobmodel = new App\Models\Job();
		$job = $jobmodel::find($jobidentifier);
		$this->assertEquals($job->title, "Test Title");
		$this->assertEquals($job->description, "Test Description");
		$this->assertEquals($job->bonus, 666);
		$this->assertEquals($job->location, "Test London");
		$this->assertEquals($job->company, "Test Company");
		$this->assertEquals($job->salary, "£ 999");

	}

}
