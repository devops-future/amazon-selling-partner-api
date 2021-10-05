<?php

Route::group([
        'prefix'     => 'test',
        'middleware' => ['web']
    ], function () {

    Route::get('/', 'DevOpsFuture\TestPackage\Http\Controllers\Portal\TestPackageController@index')->defaults('_config', [
        'view' => 'testpackage::portal.default.index',
    ])->name('portal.testpackage.index');

    Route::get('/apaapi', 'DevOpsFuture\TestPackage\Http\Controllers\Portal\TestPackageController@test_apaapi')->name('portal.testpackage.apaapi');

    Route::get('/create-feed', 'DevOpsFuture\TestPackage\Http\Controllers\Portal\TestPackageController@test_create_feed')->name('portal.testpackage.create-feed');

    Route::get('/list-catalog-items', 'DevOpsFuture\TestPackage\Http\Controllers\Portal\TestPackageController@test_list_catalog_items')->name('portal.testpackage.list-catalog-items');

    Route::get('/get-definition-product-type', 'DevOpsFuture\TestPackage\Http\Controllers\Portal\TestPackageController@test_get_definition_product_type')->name('portal.testpackage.get-definition-product-type');

    Route::get('/get-reports', 'DevOpsFuture\TestPackage\Http\Controllers\Portal\TestPackageController@get_reports')->name('portal.testpackage.get-reports');

    Route::get('/get-report-document', 'DevOpsFuture\TestPackage\Http\Controllers\Portal\TestPackageController@test_get_report_document')->name('portal.testpackage.get-report-document');

    Route::get('/put-listings-item', 'DevOpsFuture\TestPackage\Http\Controllers\Portal\TestPackageController@test_put_litings_item')->name('portal.testpackage.put-litings-item');

});
