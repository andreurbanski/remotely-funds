<?php

namespace App\Repositories;

use App\Models\Company;
use App\Exceptions\CompanyHasRelatedFundsException;
use App\Exceptions\CompanyNotFoundException as EntityNotFound;
use Exception;

class CompanyRepository extends BaseRepository
{
    protected $modelClass = Company::class;
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
            if ($this->singleton->hasRelatedFunds()->isEmpty()) {
                throw new CompanyHasRelatedFundsException();
            }

            $this->singleton->delete();
        } catch (Exception $e) {
            throw $e;
        }
        return true;
    }

    public function listDuplicatedFunds()
    {
        return $this->singleton->checkDuplicateFund();
    }
}
