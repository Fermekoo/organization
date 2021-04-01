<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PICController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['prefix' => 'manager','middleware' => ['auth','admin']], function(){
    Route::get('/',[ManagerController::class, 'index'])->name('manager.index');
    Route::get('/create',[ManagerController::class, 'create'])->name('manager.create');
    Route::post('/create',[ManagerController::class, 'store'])->name('manager.store');
    Route::get('/{id}/detail',[ManagerController::class, 'detail'])->name('manager.detail');
    Route::post('/{id}/detail',[ManagerController::class, 'update'])->name('manager.update');
});

Route::group(['prefix' => 'organization','middleware' => ['auth']], function(){
    Route::get('/',[OrganizationController::class, 'index'])->name('org.index');
    Route::get('/create',[OrganizationController::class, 'create'])->name('org.create');
    Route::post('/create',[OrganizationController::class, 'store'])->name('org.store');
    Route::get('/{id}/detail',[OrganizationController::class, 'detail'])->name('org.detail');
    Route::post('/{id}/detail',[OrganizationController::class, 'update'])->name('org.update');
    Route::get('/{id}/assign-manager',[OrganizationController::class, 'addManager'])->middleware(['admin'])->name('org.add-manager');
    Route::post('/{id}/assign-manager',[OrganizationController::class, 'assignManager'])->middleware(['admin'])->name('org.assign-manager');
});

Route::group(['prefix' => 'pic','middleware' => ['auth']], function(){
    Route::get('/{org_id}/create',[PICController::class, 'create'])->name('pic.create');
    Route::post('/{org_id}/create',[PICController::class, 'store'])->name('pic.store');
    Route::get('/{org_id}/detail/{id}',[PICController::class, 'detail'])->name('pic.detail');
    Route::post('/{org_id}/detail/{id}',[PICController::class, 'update'])->name('pic.update');
    Route::get('/{org_id}/delete/{id}',[PICController::class, 'delete'])->name('pic.delete');
});

require __DIR__.'/auth.php';


