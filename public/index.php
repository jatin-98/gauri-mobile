<?php

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Response;

// ------------------------------------------------------
// Bootstrap Application
// ------------------------------------------------------
$app = require __DIR__ . '/../bootstrap/app.php';

// ------------------------------------------------------
// Handle Request Lifecycle
// ------------------------------------------------------
$request = Request::capture();

try {
    // Dispatch the request to the router
    $response = $app->router->dispatch($request);
} catch (NotFoundHttpException $e) {
    // Return a proper 404 response
    $response = new Response(view('default.404')->render(), 404);
} catch (HttpException $e) {
    // Return a proper HTTP exception response
    $response = new Response($e->getMessage() ?: 'HTTP Error', $e->getStatusCode());
} catch (Throwable $e) {
    // Return a proper 500 response
    if (env('APP_DEBUG', true)) {
        // Detailed error in debug mode
        $response = new Response('500 | Internal Server Error: ' . $e->getMessage() . "\n" . $e->getTraceAsString(), 500);
    } else {
        $response = new Response('500 | Internal Server Error', 500);
    }
}

// ------------------------------------------------------
// Send Response
// ------------------------------------------------------
if ($response instanceof \Symfony\Component\HttpFoundation\Response) {
    $response->send();
} elseif (is_string($response)) {
    echo $response;
} elseif (is_array($response) || is_object($response)) {
    echo json_encode($response);
} else {
    echo $response;
}