<?php declare(strict_types=1);

use App\Application\Middleware\EnsureXmlHttpRequest;
use App\Application\Middleware\VerifyRecaptcha;
use App\Application\RequestHandlers\Form\Api\SubmitForm;
use Illuminate\Routing\Router;

/** @var Router $router */
$router->post('/forms/{formType}', SubmitForm::class)->middleware([EnsureXmlHttpRequest::class, VerifyRecaptcha::class, 'throttle:6,1']);
