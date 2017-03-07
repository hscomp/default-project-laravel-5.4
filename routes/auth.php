<?php

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| Here is where you can register authentication routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "auth" middleware group. Now create something great!
|
*/

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('auth.loginForm');
Route::post('login', 'Auth\LoginController@login')->name('auth.loginAction');
Route::post('logout', 'Auth\LoginController@logout')->name('auth.logoutAction');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('auth.registerForm');
Route::post('register', 'Auth\RegisterController@register')->name('auth.registerAction');
Route::get('activation/{token}', 'Auth\RegisterController@activate')->name('auth.activate');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.passwordRequestForm');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.sendPasswordResetLink');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('auth.passwordResetForm');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.passwordResetAction');

Route::get('/home', 'HomeController@index');
