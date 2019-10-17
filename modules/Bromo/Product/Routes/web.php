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

Route::group(['middleware' => 'auth'], function () {

    Route::name('product.index')->get('/product', 'ProductController@index');

    Route::name('product.productinfo')->get('/product-info', 'ProductController@getProductInfo');

    /*
    Route::name('product.productcategory')->get('/product-info-category', 'ProductController@getProductCategory');
    Route::name('product.productsubcategory')->get('/product-sub-category/{parent_category}', 'ProductController@getProductSubCategory');
    Route::name('product.productthirdcategory')->get('/product-sub-category/{parent_category}', 'ProductController@getProductThirdCategory');
    */
    Route::name('product.getcategories')->get('/get-categories/{id?}','ProductController@getProductCategory');

    Route::name('product.show')->get('/product/{id}', 'ProductController@show');
    Route::name('product.submited')->get('/submited', 'ProductController@submited');
    Route::name('product.rejected')->get('/rejected', 'ProductController@rejected');
    Route::name('product.approved')->get('/approved', 'ProductController@approved');

    Route::name('product.edit')->put('/product/update/{id}', 'ProductController@updateCategory');
    Route::name('product.edit-weight')->put('/product/update-weight/{id}', 'ProductController@updateWeight');

    Route::name('product.status')->put('/product-status/{id}', 'ProductController@status');
    Route::name('product.getInfo')->get('/product-info/{id}', 'ProductController@getProductInfo');
    Route::name('product.unverified')->patch('/unverified/{id}', 'ProductController@unverified');
    Route::name('product.verified')->patch('/verified/{id}', 'ProductController@verified');

    Route::name('product.edit-tags')->put('/product/update-tags/{id}', 'ProductController@updateTags');

    Route::resource('unit-type', 'UnitTypeController');
    Route::name('unit-type')->get('/unit-type', 'UnitTypeController@index');
    
});
