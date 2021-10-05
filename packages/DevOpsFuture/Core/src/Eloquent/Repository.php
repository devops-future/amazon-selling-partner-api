<?php

namespace DevOpsFuture\Core\Eloquent;

use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
use Prettus\Repository\Traits\CacheableRepository;
use Staudenmeir\LaravelUpsert\DatabaseServiceProvider;

abstract class Repository extends BaseRepository implements CacheableInterface {

    use CacheableRepository;

    /**
     * Find data by field and value
     *
     * @param  string  $field
     * @param  string  $value
     * @param  array  $columns
     * @return mixed
     */
    public function findOneByField($field, $value = null, $columns = ['*'])
    {
        $model = $this->findByField($field, $value, $columns = ['*']);

        return $model->first();
    }

    /**
     * Find data by field and value
     *
     * @param  string  $field
     * @param  string  $value
     * @param  array  $columns
     * @return mixed
     */
    public function findOneWhere(array $where, $columns = ['*'])
    {
        $model = $this->findWhere($where, $columns);

        return $model->first();
    }

    /**
     * Find data by id
     *
     * @param  int  $id
     * @param  array  $columns
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->find($id, $columns);
        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * Find data by id
     *
     * @param  int  $id
     * @param  array  $columns
     * @return mixed
     */
    public function findOrFail($id, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->findOrFail($id, $columns);
        $this->resetModel();

        return $this->parserResult($model);
    }

     /**
     * Count results of repository
     *
     * @param  array  $where
     * @param  string  $columns
     * @return int
     */
    public function count(array $where = [], $columns = '*')
    {
        $this->applyCriteria();
        $this->applyScope();

        if ($where) {
            $this->applyConditions($where);
        }

        $result = $this->model->count($columns);
        $this->resetModel();
        $this->resetScope();

        return $result;
    }

    /**
     * @param  string  $columns
     * @return mixed
     */
    public function sum($columns)
    {
        $this->applyCriteria();
        $this->applyScope();

        $sum = $this->model->sum($columns);
        $this->resetModel();

        return $sum;
    }

    /**
     * @param  string  $columns
     * @return mixed
     */
    public function avg($columns)
    {
        $this->applyCriteria();
        $this->applyScope();

        $avg = $this->model->avg($columns);
        $this->resetModel();

        return $avg;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Insert new records or update the existing ones.
     *
     * @param array $values
     * @param array|string $target
     * @param array|null $update
     * @return int
     */
    public function upsert(array $values, $target, array $update = null) {
        return $this->model->upsert($values, $target, $update);
    }

    public function sliceUpsert(array $data, $target, array $update = null, $slice_length = 100) {
        for($index = 0; $index < count($data); $index += $slice_length) {
            $length = $index + $slice_length < count($data) ? $slice_length : count($data) - $index;
            $this->upsert(array_slice($data, $index, $length), $target, $update);
        };
    }

    public function sliceInsert(array $data, $slice_length = 100) {
        for($index = 0; $index < count($data); $index += $slice_length) {
            $length = $index + $slice_length < count($data) ? $slice_length : count($data) - $index;
            $this->insert(array_slice($data, $index, $length));
        };
    }
}
