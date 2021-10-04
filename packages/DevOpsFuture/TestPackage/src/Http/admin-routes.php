<?php

Route::group([
        'prefix'        => 'admin/testpackage',
        'middleware'    => ['web']
    ], function () {

        Route::get('', 'DevOpsFuture\TestPackage\Http\Controllers\Admin\TestPackageController@index')->defaults('_config', [
            'view' => 'testpackage::admin.index',
        ])->name('admin.testpackage.index');

});
