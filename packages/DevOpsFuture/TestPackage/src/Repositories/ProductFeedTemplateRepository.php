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

    public function generateXmlBy($product_type, $param=[]) {
        $record_obj = $this->findOneWhere([
            'template_type' => 'xml',
            'product_type'  => $product_type,
        ]);
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

    public function generateCsvBy($product_type, $param=[]) {
        $record_obj = $this->findOneWhere([
            'template_type' => 'csv',
            'product_type'  => $product_type,
        ]);
        if($record_obj) {
            $key_list = explode(',', $record_obj->field_list);
            $value_list = [];
            foreach($key_list as $key) {
                if(!isset($param[$key])) {
                    return false;
                }
                $value_list[] = $param[$key];
            }
            return implode("\t", $key_list)."\r\n".implode("\t", $value_list);

        } else {
            return false;
        }
    }
}
