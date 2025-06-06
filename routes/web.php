<?php

use App\Http\Controllers\AccreditedLearningServiceProviderController;
use App\Http\Controllers\admin\Department;
use App\Http\Controllers\admin\PlantillaController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\Files201Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\hr\applicantController;
use App\Http\Controllers\hr\AssessmentController;
use App\Http\Controllers\hr\certificatesController;
use App\Http\Controllers\hr\dashboard;
use App\Http\Controllers\hr\empPmsController;
use App\Http\Controllers\hr\hrmpsbController;
use App\Http\Controllers\hr\InterviewExamController;
use App\Http\Controllers\SeparatedController;
use App\Http\Controllers\hr\leaveApplicationController;
use App\Http\Controllers\hr\LeaveRecordController;
use App\Http\Controllers\hr\ListAwardsController;
use App\Http\Controllers\hr\loyaltyAwardController;
use App\Http\Controllers\hr\ManageApplicantsController;
use App\Http\Controllers\hr\printingController;
use App\Http\Controllers\hr\PublicationController;
use App\Http\Controllers\hr\RangkingController;
use App\Http\Controllers\hr\ServiceRecord;
use App\Http\Controllers\hr\surveyAnswerController;
use App\Http\Controllers\hr\surveyFormController;
use App\Http\Controllers\hr\surveyQuestionController;
use App\Http\Controllers\hr\surveyResultController;
use App\Http\Controllers\hr\top5Controller;
use App\Http\Controllers\hr\TrainingNeedsController;
use App\Http\Controllers\hr\YearlyIPCRController;
use App\Http\Controllers\IPCR_FormController;
use App\Http\Controllers\IPCR_OPCR_MFO_Controller;
use App\Http\Controllers\IPCR_OPCRQuestionController;
use App\Http\Controllers\ipcrController;
use App\Http\Controllers\OPCR_FormController;
use App\Http\Controllers\users\AccountController;
use App\Http\Controllers\users\application;
use App\Http\Controllers\users\CovidController;
use App\Http\Controllers\users\files;
use App\Http\Controllers\users\LeaveApplication;
use App\Http\Controllers\users\pds\CivilService;
use App\Http\Controllers\users\pds\Educational;
use App\Http\Controllers\users\pds\Family;
use App\Http\Controllers\users\pds\FamilyC;
use App\Http\Controllers\users\pds\LearningDevelopment;
use App\Http\Controllers\users\pds\OtherController;
use App\Http\Controllers\users\pds\OtherInformation;
use App\Http\Controllers\users\pds\Personal;
use App\Http\Controllers\users\pds\VoluntaryWork;
use App\Http\Controllers\users\pds\WorkExperience;
use App\Http\Controllers\users\SignatureController;
use App\Http\Controllers\users\User;
use App\Models\hr\ListAwards;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/setStorage', [HomeController::class, 'setStorage']);
Route::get('/', [HomeController::class, 'index'])->name('publication');
Auth::routes(['verify' => true]);

