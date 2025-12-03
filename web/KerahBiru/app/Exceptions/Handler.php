<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    protected $levels = [];
    protected $dontReport = [];
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        // CRITICAL: Check if this is an API request FIRST
        if ($this->isApiRequest($request)) {
            return $this->handleApiException($request, $e);
        }

        // Handle 404 Not Found for web
        if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        }

        // Handle HTTP exceptions with specific status codes for web
        if ($e instanceof HttpException) {
            return $this->handleHttpException($e);
        }

        return parent::render($request, $e);
    }

    protected function isApiRequest($request): bool
    {
        // MULTIPLE checks to ensure we catch API requests
        return $request->is('api/*') 
            || $request->expectsJson() 
            || $request->wantsJson()
            || $request->ajax()
            || $request->header('Accept') === 'application/json' 
            || str_contains($request->header('Accept', ''), 'application/json')
            || str_contains($request->header('Content-Type', ''), 'application/json');
    }

    protected function handleHttpException(HttpException $e)
    {
        $statusCode = $e->getStatusCode();

        if ($statusCode === 403) {
            return response()->view('errors.403', [], 403);
        }

        if ($statusCode === 419) {
            return response()->view('errors.419', [], 419);
        }

        if ($statusCode === 503) {
            return response()->view('errors.503', [], 503);
        }

        if (config('app.env') === 'production' && $statusCode >= 500) {
            return response()->view('errors.500', ['exception' => $e], 500);
        }

        return parent::render(request(), $e);
    }

    protected function handleApiException($request, Throwable $e)
    {
        $statusCode = 500;
        $message = 'Terjadi kesalahan pada server';

        // Handle validation exceptions first
        if ($e instanceof ValidationException) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422)
            ->header('Content-Type', 'application/json');
        }

        // Determine status code and message based on exception type
        if ($e instanceof ModelNotFoundException) {
            $statusCode = 404;
            $message = 'Data tidak ditemukan';
        } elseif ($e instanceof NotFoundHttpException) {
            $statusCode = 404;
            $message = 'Endpoint tidak ditemukan';
        } elseif ($e instanceof HttpException) {
            $statusCode = $e->getStatusCode();
            $message = $e->getMessage() ?: $this->getDefaultMessage($statusCode);
        } elseif ($e instanceof AuthenticationException) {
            $statusCode = 401;
            $message = 'Tidak terautentikasi';
        } elseif ($e instanceof \Illuminate\Database\QueryException) {
            $statusCode = 500;
            $message = config('app.debug') 
                ? 'Database Error: ' . $e->getMessage()
                : 'Terjadi kesalahan database';
        } elseif ($e instanceof \PDOException) {
            $statusCode = 500;
            $message = config('app.debug')
                ? 'Database Connection Error: ' . $e->getMessage()
                : 'Terjadi kesalahan koneksi database';
        } elseif ($e instanceof \Illuminate\Auth\Access\AuthorizationException) {
            $statusCode = 403;
            $message = 'Akses ditolak';
        }

        $response = [
            'success' => false,
            'message' => $message,
            'status_code' => $statusCode,
        ];

        // Add exception details in development mode
        if (config('app.debug')) {
            $response['debug'] = [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'message' => $e->getMessage(),
                'trace' => collect($e->getTrace())->take(5)->map(function ($trace) {
                    return [
                        'file' => $trace['file'] ?? 'unknown',
                        'line' => $trace['line'] ?? 0,
                        'function' => $trace['function'] ?? 'unknown',
                        'class' => $trace['class'] ?? null,
                    ];
                })->toArray(),
            ];
        }

        return response()->json($response, $statusCode)
            ->header('Content-Type', 'application/json')
            ->header('X-Content-Type-Options', 'nosniff');
    }

    protected function getDefaultMessage(int $statusCode): string
    {
        $messages = [
            400 => 'Permintaan tidak valid',
            401 => 'Tidak terautentikasi',
            403 => 'Akses ditolak',
            404 => 'Tidak ditemukan',
            405 => 'Method tidak diizinkan',
            419 => 'Sesi telah kedaluwarsa',
            422 => 'Data tidak valid',
            429 => 'Terlalu banyak permintaan',
            500 => 'Terjadi kesalahan pada server',
            502 => 'Bad Gateway',
            503 => 'Layanan tidak tersedia',
            504 => 'Gateway Timeout',
        ];

        return $messages[$statusCode] ?? 'Terjadi kesalahan';
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($this->isApiRequest($request)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak terautentikasi',
                'status_code' => 401,
            ], 401)
            ->header('Content-Type', 'application/json');
        }

        if ($request->is('admin/*')) {
            return redirect()->guest(route('admin.login'));
        }

        return redirect()->guest(route('welcome'));
    }
}