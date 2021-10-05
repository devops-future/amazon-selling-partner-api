<?php

namespace DevOpsFuture\TestPackage\Repositories;

use DevOpsFuture\Core\Eloquent\Repository;

class ProductFeedXmlRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'DevOpsFuture\TestPackage\Contracts\ProductFeedXml';
    }

    public function generateXmlBy($product_type, $param=[]) {
        $record_obj = $this->findOneByField('product_type', $product_type);
        if($record_obj) {
            print_r($record_obj->template);
        } else {
            return false;
        }
    }
}
