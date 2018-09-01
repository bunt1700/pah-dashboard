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

	use Illuminate\Support\Facades\Route;

	Route::get('/', 'HomepageController@index')->name('homepage');
	Route::any('/products', 'ProductListController@index')->name('productlist');

	Route::prefix('/categorization/')->group(function() {
		Route::get('/', 'CategorizationController@index')->name('categorization');
		Route::any('/{category}', 'CategorizationController@edit')->name('categorization.form');
		Route::post('/{category}/save', 'CategorizationController@save')->name('categorization.submit');
	});

	Route::prefix('/data/')->group(function() {
		Route::get('/categories.json', 'DataController@categories');
		Route::get('/subcategories-{category}.json', 'DataController@subcategories');
		Route::get('/productgroups-{subcategory}.json', 'DataController@productgroups');
	});
