<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FundController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ManagerController;


use App\Models\Company;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::controller(FundController::class)
        ->group(function () {
            Route::prefix("funds")
            //->middleware()
            ->group(function () {
                Route::get('/list', 'index');
                Route::get('/show/{fund}', 'show');
                Route::post('/store/', 'store');
                Route::patch('/update/{fund}', 'update');
                Route::delete('/destroy/{fund}', 'destroy');
                Route::post('/add-company/', 'addCompany');
                Route::get('/list-companies/{fund_id}', 'listCompanies');
                Route::delete('/remove-company/{fund_id}/{company_id}', 'removeCompany');
                Route::get('/list-duplicated-funds/', 'listDuplicatedFunds');
            });
        });

Route::controller(CompanyController::class)
->group(function () {
    Route::prefix("companies")
    //->middleware()
    ->group(function () {
        Route::get('/list', 'index');
        Route::get('/show/{company}', 'show');
        Route::post('/store/', 'store');
        Route::patch('/update/{company}', 'update');
        Route::delete('/destroy/{company}', 'destroy');
    });
});

Route::controller(ManagerController::class)
->group(function () {
    Route::prefix("managers")
    //->middleware()
    ->group(function () {
        Route::get('/list', 'index');
        Route::get('/show/{manager}', 'show');
        Route::post('/store', 'store');
        Route::patch('/update/{manager}', 'update');
        Route::delete('/destroy/{manager}', 'destroy');
    });
});
