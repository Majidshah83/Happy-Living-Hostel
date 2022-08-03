<?php

use App\Http\Controllers\VacantSeatController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider. Now create something great!
|
*/

Route::get('home', 'HomeController@index')->name('home');

// Auth Routes

Auth::routes();

Route::group(['middleware' => ['auth']], function() {

Route::group(['middleware' => 'Role:Employee,Admin'], function () {

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');


    Route::get('/reporting', 'ReportController@report')->name('day_off_process');
    Route::get('export/{id?}', 'ReportController@export')->name('export');
    Route::get('export-pdf/{id?}', 'ReportController@exportPdf')->name('export-pdf');
    Route::get('export-pdf-orders', 'ReportController@export_pdf_orders')->name('export-pdf-orders');
    Route::post('download-excell-order', 'ReportController@downloadExcellOrder')->name('download-excell-order');
    // Route::get('dashboard', 'DashboardController@getAllOrdersPage');
    //     Route::post('get-all-orders-post', 'DashboardController@getAllOrders');


});

Route::group(['middleware' => 'Role:Admin'], function () {


    Route::group(['middleware' => 'xssClean'], function () {

        Route::get('profile', 'ProfileController@index')->name('profile');
        Route::get('change-password', 'ProfileController@changePassword');
        Route::post('update-password', 'ProfileController@updatePassword');
        Route::post('update-email', 'ProfileController@updateEmail');
        Route::get('edit-profile', 'ProfileController@editProfile');
        Route::post('update-profile-info', 'ProfileController@updateProfileInfo');

     	// Banner Routes

        Route::resource('student-fee', 'StudentFeeController');




        Route::get('fee-details-print/{hash_id?}','StudentFeeController@feeDetailPrint');
        Route::get('student/fee-detail/{id}', 'StudentFeeController@feeStudentDetailPrint');
        Route::get('student/profile/{id}', 'StudentFeeController@studentProfile');
        Route::post('get-room-student', 'StudentFeeController@getStudent');
        Route::post('get-student-balanace', 'StudentFeeController@getStudentBalanace');
        Route::post('get-student-fee', 'FeeController@getStudentFee');
        Route::resource('expense', 'ExpenseController');
         Route::get('getall/expense/{month}', 'ExpenseController@getAllExpense')->name('getall/expense/');
        Route::get('expense/fee-details-print/{hash_id?}','ExpenseController@feeDetailPrint');
        Route::post('monthExpense', 'ExpenseController@getSumAmount')->name('monthExpense');


        // Common operations routes

        // Route::group(["prefix" => "common_operations"], function(){

        Route::post("common_operations/change_status",'McCommonOperationController@change_status')->name('common_status');

        Route::post("common_operations/change_order",'McCommonOperationController@change_order')->name('common_change_order');

        Route::post("common_operations/get_table_row",'McCommonOperationController@get_table_row')->name('common_get_table_row');


        // });//Route::group(["prefix" => "common_operations"], function(){




        /****************** END => PHARMACY MENUS ******************/

        Route::get('student/fee/create', 'FeeController@create');


        Route::post('student/fee/store', 'FeeController@store');
        Route::get('student/fee/update/{hash_id?}', 'FeeController@edit');
        Route::put('student/fee/update/{hash_id?}', 'FeeController@update');
        Route::DELETE('fee-delete/{hash_id?}', 'FeeController@destroy');
        Route::get('student-fee-receipt/{id?}', 'FeeController@studentFeeReceipt');
        Route::post('download-student-fee-report', 'FeeController@studentDownloadFeeReceipt');

        //collect amount
         Route::get('getall/amount/collect', 'FeeController@getAllCollectAmount')->name('getall/amount/collect');
        //collection amount
         Route::get('getall/amount/collection', 'FeeController@getAllCollectionAmount')->name('getall/amount/collection');


        Route::get('reports', 'ReportController@index');

        Route::post('reports/all', 'ReportController@getAllReports');
        Route::post('download-student-fee-reports', 'ReportController@studentDownloadFeeReceipt');



        /****************** start => Resource Routes Crud  ******************/

        Route::resource('page-sections', 'PageSectionController');

        Route::get('check-in-student','StudentController@index');
        Route::get('check-out-student','StudentController@checkOutStudent');

        Route::resource('students', 'StudentController');
        Route::post('get-floor-rooms', 'StudentController@getRooms');
        Route::resource('staffs', 'StaffController');

        Route::resource('floors', 'FloorsController');
        Route::resource('rooms', 'RoomsController');
        //total seats
        Route::get('total_seat','RoomsController@totalSeats')->name('total_seat');

        Route::resource('users', 'UsersController');

        Route::get('/user-change-password/{hash_id}', 'UsersController@getPasswordUpdateForm');
        Route::post('update-user-password', 'UsersController@updatePassword');

        /****************** End => Resource Routes Crud  ******************/

        /****************** start => Common opertions Crud  ******************/

        Route::prefix('common_operations')->group(function (){
           Route::post("/change_status",'McCommonOperationController@change_status')->name('common_status');
           Route::post("/change_order",'McCommonOperationController@change_order')->name('common_change_order');
           Route::post("/get_table_row",'McCommonOperationController@get_table_row')->name('common_get_table_row');
        });

        /****************** end => Common opertions Crud  ******************/

        Route::post('update-statff-password', 'StaffController@updateStaffPassword');

        //vacant seats
        Route::get('vacant_seats','VacantSeatController@index')->name('vacant_seats');


       });

    });


});