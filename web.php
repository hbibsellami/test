<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'isChief'], function() {

    Route::get('permissions/{permissionId}/delete', [App\Http\Controllers\PermissionController::class,'destroy']);

    Route::get('roles/{roleId}/delete', [App\Http\Controllers\RoleController::class,'destroy']);

    Route::get('roles/{roleId}/give-permissions',[App\Http\Controllers\RoleController::class,'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permissions',[App\Http\Controllers\RoleController::class,'givePermissionToRole']);

    Route::get('users/{userId}/delete',[App\Http\Controllers\UserController::class,'destroy']);

    Route::put('teams/{teamId}/add-users',[App\Http\Controllers\TeamController::class,'giveUsersToTeam']);
    Route::get('teams/{teamId}/add-users',[App\Http\Controllers\TeamController::class,'addUserToTeam']);

    Route::controller(App\Http\Controllers\FullCalenderController::class)->group(function(){
        Route::get('fullcalender', 'index');
        Route::post('fullcalenderAjax', 'ajax');
    });
});
Route::resource('permissions', App\Http\Controllers\PermissionController::class);
Route::resource('roles', App\Http\Controllers\RoleController::class);
Route::resource('users',App\Http\Controllers\UserController::class);
Route::resource('leaves',App\Http\Controllers\LeaveController::class);
Route::resource('balances',App\Http\Controllers\BalanceController::class);
Route::resource('teams',App\Http\Controllers\TeamController::class);
Route::get('leaves/{leaveId}/delete',[App\Http\Controllers\LeaveController::class,'destroy']);
Route::get('balances/{balanceId}/delete',[App\Http\Controllers\BalanceController::class,'destroy']);
Route::get('teams/{teamId}/delete',[App\Http\Controllers\TeamController::class,'destroy']);


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

