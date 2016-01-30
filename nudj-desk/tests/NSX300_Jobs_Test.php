<?php

class NSX300_Jobs_Test extends TestCase {

	public function test1()
	{
		$this->assertEquals(73, App\NSX300\NSX300_Jobs::hirer_id_for_job_id_or_null(78));
		$this->assertNull(App\NSX300\NSX300_Jobs::hirer_id_for_job_id_or_null(-1));
	}

}
