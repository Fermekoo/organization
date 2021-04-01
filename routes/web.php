<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\OrganizationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['prefix' => 'manager'], function(){
    Route::get('/',[ManagerController::class, 'index'])->name('manager.index');
    Route::get('/create',[ManagerController::class, 'create'])->name('manager.create');
    Route::post('/create',[ManagerController::class, 'store'])->name('manager.store');
    Route::get('/{id}/detail',[ManagerController::class, 'detail'])->name('manager.detail');
    Route::post('/{id}/detail',[ManagerController::class, 'update'])->name('manager.update');
});

Route::group(['prefix' => 'organization'], function(){
    Route::get('/',[OrganizationController::class, 'index'])->name('org.index');
    Route::get('/create',[OrganizationController::class, 'create'])->name('org.create');
    Route::post('/create',[OrganizationController::class, 'store'])->name('org.store');
});

require __DIR__.'/auth.php';


