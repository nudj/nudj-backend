<?php

class NSX300_Applications_Test extends TestCase {

	public function test1()
	{
		$this->assertEquals(8, \App\NSX300\NSX300_Applications::applications_requests_count_for_job_id(2));
	}

}
