<?php declare(strict_types=1);

use App\Application\Middleware\EnsureXmlHttpRequest;
use App\Application\RequestHandlers\Contact\Api\SubmitContactForm;
use Illuminate\Routing\Router;

/** @var Router $router */
$router->post('/submit-contact-form', SubmitContactForm::class)->middleware([EnsureXmlHttpRequest::class, 'throttle:6,1']);