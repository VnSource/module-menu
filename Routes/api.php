<?php

Route::group(['prefix' => 'v1', 'middleware' => 'permission:menu'], function () {
    Route::post('menu/sort', 'Backend\MenuController@sortMenu');
    Route::resource('menu', 'Backend\MenuController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
});