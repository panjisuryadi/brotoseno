<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'auth'], function () {

    //User Profile
    Route::get('/user/profile', 'ProfileController@edit')->name('profile.edit');
    Route::get('/user/generate', 'UsersController@codeGenerate')->name('users.code');
    Route::patch('/user/profile', 'ProfileController@update')->name('profile.update');
    Route::patch('/user/password', 'ProfileController@updatePassword')->name('profile.update.password');

    //Users
    Route::resource('users', 'UsersController')->except('show');
    Route::get('roles/index-data', 'RolesController@index_data')->name('roles.index_data');
    Route::resource('roles', 'RolesController')->except('show');
    //Roles

    Route::get('permissions/edit/{id}', 'PermissionController@edit')->name('permissions.edit');

    Route::post('permissions/single', 'PermissionController@single')->name('permissions.single');
    Route::post('permissions/update', 'PermissionController@update')->name('permissions.update');
    Route::get('permissions/add-single', 'PermissionController@addSingle')->name('permissions.addsingle');

    Route::get('permissions/index-data', 'PermissionController@index_data')->name('permissions.index_data');
    Route::resource('permissions', 'PermissionController');

});
