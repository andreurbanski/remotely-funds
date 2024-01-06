<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Controllers\Controller;
use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected $companyRepository;

    public function __construct()
    {
        $this->companyRepository = new CompanyRepository();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json($this->companyRepository->getAll($request->all()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        return response()->json($this->companyRepository->createOrUpdate($request->all()), 201);

    }

    /**
     * Display the specified resource.
     */
    public function show($company_id)
    {
        return response()->json($this->companyRepository->findById($company_id));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCompanyRequest $request, $company_id)
    {
        return response()->json($this->companyRepository->createOrUpdate($request->all(), $company_id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($company_id)
    {
        return response()->json($this->companyRepository->destroy($company_id), 200);
    }
}
