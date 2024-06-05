<?php

use App\Support\Enums\ApiCode;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Lang;
use League\OAuth2\Server\Exception\OAuthServerException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api([
            \App\Support\Middleware\ForceJsonResponse::class
        ]);
    })
    ->withCommands([
        \App\Support\Commands\Setup::class,
        \App\Support\Commands\CreateMigrationForDomain::class,
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->dontReport([OAuthServerException::class]);

        $exceptions->render(function (Throwable $e, Request $request){
            if (($e instanceof HttpException || $e instanceof AuthenticationException || $e instanceof OAuthServerException) && $request->expectsJson()) {
                return ResponseBuilder::asError(ApiCode::INVALID_VALIDATION->value)
                    ->withHttpCode(Response::HTTP_BAD_REQUEST)
                    ->withMessage($e->getMessage())
                    ->build();
            }
            // If Unauthorized use to do any action
            if ($e instanceof AuthorizationException && $request->expectsJson()) {
                return ResponseBuilder::asError(ApiCode::SOMETHING_WENT_WRONG->value)
                    ->withMessage(Lang::get('api.something_went_wrong'))
                    ->withHttpCode(Response::HTTP_UNAUTHORIZED)
                    ->build();
            }

            // When model not found
            if ($e instanceof ModelNotFoundException) {
                return ResponseBuilder::asError(ApiCode::SOMETHING_WENT_WRONG->value)
                    ->withMessage(Lang::get('api.not_found'))
                    ->withHttpCode(Response::HTTP_NOT_FOUND)
                    ->build();
            }

            // Force to application/json rendering API Calls
            if ($request->is('api/*')) {
                $request->headers->set('Accept', 'application/json');
            }
            return null;
        });
    })
    ->create()
    ->useAppPath(realpath(__DIR__.'/../app/App'));
