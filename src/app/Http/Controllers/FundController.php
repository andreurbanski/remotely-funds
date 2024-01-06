<?php

namespace App\Http\Controllers;

use App\Events\DuplicatedFundWarning;
use App\Exceptions\CompanyNotFoundException;
use App\Exceptions\DuplicateCompanyForFundException;
use App\Exceptions\FundHasRelatedCompaniesException;
use App\Exceptions\FundNotFoundException;
use App\Http\Requests\StoreFundRequest;
use App\Http\Requests\AddCompanyFundRequest;
use App\Models\Fund;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateFundRequest;
use App\Models\Company;
use App\Models\FundCompany;
use App\Repositories\FundRepository;
use Exception;
use Illuminate\Http\Request;

class FundController extends Controller
{
    protected $fundRepository;

    public function __construct()
    {
        $this->fundRepository = new FundRepository();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json($this->fundRepository->getAll($request->all()));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFundRequest $request)
    {
        return response()->json($this->fundRepository->createOrUpdate($request->all()), 201);

    }

    /**
     * Display the specified resource.
     */
    public function show($fund_id)
    {
        return response()->json($this->fundRepository->findById($fund_id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFundRequest $request, $fund_id)
    {
        return response()->json($this->fundRepository->createOrUpdate($request->all(), $fund_id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($fund_id)
    {
        return response()->json($this->fundRepository->destroy($fund_id), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addCompany(AddCompanyFundRequest $request)
    {
        return response()->json($this->fundRepository->addCompany($request->all()), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function removeCompany($fund_id, $company_id)
    {
        return response()->json($this->fundRepository->removeCompany($fund_id, $company_id), 200);
    }

    public function listDuplicatedFunds()
    {
        return response()->json($this->fundRepository->checkDuplicatedFunds(), 200);
    }
}
