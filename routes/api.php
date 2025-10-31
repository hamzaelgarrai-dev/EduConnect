<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {

    // Courses (shared)
    Route::get('courses', [CourController::class, 'index'])
        ->middleware('permission:view courses');
    Route::get('courses/{id}', [CourController::class, 'show'])
        ->middleware('permission:view course details');

    // Teacher + Admin
    Route::middleware('role:enseignant|admin')->group(function () {
        Route::post('courses', [CourController::class, 'store'])
            ->middleware('permission:create course');
        Route::put('courses/{id}', [CourController::class, 'update'])
            ->middleware('permission:update course');
        Route::delete('courses/{id}', [CourController::class, 'destroy'])
            ->middleware('permission:delete course');
    });

    // Student + Admin
    Route::middleware('role:etudiant|admin')->group(function () {
        Route::post('courses/{id}/enroll', [CourController::class, 'enroll'])
            ->middleware('permission:enroll course');
        Route::get('my-courses', [CourController::class, 'myCourses'])
            ->middleware('permission:view my courses');
    });

    // Admin only
    Route::middleware('role:admin')->group(function () {
        Route::get('users', [UserController::class, 'index'])
            ->middleware('permission:list users');
        Route::post('users', [UserController::class, 'store'])
            ->middleware('permission:create user');
        Route::put('users/{id}', [UserController::class, 'update'])
            ->middleware('permission:update user');
        Route::delete('users/{id}', [UserController::class, 'destroy'])
            ->middleware('permission:delete user');
    });
});