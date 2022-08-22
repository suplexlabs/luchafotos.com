<?php

namespace App\Repositories;

use Closure;
use Exception;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class BaseRepository
 *
 * @package Prettus\Repository\Eloquent
 * @author  Anderson Andrade <contato@andersonandra.de>
 */
abstract class BaseRepository
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var array
     */
    protected $fieldSearchable = [];

    /**
     * Collection of Criteria
     *
     * @var Collection
     */
    protected $criteria;

    /**
     * @var bool
     */
    protected $skipCriteria = false;

    /**
     * @var \Closure
     */
    protected $scopeQuery = null;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
        $this->boot();
    }

    /**
     *
     */
    public function boot()
    {
        //
    }

    /**
     * Returns the current Model instance
     *
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    public function resetModel()
    {
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    abstract public function model();

    /**
     * @return Model
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * Get Searchable Fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Query Scope
     *
     * @param \Closure $scope
     *
     * @return $this
     */
    public function scopeQuery(\Closure $scope)
    {
        $this->scopeQuery = $scope;

        return $this;
    }

    /**
     * Retrieve data array for populate field select
     *
     * @param string      $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection|array
     */
    public function lists($column, $key = null)
    {
        return $this->model->lists($column, $key);
    }

    /**
     * Retrieve data array for populate field select
     * Compatible with Laravel 5.3
     *
     * @param string      $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection|array
     */
    public function pluck($column, $key = null)
    {
        return $this->model->pluck($column, $key);
    }

    /**
     * Sync relations
     *
     * @param      $id
     * @param      $relation
     * @param      $attributes
     * @param bool $detaching
     *
     * @return mixed
     */
    public function sync($id, $relation, $attributes, $detaching = true)
    {
        return $this->find($id)->{$relation}()->sync($attributes, $detaching);
    }

    /**
     * SyncWithoutDetaching
     *
     * @param $id
     * @param $relation
     * @param $attributes
     *
     * @return mixed
     */
    public function syncWithoutDetaching($id, $relation, $attributes)
    {
        return $this->sync($id, $relation, $attributes, false);
    }

    /**
     * Retrieve all data of repository
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        $this->applyScope();

        if ($this->model instanceof Builder) {
            $results = $this->model->get($columns);
        } else {
            $results = $this->model->all($columns);
        }

        $this->resetModel();
        $this->resetScope();

        return $this->parserResult($results);
    }

    /**
     * Count results of repository
     *
     * @param array  $where
     * @param string $columns
     *
     * @return int
     */
    public function count(array $where = [], $columns = '*')
    {
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
     * Alias of All method
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function get($columns = ['*'])
    {
        return $this->all($columns);
    }

    /**
     * Retrieve first data of repository
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function first($columns = ['*'])
    {
        $this->applyScope();

        $results = $this->model->first($columns);

        $this->resetModel();

        return $this->parserResult($results);
    }

    /**
     * Retrieve first data of repository, or return new Entity
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function firstOrNew(array $attributes = [])
    {
        $this->applyScope();

        $model = $this->model->firstOrNew($attributes);
        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * Retrieve first data of repository, or create new Entity
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function firstOrCreate(array $attributes = [])
    {
        $this->applyScope();

        $model = $this->model->firstOrCreate($attributes);
        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * Retrieve data of repository with limit applied
     *
     * @param int   $limit
     * @param array $columns
     *
     * @return mixed
     */
    public function limit($limit, $columns = ['*'])
    {
        // Shortcut to all with `limit` applied on query via `take`
        $this->take($limit);

        return $this->all($columns);
    }

    /**
     * Retrieve all data of repository, paginated
     *
     * @param int $limit
     * @param array    $columns
     * @param string   $method
     *
     * @return mixed
     */
    public function paginate($limit, $columns = ['*'], $method = "paginate")
    {
        $this->applyScope();
        $results = $this->model->{$method}($limit, $columns);
        $results->appends(app('request')->query());
        $this->resetModel();

        return $this->parserResult($results);
    }

    /**
     * Retrieve all data of repository, simple paginated
     *
     * @param null|int $limit
     * @param array    $columns
     *
     * @return mixed
     */
    public function simplePaginate($limit = null, $columns = ['*'])
    {
        return $this->paginate($limit, $columns, "simplePaginate");
    }

    /**
     * Find data by id
     *
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        $this->applyScope();
        $model = $this->model->findOrFail($id, $columns);
        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * Find data by field and value
     *
     * @param       $field
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findByField($field, $value = null, $columns = ['*'])
    {
        $this->applyScope();
        $model = $this->model->where($field, '=', $value)->get($columns);
        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * Find data by multiple fields
     *
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhere(array $where, $columns = ['*'])
    {
        $this->applyScope();
        $this->applyConditions($where);

        $model = $this->model->get($columns);
        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * Find data by multiple values in one field
     *
     * @param       $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhereIn($field, array $values, $columns = ['*'])
    {
        $this->applyScope();
        $model = $this->model->whereIn($field, $values)->get($columns);
        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * Find data by excluding multiple values in one field
     *
     * @param       $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhereNotIn($field, array $values, $columns = ['*'])
    {
        $this->applyScope();
        $model = $this->model->whereNotIn($field, $values)->get($columns);
        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * Find data by between values in one field
     *
     * @param       $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhereBetween($field, array $values, $columns = ['*'])
    {
        $this->applyScope();
        $model = $this->model->whereBetween($field, $values)->get($columns);
        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * Save a new entity in repository
     *
     * @param array $attributes
     *
     * @return mixed
     *
     */
    public function create(array $attributes)
    {
        $model = $this->model->newInstance($attributes);
        $model->save();
        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * Update a entity in repository by id
     *
     * @param array $attributes
     * @param       $id
     *
     * @return mixed
     *
     */
    public function update(array $attributes, $id)
    {
        $this->applyScope();

        $model = $this->model->findOrFail($id);
        $model->fill($attributes);
        $model->save();

        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * Update or Create an entity in repository
     *
     * @param array $attributes
     * @param array $values
     *
     * @return mixed
     *
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        $this->applyScope();

        $model = $this->model->updateOrCreate($attributes, $values);
        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * Delete a entity in repository by id
     *
     * @param $id
     *
     * @return int
     */
    public function delete($id)
    {
        $this->applyScope();

        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);

        $model = $this->find($id);
        $originalModel = clone $model;

        $this->resetModel();

        $deleted = $model->delete();

        return $deleted;
    }

    /**
     * Delete multiple entities by given criteria.
     *
     * @param array $where
     *
     * @return int
     */
    public function deleteWhere(array $where)
    {
        $this->applyScope();
        $this->applyConditions($where);

        $deleted = $this->model->delete();
        $this->resetModel();

        return $deleted;
    }

    /**
     * Check if entity has relation
     *
     * @param string $relation
     *
     * @return $this
     */
    public function has($relation)
    {
        $this->model = $this->model->has($relation);

        return $this;
    }

    /**
     * Load relations
     *
     * @param array|string $relations
     *
     * @return $this
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);

        return $this;
    }

    /**
     * Add subselect queries to count the relations.
     *
     * @param mixed $relations
     *
     * @return $this
     */
    public function withCount($relations)
    {
        $this->model = $this->model->withCount($relations);
        return $this;
    }

    /**
     * Load relation with closure
     *
     * @param string  $relation
     * @param closure $closure
     *
     * @return $this
     */
    public function whereHas($relation, $closure)
    {
        $this->model = $this->model->whereHas($relation, $closure);

        return $this;
    }

    /**
     * Set hidden fields
     *
     * @param array $fields
     *
     * @return $this
     */
    public function hidden(array $fields)
    {
        $this->model->setHidden($fields);

        return $this;
    }

    /**
     * Set the "orderBy" value of the query.
     *
     * @param mixed  $column
     * @param string $direction
     *
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->model = $this->model->orderBy($column, $direction);

        return $this;
    }

    /**
     * Set the "limit" value of the query.
     *
     * @param int $limit
     *
     * @return $this
     */
    public function take($limit)
    {
        // Internally `take` is an alias to `limit`
        $this->model = $this->model->limit($limit);

        return $this;
    }

    /**
     * Set visible fields
     *
     * @param array $fields
     *
     * @return $this
     */
    public function visible(array $fields)
    {
        $this->model->setVisible($fields);

        return $this;
    }

    /**
     * Reset Query Scope
     *
     * @return $this
     */
    public function resetScope()
    {
        $this->scopeQuery = null;

        return $this;
    }

    /**
     * Apply scope in current Query
     *
     * @return $this
     */
    protected function applyScope()
    {
        if (isset($this->scopeQuery) && is_callable($this->scopeQuery)) {
            $callback = $this->scopeQuery;
            $this->model = $callback($this->model);
        }

        return $this;
    }

    /**
     * Applies the given where conditions to the model.
     *
     * @param array $where
     *
     * @return void
     */
    protected function applyConditions(array $where)
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                //smooth input
                $condition = preg_replace('/\s\s+/', ' ', trim($condition));

                //split to get operator, syntax: "DATE >", "DATE =", "DAY <"
                $operator = explode(' ', $condition);
                if (count($operator) > 1) {
                    $condition = $operator[0];
                    $operator = $operator[1];
                } else $operator = null;
                switch (strtoupper($condition)) {
                    case 'IN':
                        if (!is_array($val)) throw new Exception("Input {$val} mus be an array");
                        $this->model = $this->model->whereIn($field, $val);
                        break;
                    case 'NOTIN':
                        if (!is_array($val)) throw new Exception("Input {$val} mus be an array");
                        $this->model = $this->model->whereNotIn($field, $val);
                        break;
                    case 'DATE':
                        if (!$operator) $operator = '=';
                        $this->model = $this->model->whereDate($field, $operator, $val);
                        break;
                    case 'DAY':
                        if (!$operator) $operator = '=';
                        $this->model = $this->model->whereDay($field, $operator, $val);
                        break;
                    case 'MONTH':
                        if (!$operator) $operator = '=';
                        $this->model = $this->model->whereMonth($field, $operator, $val);
                        break;
                    case 'YEAR':
                        if (!$operator) $operator = '=';
                        $this->model = $this->model->whereYear($field, $operator, $val);
                        break;
                    case 'EXISTS':
                        if (!($val instanceof Closure)) throw new Exception("Input {$val} must be closure function");
                        $this->model = $this->model->whereExists($val);
                        break;
                    case 'HAS':
                        if (!($val instanceof Closure)) throw new Exception("Input {$val} must be closure function");
                        $this->model = $this->model->whereHas($field, $val);
                        break;
                    case 'HASMORPH':
                        if (!($val instanceof Closure)) throw new Exception("Input {$val} must be closure function");
                        $this->model = $this->model->whereHasMorph($field, $val);
                        break;
                    case 'DOESNTHAVE':
                        if (!($val instanceof Closure)) throw new Exception("Input {$val} must be closure function");
                        $this->model = $this->model->whereDoesntHave($field, $val);
                        break;
                    case 'DOESNTHAVEMORPH':
                        if (!($val instanceof Closure)) throw new Exception("Input {$val} must be closure function");
                        $this->model = $this->model->whereDoesntHaveMorph($field, $val);
                        break;
                    case 'BETWEEN':
                        if (!is_array($val)) throw new Exception("Input {$val} mus be an array");
                        $this->model = $this->model->whereBetween($field, $val);
                        break;
                    case 'BETWEENCOLUMNS':
                        if (!is_array($val)) throw new Exception("Input {$val} mus be an array");
                        $this->model = $this->model->whereBetweenColumns($field, $val);
                        break;
                    case 'NOTBETWEEN':
                        if (!is_array($val)) throw new Exception("Input {$val} mus be an array");
                        $this->model = $this->model->whereNotBetween($field, $val);
                        break;
                    case 'NOTBETWEENCOLUMNS':
                        if (!is_array($val)) throw new Exception("Input {$val} mus be an array");
                        $this->model = $this->model->whereNotBetweenColumns($field, $val);
                        break;
                    case 'RAW':
                        $this->model = $this->model->whereRaw($val);
                        break;
                    default:
                        $this->model = $this->model->where($field, $condition, $val);
                }
            } else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }
    }

    /**
     * Wrapper result data
     *
     * @param mixed $result
     *
     * @return mixed
     */
    public function parserResult($result)
    {
        return $result;
    }

    /**
     * Trigger static method calls to the model
     *
     * @param $method
     * @param $arguments
     *
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        return call_user_func_array([new static(), $method], $arguments);
    }

    /**
     * Trigger method calls to the model
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        $this->applyScope();
        return call_user_func_array([$this->model, $method], $arguments);
    }
}
