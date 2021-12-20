<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Middleware\AgeCheck;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::view('/','cms.index');

Route::prefix('cms')->middleware('guest:admin')->group(function () {
    Route::get('{guard}/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::prefix('cms/admin')->middleware('auth:admin')->group(function () {
    Route::view('/', 'cms.parent');
    // Route::view('/index', 'cms.parent');
    Route::resource('/cities', CityController::class);
    Route::resource('/categories', CategoryController::class);
    Route::resource('/admins', AdminController::class);

    Route::get('/edit-password', [AuthController::class, 'editPassword'])->name('edit.password');
    Route::put('/update-password', [AuthController::class, 'updatePassword']);

    Route::get('/edit-profile', [AuthController::class, 'editProfile'])->name('edit.profile');
    Route::put('/edit-profile', [AuthController::class, 'updateProfile']);

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

// Route::get('/test-email', function () {
//     return new WelcomeEmail();
// });
// Route::get('get', function () {

// })->middleware(AgeCheck::class);

// Route::get('get', function () {
    
// })->withoutMiddleware(AgeCheck::class);

// Route::get('age-check', function () {
//     echo 'WE ARE HERE';
// })->middleware('age');

// Route::get('age-check', function () {
//     echo 'WE ARE HERE';
// })->middleware(['age', '', '', '']);

// Route::prefix('cms')->middleware('age')->group(function () {
//     Route::get('age-check1', function () {
//         echo 'WE ARE HERE1';
//     });

//     Route::get('age-check2', function () {
//         echo 'WE ARE HERE2';
//     })->withoutMiddleware('age');
// });

// Route::get('age-check', function () {
//     echo 'WE ARE IN THE ROUTE';
// })->middleware('age:50');

// Route::prefix('cms/admin')->group(function () {
//     Route::view('login', 'cms.login')->name('login');
// });