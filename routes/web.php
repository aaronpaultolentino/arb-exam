<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function (Request $request) {
    // return view('welcome');
    return redirect('login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', 'HomeController@index')->name('dashboard')->middleware('permission:access_dashboard');

    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::get('/profile/info', 'ProfileController@info')->name('profile.info');
    Route::put('/profile', 'ProfileController@save')->name('profile.save');

    Route::group(['middleware' => 'permission:access_user', 'namespace' => 'UserManagement'], function () {
        Route::get('/users', 'UsersController@index')->name('users');
        Route::get('/users/all', 'UsersController@all')->name('users.all');
        Route::get('/users/{id}', 'UsersController@find')->name('user.find');
        Route::put('/users/{id}', 'UsersController@update')->name('user.update');
        Route::delete('/users/{id}', 'UsersController@delete')->name('user.update');
        Route::post('/users/', 'UsersController@create')->name('user.create');

        Route::get('/roles', 'RolesController@index')->name('roles');
        Route::get('/roles/all', 'RolesController@all')->name('roles.all');
        Route::get('/roles/{id}', 'RolesController@find')->name('role.find');
        Route::put('/roles/{id}', 'RolesController@update')->name('role.update');
        Route::delete('/roles/{id}', 'RolesController@delete')->name('role.update');
        Route::post('/roles/', 'RolesController@create')->name('role.create');
    });

    Route::group(['middleware' => 'permission:access_expense', 'namespace' => 'ExpenseManagement'], function () {
        Route::get('/expenses', 'ExpensesController@index')->name('expenses');
        Route::get('/expenses/chart', 'ExpensesController@chart')->name('expenses.chart');
        Route::get('/expenses/all', 'ExpensesController@all')->name('expenses.all');
        Route::get('/expenses/{id}', 'ExpensesController@find')->name('expenses.find');
        Route::put('/expenses/{id}', 'ExpensesController@update')->name('expenses.update');
        Route::delete('/expenses/{id}', 'ExpensesController@delete')->name('expenses.update');
        Route::post('/expenses/', 'ExpensesController@create')->name('expenses.create');

        Route::get('/expense_categories', 'ExpenseCategoriesController@index')->name('expense_categories');
        Route::get('/expense_categories/all', 'ExpenseCategoriesController@all')->name('expense_categories.all');
        Route::get('/expense_categories/{id}', 'ExpenseCategoriesController@find')->name('expense_categories.find');
        Route::put('/expense_categories/{id}', 'ExpenseCategoriesController@update')->name('expense_categories.update');
        Route::delete('/expense_categories/{id}', 'ExpenseCategoriesController@delete')->name('expense_categories.update');
        Route::post('/expense_categories/', 'ExpenseCategoriesController@create')->name('expense_categories.create');

    });

});
