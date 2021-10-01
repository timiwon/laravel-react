<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(
            function (Throwable $e) {
                //
            }
        );
    }

    public function render($request, Throwable $e)
    {
        if ($request->is('api/*')) {
            $status = 500;
            $response = [
            'error' => 'Sorry, can not execute your request.'
            ];

            if (config('app.debug')) {
                $response['exception'] = get_class($e);
                $response['message'] = $e->getMessage() . ' - ' .$e->getFile() . ':' . $e->getLine();
                $response['trace'] = $e->getTrace();
            }

            if ($e instanceof ModelNotFoundException) {
                $status = 404;
                $response['error'] = 'Entry for '.str_replace('App\\', '', $e->getModel()).' not found';
            }

            if ($e instanceof ValidationException) {
                $status = 400;
                $response['error'] = $e->errors();
            }

            if ($e instanceof AuthorizationException) {
                $status = 403;
                $response['error'] = 'Unauthorized';
            }

            return response()->json($response, $status);
        }

        return parent::render($request, $e);
    }
}
