<?php

namespace App\Exceptions;

use http\Client\Curl\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthenticationException::class,
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
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
     * @throws \Throwable
     */

    public function report(Throwable $exception)
    {

        if ($this->shouldReport($exception) && !$this->shouldntReport($exception)) {

            $request        = request();
            $request_data   = [
                'agent'           => $request->server('HTTP_USER_AGENT'),
                'root'            => $request->server('CONTEXT_DOCUMENT_ROOT'),
                'REQUEST_URI'     => $request->server('REQUEST_URI'),
                'REMOTE_ADDR'     => $request->server('REMOTE_ADDR'),
                'SCRIPT_FILENAME' => $request->server('SCRIPT_FILENAME'),
                'parameters'      => $request->all()
            ];

            $exception_data = [
                'class'    => get_class($exception),
                'message'  => $exception->getMessage(),
                'file'     => $exception->getFile(),
                'line'     => $exception->getLine(),
                'code'     => $exception->getCode(),
                'previous' => $exception->getPrevious()
            ];

            Log::Critical('Server Error', ['Request' => $request_data, 'Exception' => $exception_data]);
            Log::Critical('Trace Error', ['trace' => $exception->getTraceAsString()]);
        }

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

        $app_environment = env('APP_ENV');
        $c_msg = $exception->getMessage();
        $file = $exception->getFile();
        $code = $exception->getCode();
        $line = $exception->getLine();

        $html = "<b>Message:</b> ".$c_msg.'<br /> <b>File:</b> '.$file.'<br /> <b>Line:</b> '.$line;

        $msg = $app_environment == 'local' ? $html : "Oops! Somethings went wrong, please try again later.";

        if ($exception instanceof ValidationException || $exception instanceof AuthenticationException || $exception instanceof AuthorizationException || $exception instanceof HttpException){
           return parent::render($request, $exception);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->view('errors.error', compact('html'));
        }

        if($request->ajax()){

            return response()->globalError(
                
                $msg,
                $this->isHttpException($exception) ? $exception->getStatusCode() : 500
                
            );

        } else {
            if ($app_environment === 'local') {
                return response()->view('errors.error', compact('html'));
            } else {
                $html = "Oops! Somethings went wrong, please try again later.";
                abort(403, $html);
            }
        }
    }

}
