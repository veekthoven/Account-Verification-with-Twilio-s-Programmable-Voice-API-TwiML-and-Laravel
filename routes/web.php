<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('verifiedphone');

Route::get('phone/verify', 'PhoneVerificationController@show')->name('phoneverification.notice');
Route::post('phone/verify', 'PhoneVerificationController@verify')->name('phoneverification.verify');
Route::get('phone/call-again', 'PhoneVerificationController@callUserAgain')->name('phoneverification.resend');
Route::post('build-twiml/{code}', 'PhoneVerificationController@buildTwiMl')->name('phoneverification.build');
