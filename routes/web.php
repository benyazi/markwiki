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

Auth::routes();

Route::get('/', 'ProjectController@index')->name('project.list');
Route::get('/p/{project_id}', 'PageController@index')->name('page.main');
Route::get('/page/{slug}', 'PageController@view')->name('page.view');


Route::get('/api/projects', 'ProjectController@getList')->name('api.projects');
Route::post('/api/project', 'ProjectController@saveProject')->name('api.project.save');
Route::get('/api/pages/{projectId}', 'PageController@getList')->name('api.pages');
Route::post('/api/page', 'PageController@savePage')->name('api.page.save');
