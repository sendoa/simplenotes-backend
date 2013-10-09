<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::group(array('prefix' => 'api/v1', 'before' => 'auth_api_key'), function()
{
	// Notes
	Route::post('notes', 'NotesController@create');
	Route::delete('notes/{id}', 'NotesController@destroy');

	// Users
	Route::get('users/{id}/notes', 'UsersController@getNotes');
	Route::post('users', 'UsersController@create');
	Route::post('users/login', 'UsersController@login');
});