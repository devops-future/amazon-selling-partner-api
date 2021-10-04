<?php

Route::group([
        'prefix'     => 'testamazon',
        'middleware' => ['web', 'theme', 'locale', 'currency']
    ], function () {

        Route::get('/', 'DevOpsFutre\TestAmazon\Http\Controllers\Shop\TestAmazonController@index')->defaults('_config', [
            'view' => 'testamazon::shop.index',
        ])->name('shop.testamazon.index');

});