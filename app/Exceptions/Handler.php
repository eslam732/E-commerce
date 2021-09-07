<?php

namespace App\Exceptions;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $this->renderable(function (NotFoundHttpException $e) {
            return response()->json(['message' => 'object not found'], 404);
        });
        $this->renderable(function (MethodNotAllowedHttpException $e) {
            
            return response()->json(['message' => 'change the method'], 404);
        });

        $this->renderable(function (ThrottleRequestsException $e) {
            
            return response()->json(['message' => 'to many requests'], 404);
        });

        // $this->renderable(function (QueryException $e) {
           
        //     return response()->json(['message' => $e], 404);
        // });
    }
   
}
