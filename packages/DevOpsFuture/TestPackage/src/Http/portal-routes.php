<?php

Route::group([
        'prefix'     => 'test',
        'middleware' => ['web']
    ], function () {

        Route::get('/', 'DevOpsFuture\TestPackage\Http\Controllers\Portal\TestPackageController@index')->defaults('_config', [
            'view' => 'testpackage::portal.default.index',
        ])->name('portal.testpackage.index');

});
