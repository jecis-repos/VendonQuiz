<?php
namespace Vendon;

require_once __DIR__ . '/vendor/autoload.php';
use Pecee\Http\Middleware\Exceptions\TokenMismatchException;
use Pecee\SimpleRouter\Exceptions\HttpException;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::setDefaultNamespace('\Vendon\Code\Controllers');

/* Load external routes file */
require_once 'routes.php';

// Start the routing
try {
    SimpleRouter::start();
} catch (TokenMismatchException|HttpException|NotFoundHttpException|\Exception $e) {
    var_dump($e->getMessage());
    var_dump($e->getTraceAsString());
}
