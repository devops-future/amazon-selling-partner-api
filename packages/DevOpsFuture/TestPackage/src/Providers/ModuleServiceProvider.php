<?php

namespace DevOpsFuture\TestPackage\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \DevOpsFuture\TestPackage\Models\ProductFeedStatus::class,
        \DevOpsFuture\TestPackage\Models\ProductFeedTemplate::class,
    ];
}
