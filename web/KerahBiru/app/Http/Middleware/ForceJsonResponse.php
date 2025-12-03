<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceJsonResponse
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // CRITICAL: Force Accept header to application/json
        $request->headers->set('Accept', 'application/json');
        $request->headers->set('Content-Type', 'application/json');
        
        $response = $next($request);

        // FORCE JSON response for all responses
        if (!$response->headers->has('Content-Type') || 
            !str_contains($response->headers->get('Content-Type'), 'application/json')) {
            
            $content = $response->getContent();
            $statusCode = $response->getStatusCode();
            
            // If response is HTML or plain text, convert to JSON error
            if (str_contains($content, '<!DOCTYPE') || 
                str_contains($content, '<html') ||
                str_contains($content, '<body') ||
                $response->headers->get('Content-Type') === 'text/html') {
                
                return response()->json([
                    'success' => false,
                    'message' => $this->getMessageForStatusCode($statusCode),
                    'status_code' => $statusCode,
                    'debug' => config('app.debug') ? [
                        'received_content_type' => $response->headers->get('Content-Type'),
                        'url' => $request->fullUrl(),
                        'method' => $request->method(),
                    ] : null
                ], $statusCode);
            }
        }

        // Ensure Content-Type header is set
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }

    private function getMessageForStatusCode(int $statusCode): string
    {
        $messages = [
            400 => 'Permintaan tidak valid',
            401 => 'Tidak terautentikasi',
            403 => 'Akses ditolak',
            404 => 'Endpoint tidak ditemukan',
            405 => 'Method tidak diizinkan',
            419 => 'Sesi telah kedaluwarsa',
            422 => 'Data tidak valid',
            429 => 'Terlalu banyak permintaan',
            500 => 'Terjadi kesalahan pada server',
            503 => 'Layanan tidak tersedia',
        ];

        return $messages[$statusCode] ?? 'Terjadi kesalahan';
    }
}