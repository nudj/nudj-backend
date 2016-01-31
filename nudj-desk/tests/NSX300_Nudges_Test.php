<?php

class NSX300_Nudges_Test extends TestCase {

	public function test1()
	{
		$this->assertEquals("pong", \App\NSX300\NSX300_Nudges::ping());
	}
	public function test2(){
		$this->assertEquals(2, \App\NSX300\NSX300_Nudges::number_of_distinct_referrers_contacting_candidates_for_job_id(74));
	}

}
