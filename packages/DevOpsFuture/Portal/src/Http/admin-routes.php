<?php

Route::group([
        'prefix'        => 'admin/portal',
        'middleware'    => ['web', 'admin']
    ], function () {

        Route::get('', 'DevOpsFuture\Portal\Http\Controllers\Admin\PortalController@index')->defaults('_config', [
            'view' => 'portal::admin.index',
        ])->name('admin.portal.index');

});