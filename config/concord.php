<?php

return [
    'convention' => DevOpsFuture\Core\CoreConvention::class,

    'modules' => [
        /**
         * Example:
         * VendorA\ModuleX\Providers\ModuleServiceProvider::class,
         * VendorB\ModuleY\Providers\ModuleServiceProvider::class
         *
         */

        \DevOpsFuture\Core\Providers\ModuleServiceProvider::class,
        \DevOpsFuture\Theme\Providers\ModuleServiceProvider::class,
        \DevOpsFuture\Portal\Providers\ModuleServiceProvider::class,
        \DevOpsFuture\TestPackage\Providers\ModuleServiceProvider::class,
    ]
];
