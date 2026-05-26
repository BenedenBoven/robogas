<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomepageTest extends TestCase {

	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testHomePageLoads() {
		$response = $this->get('/');

		$response->assertStatus(200)
			->assertViewIs('layouts.app')
			->assertViewHas('washPage')
			->assertViewHas('foodPage')
			->assertViewHas('taxonomy');
	}
}
