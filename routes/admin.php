<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('admin')->user();

    //dd($users);

    return view('admin.home');
})->name('home');



Route::get('/plans','PlanController@index');
Route::post('/plans','PlanController@store');
Route::get('/addplan','PlanController@create');
Route::get('/plans/edit/{id}','PlanController@edit');
Route::post('/plans/{id}','PlanController@update');


Route::get('/users','UserController@index');