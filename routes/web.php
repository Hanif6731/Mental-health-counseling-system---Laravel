<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/banned',function (){
    return view('ban');
});
Auth::routes();

Route::middleware('status')->get('/home', [Controllers\HomeController::class, 'index'])->name('home');
Route::middleware('status')->resource('doctor',Controllers\DoctorController::class);

Route::get('login/github', [Controllers\Auth\LoginController::class,'redirectToProvider'])->name('login.github');
Route::get('login/github/callback', [Controllers\Auth\LoginController::class,'handleProviderCallback']);
Route::group(['middleware'=>'doctorType'],function (){
    Route::group(['middleware'=>'DoctorProfile'],function(){
        Route::group(['middleware'=>'docValidity'],function (){
            Route::resource('doctor.appointment',Controllers\DocAppointmentController::class);
            Route::put('doctor/{docId}/appointment/{id}/accept',[Controllers\DocAppointmentController::class,'accept'])
                ->name('appointment.accept');
            Route::put('appointment/{id}/decline',[Controllers\DocAppointmentController::class,'decline'])
                ->name('appointment.decline');
            Route::get('doctor/appointment/search/{str}',[Controllers\DocAppointmentController::class,'search'])->name('appointment.search');
            Route::resource('doctor.forum',Controllers\DocForumController::class);
            Route::resource('doctor.forum.comment',Controllers\DocCommentController::class);
            //Route::resource('patient.docChatSession',Controllers\DocChatController::class);
            Route::get('doctor/{patient}/appointment/{aid}/chat',[Controllers\DocChatController::class,'index'])->name('docChat.index');
            Route::post('doctor/{patient}/appointment/{aid}/chat',[Controllers\DocChatController::class,'store'])->name('docChat.store');
            Route::get('chat/{patient}/getMessages',[Controllers\DocChatController::class,'getMessages']);
            Route::get('doctor/chatSession/patient/{id}/healthRecord',[Controllers\DocHealthRecordController::class,'index']);
            Route::post('doctor/{docId}/prescription',[Controllers\PrescriptionController::class,'store']);
            Route::put('session/{sid}/edit',[Controllers\SessionController::class,'update'])->name('doctor.chat.end');
            Route::get('doctor/{docId}/report/generate',[Controllers\DocReportGenController::class,'gen'])->name('doc.report.gen');
            Route::get('doctor/{docId}/report/earnings',[Controllers\DocTransactionController::class,'index'])->name('doc.earning.index');
            Route::get('doctor/{docId}/statistics/appointments',[App\Http\Controllers\DocAppointmentController::class,'stat'])->name('doc.stat.apt');
            Route::get('doctor/{docId}/statistics/generate',[App\Http\Controllers\DocReportGenController::class,'genStat'])->name('doc.stat.gen');


        });
        Route::get('doctor/{id}/invalid',[Controllers\DoctorController::class,'invalid'])->name('doctor.invalid');
    });
});



//admin

Route::group(['middleware'=>'adminType'],function (){
    Route::resource('admin',Controllers\AdminController::class);
    Route::resource('admin.userList',Controllers\UserListController::class);
    Route::resource('admin.doctorList', Controllers\DoctorListController::class);
    Route::resource('admin.subPlan',Controllers\SubplanController::class);
    Route::resource('admin.addStaff',Controllers\AddStaffController::class);
    Route::resource('admin.subscriptions',Controllers\SubscriptionController::class);
    Route::resource('admin.forum',Controllers\AdminForumController::class);
    Route::resource('admin.forum.comment',Controllers\AdminCommentController::class);
    Route::resource('admin.feedback',Controllers\FeedbackController::class);
    Route::get('userList/{userList}/delete/{id}',[Controllers\UserListController::class,'delete'])->name('userList.delete');
    Route::put('/admin/{admin}/doctorList/{doctorList}/ban/{id}',[Controllers\DoctorListController::class,'ban'])->name('doctorList.ban');
    Route::put('/admin/{admin}/doctorList/{doctorList}/valid/{id}',[Controllers\DoctorListController::class,'valid'])->name('doctorList.valid');
    Route::get('admin/{admin}/subReport/generate',[Controllers\SubscriptionController::class,'gen'])->name('admin.subReport.gen');
    Route::get('admin/{admin}/report/generate',[Controllers\FeedbackController::class,'gen'])->name('admin.report.gen');

});


