<?php

Route::group([
        'prefix'        => 'admin/core',
        'middleware'    => ['web']
    ], function () {

        Route::get('', 'DevOpsFuture\Core\Http\Controllers\Admin\CoreController@index')->defaults('_config', [
            'view' => 'core::admin.index',
        ])->name('admin.core.index');

});