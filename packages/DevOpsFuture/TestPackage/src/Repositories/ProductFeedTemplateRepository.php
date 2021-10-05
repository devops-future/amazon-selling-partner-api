<?php

namespace DevOpsFuture\TestPackage\Repositories;

use DevOpsFuture\Core\Eloquent\Repository;

class ProductFeedTemplateRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'DevOpsFuture\TestPackage\Contracts\ProductFeedTemplate';
    }

    public function generateTemplateBy($product_type, $param=[]) {
        $record_obj = $this->findOneByField('product_type', $product_type);
        if($record_obj) {
            $search_list = explode(',', $record_obj->field_list);
            $replace_list = [];
            foreach($search_list as $key=>$search) {
                if(!isset($param[$search])) {
                    return false;
                }
                $search_list[$key] = '%'.$search.'%';
                $replace_list[] = $param[$search];
            }
            return str_replace($search_list, $replace_list, $record_obj->template);

        } else {
            return false;
        }
    }
}
