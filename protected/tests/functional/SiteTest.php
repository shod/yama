<?php

class SiteTest extends WebTestCase
{

	protected function setUp()
	{
		parent::setUp();
		$this->setBrowserUrl(TEST_BASE_URL);
	}

    public function testRegistration()
	{
		sleep(50);
		$this->open('/');
	}
}
