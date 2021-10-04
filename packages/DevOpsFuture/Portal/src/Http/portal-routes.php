<?php

Route::group([
        'prefix'     => 'portal',
        'middleware' => ['web', 'theme', 'locale', 'currency']
    ], function () {

        Route::get('/', 'DevOpsFuture\Portal\Http\Controllers\Portal\PortalController@index')->defaults('_config', [
            'view' => 'portal::portal.index',
        ])->name('portal.portal.index');

});