//patients

Route::get('/patient',[App\Http\Controllers\PatientsController::class, 'index'])->name('patient.index');

Route::get('/patient/create',[App\Http\Controllers\PatientsController::class, 'create'])->name('patient.create');
Route::post('/patient/create',[App\Http\Controllers\PatientsController::class, 'store']);

Route::get('/patient/profile',[App\Http\Controllers\PatientsController::class, 'profile'])->name('patient.profile');

Route::get('/patient/appointment',[App\Http\Controllers\PatientsController::class, 'appointment'])->name('patient.appointment');
Route::post('/patient/appointment',[App\Http\Controllers\PatientsController::class, 'addReq']);
Route::get('/patient/appointment/{id}',[App\Http\Controllers\PatientsController::class, 'deleteReq'])->name('patient.deleteReq');
Route::get('/patient/pdf',[App\Http\Controllers\PatientsController::class, 'getList'])->name('patient.getList');

Route::get('/patient/docList',[App\Http\Controllers\PatientsController::class, 'docList'])->name('patient.docList');
Route::post('/patient/docList',[App\Http\Controllers\PatientsController::class, 'search']);

Route::get('/patient/prescriptions',[App\Http\Controllers\PatientsController::class, 'prescriptions'])->name('patient.prescriptions');
Route::get('/patient/prescriptions/{date}',[App\Http\Controllers\PatientsController::class, 'getPresc'])->name('patient.getPresc');

Route::get('/patient/subPlans',[App\Http\Controllers\PatientsController::class, 'subPlans'])->name('patient.subPlans');
Route::get('/patient/subPlans/{planId}',[App\Http\Controllers\PatientsController::class, 'editPlan'])->name('patient.editPlan');

Route::get('/patient/createRecord',[App\Http\Controllers\PatientsController::class, 'createRecord'])->name('patient.createRecord');
Route::post('/patient/createRecord',[App\Http\Controllers\PatientsController::class, 'insertRecord']);

Route::get('/patient/updateRecord',[App\Http\Controllers\PatientsController::class, 'updateRecord'])->name('patient.updateRecord');
Route::post('/patient/updateRecord',[App\Http\Controllers\PatientsController::class, 'editRecord']);

Route::get('/patient/updateProfile',[App\Http\Controllers\PatientsController::class, 'updateProfile'])->name('patient.updateProfile');
Route::post('/patient/updateProfile',[App\Http\Controllers\PatientsController::class, 'editProfile']);

Route::get('/patient/changePassword',[App\Http\Controllers\PatientsController::class, 'changePassword'])->name('patient.changePassword');
Route::post('/patient/changePassword',[App\Http\Controllers\PatientsController::class, 'updatePassword']);


//staff

Route::group(['middleware'=>'staffType'],function (){
    Route::resource('staff',\App\Http\Controllers\StaffController::class);
    Route::resource('staff.userList',\App\Http\Controllers\StaffUserListController::class);
    Route::resource('staff.doctorList',\App\Http\Controllers\StaffDoctorListController::class);
    Route::get('userList/{userList}/delete/{id}',[App\Http\Controllers\StaffUserListController::class,'delete'])->name('userList.delete');
    Route::resource('staff.forum',\App\Http\Controllers\StaffForumController::class);
    Route::resource('staff.forum.comment',\App\Http\Controllers\StaffCommentController::class);
    Route::resource('staff.feedback',\App\Http\Controllers\StaffFeedbackController::class);
    Route::put('/staff/{staff}/doctorList/{doctorList}/ban/{id}',[App\Http\Controllers\StaffDoctorListController::class,'ban'])->name('doctorList.ban');


});


