<?php

namespace DevOpsFuture\TestPackage\Repositories;

use DevOpsFuture\Core\Eloquent\Repository;

class ProductFeedStatusRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'DevOpsFuture\TestPackage\Contracts\ProductFeedStatus';
    }
}