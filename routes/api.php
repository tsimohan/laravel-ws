<?php

use App\Http\Controllers\DepartmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarksController;
use App\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('marks/{dept_id}', [MarksController::class, 'marks']);
Route::resources(['students' => StudentController::class]);
Route::resources(['departments' => DepartmentController::class]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
