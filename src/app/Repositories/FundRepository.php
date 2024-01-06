<?php

namespace App\Repositories;

use App\Events\DuplicatedFundWarning;
use App\Exceptions\DuplicateCompanyForFundException;
use App\Exceptions\FundHasRelatedCompaniesException;
use App\Exceptions\FundNotFoundException as EntityNotFound;
use App\Models\Fund;
use App\Models\FundCompany;
use Exception;

class FundRepository extends BaseRepository
{
    protected $modelClass = Fund::class;
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
            if (!$this->singleton->companies->isEmpty()) {
                throw new FundHasRelatedCompaniesException();
            }

            $this->singleton->delete();
        } catch (Exception $e) {
            throw $e;
        }
        return true;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addCompany($parameters)
    {
        $this->singleton = $this->findByID($parameters['fund_id']);
        $company = (new CompanyRepository())->findById($parameters['company_id']);

        if (!$this->singleton ->checkDuplicates($company)->isEmpty()) {
            throw new DuplicateCompanyForFundException();
        }

        $fundCompany = new FundCompany();
        $fundCompany->fill(["company_id" => $company->id, "fund_id" => $this->singleton->id])->save();

        $fund = $this->singleton->fresh();

        return response()->json($fund);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function removeCompany($fund_id, $company_id)
    {
        $this->singleton = $this->findByID($fund_id);
        $company = (new CompanyRepository())->findById($company_id);

        FundCompany::where('company_id', $company->id)->where('fund_id', $this->singleton->id)->delete();

        $fund = $this->singleton->fresh();

        return response()->json($fund);
    }

    /**
     * List all possible duplicated funds
     */
    public function checkDuplicatedFunds()
    {
        return $this->singleton->checkDuplicatedFunds();
    }

    /**
     * Overwrite the Parent's createOrUpdate method
     */
    public function createOrUpdate($parameters, $entity_id = null)
    {

        if (!is_null($entity_id)) {
            $this->singleton = $this->findByID($entity_id);
        }

        $this->singleton->fill($parameters)->save();
        $this->singleton->fresh();

        if($duplicates = $this->modelClass::checkDuplicatedFunds($this->singleton)) {
            event(new DuplicatedFundWarning($this->singleton, $duplicates));
        }

        return $this->singleton;
    }
}
