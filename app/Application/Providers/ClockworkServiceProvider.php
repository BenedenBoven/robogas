<?php declare(strict_types = 1);

namespace App\Application\Providers;

final class ClockworkServiceProvider extends \Clockwork\Support\Laravel\ClockworkServiceProvider {

	protected function registerEventListeners() {
		$this->app['clockwork.support']->addDataSources()->listenToEvents();
	}

}