<?php

namespace DevOpsFuture\TestPackage\Models;

use Illuminate\Database\Eloquent\Model;
use DevOpsFuture\TestPackage\Contracts\ProductFeedStatus as ProductFeedStatusContract;

class ProductFeedStatus extends Model implements ProductFeedStatusContract
{
    protected $guarded = [];
}
