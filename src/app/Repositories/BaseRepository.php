<?php

namespace App\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Pagination\AbstractPaginator as Paginator;

abstract class BaseRepository
{
    /**
     * Model class for repo.
     *
     * @var string
     */
    protected $modelClass;
    protected $singleton;
    protected $entityNotFoundException;

    /**
     * @return EloquentQueryBuilder|QueryBuilder
     */
    protected function newQuery()
    {
        return app($this->modelClass)->newQuery();
    }

    /**
     * @param EloquentQueryBuilder|QueryBuilder $query
     * @param int                               $take
     * @param bool                              $paginate
     *
     * @return EloquentCollection|Paginator
     */
    protected function doQuery($query = null, $parameters)
    {
        $take = $parameters->take ?? 15 ;
        $paginate = $parameters->paginate ?? true;

        if (is_null($query)) {
            $query = $this->newQuery();
        }

        foreach ($this->singleton->filters as $filter => $type) {
            if (array_key_exists($filter, $parameters)) {
                switch ($type) {
                    case 'string': {
                        $query->where($filter, 'like', '%' . $parameters[$filter] . '%');
                    }
                    default: {
                        $query->where($filter, '=', $parameters[$filter]);
                    }
                }
            }
        }

        if (true == $paginate) {
            return $query->paginate($take);
        }

        if ($take > 0 || false !== $take) {
            $query->take($take);
        }

        return $query->get();
    }

    /**
     * Returns all records.
     * If $take is false then brings all records
     * If $paginate is true returns Paginator instance.
     *
     * @param int  $take
     * @param bool $paginate
     *
     * @return EloquentCollection|Paginator
     */
    public function getAll($parameters = [])
    {
        return $this->doQuery(null, $parameters);
    }

    /**
     * @param string      $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection
     */
    public function lists($column, $key = null)
    {
        return $this->newQuery()->lists($column, $key);
    }

    /**
     * Retrieves a record by his id
     * If fail is true $ fires ModelNotFoundException.
     *
     * @param int  $id
     * @param bool $fail
     *
     * @return Model
     */
    public function findByID($id, $fail = true)
    {
        try {
            $entity = $this->modelClass::find($id);

            if (is_null($entity)) {
                throw new $this->entityNotFoundException();
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $entity;
    }

    public function createOrUpdate($parameters, $entity_id = null)
    {

        if (!is_null($entity_id)) {
            $this->singleton = $this->findByID($entity_id);
        }

        $this->singleton->fill($parameters)->save();
        return $this->singleton->fresh();
    }
}
