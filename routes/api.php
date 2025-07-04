<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenderController;

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

Route::middleware('api.auth')->prefix('v1')->group( function() {
	Route::resource('tender', TenderController::class)->except(['create', 'edit', 'update', 'destroy']);
});

Route::any('{any}', function() {
	return response()->json([
		'error' => true,
		'message' => 'Bad Request'
	], 400);
})->where('any', '.*');