<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(match (config('app.service_role')) {
        'laporan' => route('reports.index'),
        'notif' => route('notifications.index'),
        default => route('inventory.index'),
    });
})->name('home');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/auth/google', [AuthController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'callback'])->name('auth.google.callback');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(Authenticate::class)->group(function (): void {
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory/items', [InventoryController::class, 'storeItem'])->name('inventory.items.store');
    Route::put('/inventory/items/{item}', [InventoryController::class, 'updateItem'])->name('inventory.items.update');
    Route::delete('/inventory/items/{item}', [InventoryController::class, 'destroyItem'])->name('inventory.items.destroy');
    Route::post('/inventory/movements', [InventoryController::class, 'storeMovement'])->name('inventory.movements.store');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/stock/print', [ReportController::class, 'printStock'])->name('reports.stock.print');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');
});
