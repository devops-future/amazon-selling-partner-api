<?php

namespace DevOpsFuture\TestPackage\Models;

use Illuminate\Database\Eloquent\Model;
use DevOpsFuture\TestPackage\Contracts\ProductFeedTemplate as ProductFeedTemplateContract;

class ProductFeedTemplate extends Model implements ProductFeedTemplateContract
{
    protected $guarded = [];
}
