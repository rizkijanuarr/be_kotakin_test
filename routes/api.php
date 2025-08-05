<?php

use App\Http\Controllers\Api\Admin\V1\AuthControllerV1;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1/admin')->group(function () {
    Route::post('login', [AuthControllerV1::class, 'login']);

    Route::middleware('auth:api_admin')->group(function () {
        Route::post('refresh-token', [AuthControllerV1::class, 'refreshToken']);
        Route::post('logout', [AuthControllerV1::class, 'logout']);
        Route::get('me', [AuthControllerV1::class, 'me']);
    });
});
