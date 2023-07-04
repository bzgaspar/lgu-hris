<?php

use App\Http\Controllers\admin\PlantillaController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\hr\empPmsController;
use App\Http\Controllers\hr\RangkingController;
use App\Http\Controllers\hr\YearlyIPCRController;
use App\Models\hr\YearlyIPCR;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/*', function (Request $request) {
    return $request->user();
});


Route::get('/getMyInfo', [HomeController::class, 'getMyInfo'])->name('getMyInfo');

Route::resource('/user', UserController::class);
Route::get('/getDepartment', [HomeController::class, 'getDepartment'])->name('getDepartment');
Route::get('/getDepartmentIPCR/{year}', [HomeController::class, 'getDepartmentIPCR'])->name('getDepartmentIPCR');
Route::get('/getAllUser', [HomeController::class, 'getAllUser'])->name('getAllUser');
Route::get('/getHrmpsbUser', [HomeController::class, 'getHrmpsbUser'])->name('getHrmpsbUser');
Route::get('/getLeave', [HomeController::class, 'getLeave'])->name('getLeave');
Route::get('/getLeaveApp', [HomeController::class, 'getLeaveApp'])->name('getLeaveApp');
Route::get('/getServiceRecord', [HomeController::class, 'getServiceRecord'])->name('getServiceRecord');
Route::get('/getPlantilla', [HomeController::class, 'getPlantilla'])->name('getPlantilla');
Route::get('/getPublication', [HomeController::class, 'getPublication'])->name('getPublication');
Route::get('/getMinute', [HomeController::class, 'getMinute'])->name('getMinute');
Route::get('/getHour', [HomeController::class, 'getHour'])->name('getHour');
Route::get('/getEarn', [HomeController::class, 'getEarn'])->name('getEarn');
Route::get('/getPreviousLeave/{user_id}/{leave_card_id}', [HomeController::class, 'getPreviousLeave'])->name('getPreviousLeave');
Route::get('/getUserLeave/{user_id}', [HomeController::class, 'getUserLeave'])->name('getUserLeave');
Route::get('/getLeaveCredit/{user_id}', [HomeController::class, 'getLeaveCredit'])->name('getLeaveCredit');


// rsp
Route::get('/getApplicants', [HomeController::class, 'getApplicants'])->name('getApplicants');
Route::get('/getRanking', [RangkingController::class, 'getRanking'])->name('getRanking');
Route::get('/getAccepted', [RangkingController::class, 'getAccepted'])->name('getAccepted');

// pms
Route::get('/getEmployee', [HomeController::class, 'getEmployee'])->name('getEmployee');
Route::get('/getTop5', [HomeController::class, 'getTop5'])->name('getTop5');
Route::get('/getDepartmentHead', [HomeController::class, 'getDepartmentHead'])->name('getDepartmentHead');
Route::get('/getLoyalty', [HomeController::class, 'getLoyalty'])->name('getLoyalty');
Route::get('/getYearsIPCR', [HomeController::class, 'getYearsIPCR'])->name('getYearsIPCR');
Route::get('/getYearsIPCR2', [HomeController::class, 'getYearsIPCR2'])->name('getYearsIPCR2');
Route::get('/getAverage/{dep_id}', [HomeController::class, 'getAverage'])->name('getAverage');
Route::get('/getYearlyRating', [HomeController::class, 'getYearlyRating'])->name('getYearlyRating');
Route::get('/getYearlyTopRating', [HomeController::class, 'getYearlyTopRating'])->name('getYearlyTopRating');


//
Route::get('/getChartEMP', [HomeController::class, 'getChartEMP'])->name('getChartEMP');
