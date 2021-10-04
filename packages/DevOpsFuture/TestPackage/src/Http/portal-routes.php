<?php

Route::group([
        'prefix'     => 'testpackage',
        'middleware' => ['web', 'theme', 'locale', 'currency']
    ], function () {

        Route::get('/', 'DevOpsFuture\TestPackage\Http\Controllers\Portal\TestPackageController@index')->defaults('_config', [
            'view' => 'testpackage::portal.index',
        ])->name('portal.testpackage.index');

});