Route::group(['middleware' => 'auth','middleware' => 'role:0,1,2,3,4,5,7','middleware' => 'verified'], function () {

    Route::get('/getUserPds', [HomeController::class, 'getUserPds'])->name('getUserPds');
    Route::get('/getUser', [HomeController::class, 'getUser'])->name('getUser');
    Route::get('/ProfileView/{user_id}', [User::class, 'ProfileView'])->name('ProfileView');


    Route::group(['prefix' => 'users','as' => 'users.'], function () {
        // pds
        Route::group(['prefix' => 'pds','as' => 'pds.'], function () {
            Route::get('/', [User::class, 'index'])->name('index');
            Route::resource('/personal', Personal::class);
            Route::resource('/family', Family::class);
            Route::resource('/familyC', FamilyC::class);
            Route::resource('/educational', Educational::class);
            Route::resource('/civilservice', CivilService::class);
            Route::resource('/workexperience', WorkExperience::class);
            Route::resource('/voluntarywork', VoluntaryWork::class);
            Route::resource('/learningdevelopment', LearningDevelopment::class);
            Route::resource('/otherinformation', OtherInformation::class);
            Route::resource('/other', OtherController::class);
            Route::get('/{user_id}/print', [application::class, 'print'])->name('print');
        });
        // pds
        // esignature
        Route::resource('/eSignature', SignatureController::class);
        // IPCR
        Route::resource('/IPCR', IPCR_FormController::class);
        Route::resource('/OPCR', OPCR_FormController::class);
        Route::resource('/Files_201', Files201Controller::class);

        // user stuff
        Route::resource('/account', AccountController::class);
        Route::resource('/files', files::class);
        Route::resource('/covid', CovidController::class);
        Route::resource('/surveyAnswer', surveyAnswerController::class);
        Route::resource('/myleave', LeaveApplication::class);

        // application
        Route::resource('/application', application::class);
        Route::patch('/application/{id}/resubmit', [application::class,'resubmit'])->name('application.resubmit');
        Route::delete('/application/{id}/delete', [application::class,'delete'])->name('application.delete');
        Route::post('/application/{id}/apply', [application::class, 'apply'])->name('application.apply');
        Route::get('/application/{id}/edit/{app_id}', [application::class, 'edit'])->name('application.edit');
        Route::patch('/application/{id}/update/{app_id}', [application::class, 'update'])->name('application.update');
        // application

        // user stuff

    });
    #hr
    Route::group(['prefix' => 'HumanResource','as' => 'hr.','middleware' => 'role:0,4,7,3'], function () {
        // lnd
        Route::resource('/lnd', LearningDevelopment::class);
        Route::resource('/trainingneeds', TrainingNeedsController::class); // compliance
        Route::resource('/assessment', AssessmentController::class); // submitting training needs
        Route::resource('/surveyQuestion', surveyQuestionController::class);
        Route::resource('/surveyForm', surveyFormController::class);
        Route::resource('/surveyResult', surveyResultController::class);
        // lnd
        Route::resource('/providers', AccreditedLearningServiceProviderController::class);

        // pms
        Route::resource('/pms', ipcrController::class);
        Route::resource('/MFO_Questions', IPCR_OPCR_MFO_Controller::class);
        Route::resource('/Indicators_questions', IPCR_OPCRQuestionController::class);
        Route::resource('/pmsEmployee', empPmsController::class);
        // pms

        // r&r
        Route::resource('/loyalty', loyaltyAwardController::class);
        Route::resource('/top5', top5Controller::class);
        Route::resource('/certificates', certificatesController::class);
        Route::resource('/listAwards', ListAwardsController::class);
        // r&r

        // rsp
        Route::resource('/interview', InterviewExamController::class);
        Route::resource('/separated', SeparatedController::class);
        Route::resource('/manage_applicants', ManageApplicantsController::class);
        Route::resource('/applicant', applicantController::class);
        Route::resource('/ranking', RangkingController::class);
        Route::resource('/hrmpsb', hrmpsbController::class);
        // rsp

        // hr stuff
        Route::resource('/department', Department::class);
        Route::resource('/plantilla', PlantillaController::class);
        Route::resource('/leave', LeaveRecordController::class);
        Route::resource('/publication', PublicationController::class);
        Route::resource('/service', ServiceRecord::class);
        Route::get('/service/{id}/edit_record', [ServiceRecord::class, 'edit_record'])->name('service.edit_record');
        Route::delete('/deleteRating/{id}', [applicantController::class, 'deleteRating']);
        Route::delete('/deleteRatingAdd/{id}', [applicantController::class, 'deleteRatingAdd']);
        Route::resource('/dashboard', dashboard::class);
        Route::resource('/printing', printingController::class);
        Route::resource('/leaveApplication', leaveApplicationController::class);
        Route::resource('/yearlyIPCR', YearlyIPCRController::class);

        // print gender
        Route::get('/employeesGender/{gender}', [User::class, 'employeesGender'])->name('user.employeesGender');
        Route::get('/ViewByGenderCount', [User::class, 'ViewByGenderCount'])->name('ViewByGenderCount');
        Route::get('/ViewPwdSpI', [User::class, 'ViewPwdSpI'])->name('ViewPwdSpI');
        Route::get('/ViewStatus', [User::class, 'ViewStatus'])->name('ViewStatus');
        Route::get('/ViewCovidResponse', [User::class, 'ViewCovidResponse'])->name('ViewCovidResponse');


        Route::get('/PrintReligions', [HomeController::class, 'getReligionPrint'])->name('GetReligionPrint');

        Route::get('/user/covid', [User::class, 'covid'])->name('user.covid');
        Route::get('/leavecard/{id}', [LeaveRecordController::class,'print'])->name('leavecard');
        // hr stuff

    });
    #admin
    Route::group(['prefix' => 'Administrator','as' => 'admin.','middleware' => 'role:0'], function () {
        Route::resource('/user', UserController::class);
        Route::delete('/user/{id}/delete', [User::class, 'delete'])->name('user.delete');
        Route::get('/user/{id}/reset', [User::class, 'reset'])->name('user.reset');
        Route::patch('/user/{id}/activate', [User::class, 'activate'])->name('user.activate');
        Route::patch('/user/{id}/unbanned', [User::class, 'unbanned'])->name('user.unbanned');


        Route::get('/backUpDB', [User::class, 'backUpDB'])->name('backUpDB');
        Route::get('/backUp', [User::class, 'backUp'])->name('backUp');
        Route::get('/backUpClean', [User::class, 'backUpClean'])->name('backUpClean');
        Route::get('/scheduler', [User::class, 'scheduler'])->name('scheduler');
    });
});
