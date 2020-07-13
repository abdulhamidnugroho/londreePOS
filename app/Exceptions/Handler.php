<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;


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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException)
        {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }
        
        if ($exception instanceof MethodNotAllowedHttpException) {
            abort(JsonResponse::HTTP_METHOD_NOT_ALLOWED, 'Method not allowed');
        }
        if ($request->isJson() && $exception instanceof ValidationException) {
            return response()->json([
                'status' => 'error',
                'message' => [
                    'errors' => $exception->getMessage(),
                    'fields' => $exception->validator->getMessageBag()->toArray()
                ]
            ], JsonResponse::HTTP_PRECONDITION_FAILED);
        }
        
        if ($exception instanceof UnauthorizedHttpException) {
            $preException = $exception->getPrevious();
            if ($preException instanceof TokenExpiredException) {
                return response()->json([
                    'status' => false,
                    'data' => null,
                    'err_' => [
                    'message' => 'Token Expired',
                    'code' => 401
                    ]
                ]);
            }
            else if ($preException instanceof TokenInvalidException) {
                return response()->json([
                    'data' => null,
                    'status' => false,
                    'err_' => [
                    'message' => 'Token Invalid',
                    'code' => 401
                    ]
                ]);
            }
            else if ($preException instanceof TokenBlacklistedException) {
                return response()->json([
                    'data' => null,
                    'status' => false,
                    'err_' => [
                    'message' => 'Token Blacklisted',
                    'code' => 401
                    ]
                ]);
            }

            if ($exception->getMessage() === 'Token not provided') {
                return response()->json([
                    'data' => null,
                    'status' => false,
                    'err_' => [
                    'message' => 'Token not provided',
                    'code' => 401
                    ]
                ]);
            }
            else if( $exception->getMessage() === 'User not found'){
                return response()->json([
                    'data' => null,
                    'status' => false,
                    'err_' => [
                    'message' => 'User Not Found',
                    'code' => 404
                    ]
                ]);
            }
        }

        if ($exception instanceof ModelNotFoundException && $request->wantsJson()) {
            return response()->json([
                'error' => 'Resource not found'
            ], 404);
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return parent::render($request, $exception);
    }
}
