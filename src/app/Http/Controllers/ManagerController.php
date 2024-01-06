<?php

namespace App\Http\Controllers;

use App\Exceptions\ManagerHasRelatedFundsException;
use App\Exceptions\ManagerNotFoundException;
use App\Http\Requests\StoreManagerRequest;
use App\Models\Manager;
use App\Http\Controllers\Controller;
use App\Repositories\ManagerRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    protected $managerRepository;
    public function __construct()
    {
        $this->managerRepository = new ManagerRepository();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json($this->managerRepository->getAll($request->all()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreManagerRequest $request)
    {
        return response()->json($this->managerRepository->createOrUpdate($request->all()), 201);

    }

    /**
     * Display the specified resource.
     */
    public function show($manager_id)
    {
        return response()->json($this->managerRepository->findById($manager_id));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreManagerRequest $request, $manager_id)
    {
        return response()->json($this->managerRepository->createOrUpdate($request->all(), $manager_id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($manager_id)
    {
        return response()->json($this->managerRepository->destroy($manager_id), 200);
    }
}
