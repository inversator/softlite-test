<?php

namespace App\Exceptions;

use App\Enums\ResponseStatus;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Renders an HTTP response for the given exception.
     *
     * @param Request $request The current request instance.
     * @param Throwable $e The exception instance.
     *
     * @return Response|JsonResponse|ResponseAlias|RedirectResponse
     */
    public function render($request, Throwable $e): Response|JsonResponse|ResponseAlias|RedirectResponse
    {
        $statusCode = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR;
        $error = $e->getMessage() ?? 'Undefined error';

        if ($e instanceof ValidationException) {
            $statusCode = ResponseAlias::HTTP_UNPROCESSABLE_ENTITY;
            $error = $e->errors();
        } elseif ($e instanceof ModelNotFoundException) {
            $statusCode = ResponseAlias::HTTP_NOT_FOUND;
            $error = 'Resource not found';

            // Authorization exception
        } elseif ($e instanceof AuthorizationException) {
            $statusCode = ResponseAlias::HTTP_UNAUTHORIZED;
            $error = 'Unauthorized';
        } elseif ($e instanceof HttpExceptionInterface) {
            $statusCode = $e->getStatusCode();
        }

        return response()->json([
            'status' => ResponseStatus::Error->value,
            'error' => $error,
        ], $statusCode);
    }
}
