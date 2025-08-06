<?php

use App\Http\Controllers\Api\Admin\V1\AuthControllerV1;
use App\Http\Controllers\Api\Admin\V1\StatusControllerV1;
use App\Http\Controllers\Api\Admin\V1\StoryPointControllerV1;
use App\Http\Controllers\Api\Admin\V1\TodoControllerV1;
use App\Http\Controllers\Api\Admin\V1\RoleControllerV1;
use App\Http\Controllers\Api\Admin\V1\UserControllerV1;
use App\Http\Controllers\Api\Admin\V1\DashboardControllerV1;
use App\Http\Controllers\Api\Admin\V1\AuditControllerV1;
use App\Http\Controllers\Api\User\V1\AuthControllerV1 as UserAuthControllerV1;
use App\Http\Controllers\Api\User\V1\DashboardControllerV1 as UserDashboardControllerV1;
use App\Http\Controllers\Api\User\V1\TodoControllerV1 as UserTodoControllerV1;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1/admin')->group(function () {
    Route::post('login', [AuthControllerV1::class, 'login'])->name('admin.login');

    Route::middleware(['auth:api_admin', \App\Http\Middleware\AuditAccess::class])->group(function () {
        Route::post('refresh-token', [AuthControllerV1::class, 'refreshToken'])->name('admin.refresh-token');
        Route::post('logout', [AuthControllerV1::class, 'logout'])->name('admin.logout');
        Route::get('me', [AuthControllerV1::class, 'me'])->name('admin.me');
        Route::get('dashboard', [DashboardControllerV1::class, 'dashboard'])->name('admin.dashboard');
        Route::apiResource('status', StatusControllerV1::class);
        Route::apiResource('story-point', StoryPointControllerV1::class);
        Route::apiResource('todo', TodoControllerV1::class);
        Route::apiResource('role', RoleControllerV1::class);
        Route::apiResource('user', UserControllerV1::class);
        Route::get('audits', [AuditControllerV1::class, 'index']);
    });
});

Route::prefix('/v1/user')->group(function () {
    Route::post('login', [UserAuthControllerV1::class, 'login'])->name('user.login');
    Route::post('register', [UserAuthControllerV1::class, 'register'])->name('user.register');

    Route::middleware(['auth:api_user', \App\Http\Middleware\AuditAccess::class])->group(function () {
        Route::post('refresh-token', [UserAuthControllerV1::class, 'refreshToken'])->name('user.refresh-token');
        Route::post('logout', [UserAuthControllerV1::class, 'logout'])->name('user.logout');
        Route::get('me', [UserAuthControllerV1::class, 'me'])->name('user.me');
        Route::get('dashboard', [UserDashboardControllerV1::class, 'dashboard'])->name('user.dashboard');
        Route::apiResource('todo', UserTodoControllerV1::class)->only(['index','store', 'update']);
    });
});
