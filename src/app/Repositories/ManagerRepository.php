<?php

namespace App\Repositories;

use App\Exceptions\ManagerHasRelatedFundsException;
use App\Exceptions\ManagerNotFoundException as EntityNotFound;
use App\Models\Manager;
use Exception;

class ManagerRepository extends BaseRepository
{
    protected $modelClass = Manager::class;
    protected $singleton;
    protected $entityNotFoundException = EntityNotFound::class;

    public function __construct()
    {
        $this->singleton = new $this->modelClass();
    }

    public function destroy($entity_id)
    {

        $this->singleton = $this->findByID($entity_id);
        try {
            if (!$this->singleton->funds->isEmpty()) {
                throw new ManagerHasRelatedFundsException();
            }

            $this->singleton->delete();
        } catch (Exception $e) {
            throw $e;
        }
        return true;
    }
}
