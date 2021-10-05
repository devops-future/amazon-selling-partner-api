<?php

Route::group([
        'prefix'     => 'core',
        'middleware' => ['web', 'theme']
    ], function () {

        Route::get('/', 'DevOpsFuture\Core\Http\Controllers\Portal\CoreController@index')->defaults('_config', [
            'view' => 'core::portal.index',
        ])->name('portal.core.index');

});