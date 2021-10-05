<?php

namespace DevOpsFuture\TestPackage\Models;

use Illuminate\Database\Eloquent\Model;
use DevOpsFuture\TestPackage\Contracts\ProductFeedXml as ProductFeedXmlContract;

class ProductFeedXml extends Model implements ProductFeedXmlContract
{
    protected $guarded = [];
}
