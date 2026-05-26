<?php

namespace Tests;

use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase {
	use CreatesApplication;

	protected $faker;

	/**
	 * Setups the test suite.
	 */
	public function setUp() {
		parent::setUp();
		$this->faker = Factory::create();
		$this->seed();
	}

	/**
	 * Tears down the test suite.
	 */
	public function tearDown() {
		parent::tearDown();
	}
}
