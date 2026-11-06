<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // 3.1 Autenticación y salud (Públicos)
    Route::get('/health', function () { 
        return response()->json(['status' => 'ok']); 
    });
    Route::post('/auth/login', function () {
        return response()->json([
            'access_token' => 'token_generado_ejemplo',
            'token_type' => 'Bearer',
            'expires_in' => 28800,
            'role' => 'librarian'
        ]);
    });

      // Endpoints Protegidos (Simulación de control de acceso por token y rol)
    Route::group([], function () {

        // 3.3 Categorías
        Route::get('/categories', function () {
            return response()->json(['items' => []]);
        });

        // 3.4 Libros
        Route::get('/books', function () { return response()->json(['items' => [], 'page' => 1, 'size' => 20, 'total' => 0]); });
        Route::get('/books/{id}', function () { return response()->json([]); });

        // 3.5 Socios
        Route::get('/members', function () { return response()->json(['items' => [], 'page' => 1, 'size' => 20, 'total' => 0]); });
        Route::get('/members/{id}', function () { return response()->json([]); });
// 3.6 Préstamos
        Route::post('/loans', function () { return response()->json([], 201); });
        Route::get('/loans', function () { return response()->json(['items' => []]); });
        Route::get('/loans/{id}', function () { return response()->json([]); });
        Route::post('/loans/{loan_id}/items/{item_id}/return', function () { return response()->json(['returned_at' => now()->toIso8601String()]); });
        Route::get('/loans/overdue', function () { return response()->json(['items' => []]); });

        // Rutas Administrativas (Permisos restringidos para rol "admin")
        Route::post('/users', function () { return response()->json([], 201); });
        Route::post('/books', function () { return response()->json([], 201); });
        Route::put('/books/{id}', function () { return response()->json([]); });
        Route::delete('/books/{id}', function () { return response()->json([], 204); });
        Route::put('/books/{id}/cover', function () { return response()->json([]); });
        Route::delete('/books/{id}/cover', function () { return response()->json([], 204); });

        // 3.7 Reporte
        Route::get('/reports/most-borrowed', function () { return response()->json(['from' => '', 'to' => '', 'rows' => []]); });
    });
});
