<?php

Route::group([
        'prefix'        => 'admin/testamazon',
        'middleware'    => ['web', 'admin']
    ], function () {

        Route::get('', 'DevOpsFutre\TestAmazon\Http\Controllers\Admin\TestAmazonController@index')->defaults('_config', [
            'view' => 'testamazon::admin.index',
        ])->name('admin.testamazon.index');

});