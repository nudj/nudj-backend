<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder {

	public function run()
	{

		DB::table('skills')->truncate();


		$skills = [
			['name' => 'Management'],
			['name' => 'Business'],
			['name' => 'Sales'],
			['name' => 'Marketing'],
			['name' => 'Communication'],
			['name' => 'Microsoft Office'],
			['name' => 'Customer Service'],
			['name' => 'Training'],
			['name' => 'Microsoft Excel'],
			['name' => 'Project Management'],
			['name' => 'Designs'],
			['name' => 'Analysis'],
			['name' => 'Research'],
			['name' => 'Websites'],
			['name' => 'Budgets'],
			['name' => 'Organization'],
			['name' => 'Leadership'],
			['name' => 'Time Management'],
			['name' => 'Project Planning'],
			['name' => 'Computer Program'],
			['name' => 'Strategic Planning'],
			['name' => 'Business Services'],
			['name' => 'Applications'],
			['name' => 'Reports'],
			['name' => 'Microsoft Word'],
			['name' => 'Program Management'],
			['name' => 'Powerpoint'],
			['name' => 'Negotation'],
			['name' => 'Software'],
			['name' => 'Networking'],
			['name' => 'Offices'],
			['name' => 'English'],
			['name' => 'Data'],
			['name' => 'Education'],
			['name' => 'Events'],
			['name' => 'International'],
			['name' => 'Testing'],
			['name' => 'Writing'],
			['name' => 'Vendors'],
			['name' => 'Advertising'],
			['name' => 'Databases'],
			['name' => 'Technology'],
			['name' => 'Finance'],
			['name' => 'Retail'],
			['name' => 'Accounting'],
			['name' => 'Social media'],
			['name' => 'Teaching'],
			['name' => 'Engineering'],
			['name' => 'Performance Tuning'],
			['name' => 'Problem Solving'],
			['name' => 'Marketing Strategy'],
			['name' => 'Materials'],
			['name' => 'Recruiting'],
			['name' => 'Order Fulfillment'],
			['name' => 'Corporate Law'],
			['name' => 'Photoshop'],
			['name' => 'New business development'],
			['name' => 'Human resources'],
			['name' => 'Public speaking'],
			['name' => 'Manufacturing'],
			['name' => 'Internal Audit'],
			['name' => 'strategy'],
			['name' => 'Employees'],
			['name' => 'Cost'],
			['name' => 'Business Development'],
			['name' => 'Windows'],
			['name' => 'Public Relations'],
			['name' => 'Product Development'],
			['name' => 'Auditing'],
			['name' => 'Business Strategy'],
			['name' => 'Presentations'],
			['name' => 'Construction'],
			['name' => 'Real Estate'],
			['name' => 'Editing'],
			['name' => 'Sales Management'],
			['name' => 'Team Building'],
			['name' => 'Healthcare'],
			['name' => 'Revenue'],
			['name' => 'Compliance'],
			['name' => 'Legal'],
			['name' => 'Innovation'],
			['name' => 'Policy'],
			['name' => 'Mentoring'],
			['name' => 'Commercial Real Estate'],
			['name' => 'Consulting'],
			['name' => 'Information Technology'],
			['name' => 'Process Improvement'],
			['name' => 'Change management'],
			['name' => 'Heavy Equipment'],
			['name' => 'Teamwork'],
			['name' => 'Promotions'],
			['name' => 'Programming'],
			['name' => 'PHP'],
			['name' => 'Perl'],
			['name' => 'Software development'],
			['name' => 'MySQL'],
			['name' => 'HTML'],
			['name' => 'CSS'],
			['name' => 'SEO'],
			['name' => 'Database design'],
			['name' => 'Java'],
			['name' => 'Laravel'],
			['name' => 'Codeigniter'],
			['name' => 'MSSql'],
			['name' => 'MongoDB'],
		];




		DB::table('skills')->insert($skills);

		$this->command->info('Skills seeded!');

	}

}
