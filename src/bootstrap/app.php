<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->map(\Illuminate\Validation\ValidationException::class, function (\Illuminate\Validation\ValidationException $exception) {
            return new \Illuminate\Http\Exceptions\HttpResponseException(
                response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $exception->errors(),
                ], 422)
            );
        });

        // Example: Handle model not found exceptions
        $exceptions->map(\Illuminate\Database\Eloquent\ModelNotFoundException::class, function (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return new \Illuminate\Http\Exceptions\HttpResponseException(
                response()->json([
                    'message' => 'Resource not found.',
                ], 404)
            );
        });

        // Example: Handle authentication exceptions
        $exceptions->map(\Illuminate\Auth\AuthenticationException::class, function (\Illuminate\Auth\AuthenticationException $exception) {
            return new \Illuminate\Http\Exceptions\HttpResponseException(
                response()->json([
                    'message' => 'Unauthenticated.',
                ], 401)
            );
        });
    })
    ->create();
