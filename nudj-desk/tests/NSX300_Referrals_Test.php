<?php

class NSX300_Referrals_Test extends TestCase {

	public function test1()
	{
		$this->assertEquals(2, \App\NSX300\NSX300_Referrals::referral_requests_count_for_job_id(11));
	}

}
