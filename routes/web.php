<?php

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

use App\Http\Controllers\StatisticController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::resources([
    'users' => UserController::class,
    'skills' => SkillController::class,
    'positions' => PositionController::class,
]);

Route::get('statistic', 'StatisticController@index')->name('statistic.index');
Route::post('statistic', 'StatisticController@index')->name('statistic.update');
