<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/Search', [App\Http\Controllers\HomeController::class, 'search'])->name('searchPage');
    Route::post('/ExportImportRequestNotes', [App\Http\Controllers\HomeController::class, 'exportImportRequestNotes'])->name('exportImportRequestNotes');
    Route::post('/ExportImportRequestNotesByDate', [App\Http\Controllers\HomeController::class, 'exportImportRequestNotesByDate'])->name('exportImportRequestNotesByDate');

    // Store Room Mangament---------------------------


    Route::get('/StoreRoom', [App\Http\Controllers\DeviceController::class, 'storeRoom'])->name('storeRoom');
    Route::post('/StockingDevices', [App\Http\Controllers\DeviceController::class, 'stockingDevices'])->name('stockingDevices');
    Route::get('/ShowDevice/{device_slug}', [App\Http\Controllers\DeviceController::class, 'showDevice'])->name('showDevice');
    Route::get('/ShowAllDevices/{device_model}', [App\Http\Controllers\DeviceController::class, 'showAllDevices'])->name('showAllDevices');
    Route::post('/UpdateDevice/{device_slug}', [App\Http\Controllers\DeviceController::class, 'updateDevice'])->name('updateDevice');

    // Store Room Mangament---------------------------


    // ImportRequestNoteController Mangament---------------------------


    Route::get('/CreateImportRequestNote', [App\Http\Controllers\ImportRequestNoteController::class, 'createImportRequestNote'])->name('createImportRequestNote');
    Route::post('/StoreImportRequestNote', [App\Http\Controllers\ImportRequestNoteController::class, 'storeImportRequestNote'])->name('storeImportRequestNote');
    Route::get('/ShowImportRequestNote/{import_request_note_slug}', [App\Http\Controllers\ImportRequestNoteController::class, 'showImportRequestNote'])->name('showImportRequestNote');
    Route::post('/UpdateImportRequestNote/{import_request_note_slug}', [App\Http\Controllers\ImportRequestNoteController::class, 'updateImportRequestNote'])->name('updateImportRequestNote');

    Route::get('/SelectDevicesToRestoreBack/{institution_slug}', [App\Http\Controllers\ImportRequestNoteController::class, 'selectDevicesToRestoreBack'])->name('selectDevicesToRestoreBack');
    Route::get('/SelectDevicesToRestoreBackFromPerson/{employee_slug}', [App\Http\Controllers\ImportRequestNoteController::class, 'selectDevicesToRestoreBackFromPerson'])->name('selectDevicesToRestoreBackFromPerson');
    Route::post('/StoreDevicesBack/{institution_slug}', [App\Http\Controllers\ImportRequestNoteController::class, 'storeDevicesBack'])->name('storeDevicesBack');
    Route::post('/UpdateDevicesBack/{import_request_note_slug}', [App\Http\Controllers\ImportRequestNoteController::class, 'updateDevicesBack'])->name('updateDevicesBack');

    Route::post('/ImportRequestNotesLog', [App\Http\Controllers\ImportRequestNoteController::class, 'importRequestNotesLog'])->name('importRequestNotesLog');
    Route::get('/DeleteImportRequestNote/{import_request_note_slug}', [App\Http\Controllers\ImportRequestNoteController::class, 'destroyImportRequestNote'])->name('destroyImportRequestNote');
    // ImportRequestNoteController Mangament---------------------------


    // ExportRequestNoteController Mangament---------------------------


    Route::get('/SelectExportRequestNote/{institution_slug}', [App\Http\Controllers\ExportRequestNoteController::class, 'selectExportRequestNote'])->name('selectExportRequestNote');
    Route::get('/SelectExportRequestNoteForPerson/{employee_slug}', [App\Http\Controllers\ExportRequestNoteController::class, 'selectExportRequestNoteForPerson'])->name('selectExportRequestNoteForPerson');
    Route::post('/ExportDevices/{institution_slug}', [App\Http\Controllers\ExportRequestNoteController::class, 'storeExportRequestNote'])->name('storeExportRequestNote');
    Route::post('/UpdateExportRequestNote/{export_request_note_slug}', [App\Http\Controllers\ExportRequestNoteController::class, 'updateExportRequestNote'])->name('updateExportRequestNote');
    Route::get('/ShowExportRequestNote/{export_request_note_slug}', [App\Http\Controllers\ExportRequestNoteController::class, 'showExportRequestNote'])->name('showExportRequestNote');

    Route::post('/ExportRequestNotesLog', [App\Http\Controllers\ExportRequestNoteController::class, 'exportRequestNotesLog'])->name('exportRequestNotesLog');
    Route::get('/DeleteExportRequestNote/{export_request_note_slug}', [App\Http\Controllers\ExportRequestNoteController::class, 'destroyExportRequestNote'])->name('destroyExportRequestNote');
    // ExportRequestNoteController Mangament---------------------------



    // Employees Mangament---------------------------

    Route::get('/Employees', [App\Http\Controllers\EmployeeController::class, 'allEmployees'])->name('allEmployees');
    Route::get('/ShowEmployee/{employee_slug}', [App\Http\Controllers\EmployeeController::class, 'showEmployee'])->name('showEmployee');
    Route::post('/StoreEmployeeProfile/{institution_slug}', [App\Http\Controllers\EmployeeController::class, 'storeEmployeeProfile'])->name('storeEmployeeProfile');
    Route::post('/UpdateEmployeeProfile/{employee_slug}', [App\Http\Controllers\EmployeeController::class, 'updateEmployeeProfile'])->name('updateEmployeeProfile');
    Route::post('/ChangeEmployeeInstitution/{employee_slug}', [App\Http\Controllers\EmployeeController::class, 'changeEmployeeInstitution'])->name('changeEmployeeInstitution');

    Route::get('/DestroyEmployeeProfile/{employee_slug}', [App\Http\Controllers\EmployeeController::class, 'destroyEmployeeProfile'])->name('destroyEmployeeProfile');


    // Employees Mangament---------------------------

    // Users Mangament---------------------------

    Route::get('/Users', [App\Http\Controllers\EmployeeController::class, 'allUsers'])->name('allUsers');
    Route::get('/ShowUser/{user_slug}', [App\Http\Controllers\EmployeeController::class, 'showUser'])->name('showUser');
    Route::post('/UpdateUser/{user_slug}', [App\Http\Controllers\EmployeeController::class, 'updateUser'])->name('updateUser');
    Route::get('/DestroyUser/{user_slug}', [App\Http\Controllers\EmployeeController::class, 'destroyUser'])->name('destroyUser');

    // Users Mangament---------------------------

    // Institutions Mangament---------------------------

    Route::get('/Institutions', [App\Http\Controllers\InstitutionController::class, 'allInstitutions'])->name('allInstitutions');
    Route::get('/ShowInstitution/{institution_slug}', [App\Http\Controllers\InstitutionController::class, 'showInstitution'])->name('showInstitution');
    Route::get('/InstitutionMap/{institution_slug}', [App\Http\Controllers\InstitutionController::class, 'institutionMap'])->name('institutionMap');

    Route::get('/DevicesFromMainToSubInstitution/{institution_slug}', [App\Http\Controllers\InstitutionController::class, 'devices_main_sub_institution'])->name('devices_main_sub_institution');
    Route::post('/Store_devices_to_sub_institution/{institution_slug}', [App\Http\Controllers\InstitutionController::class, 'store_devices_to_sub_institution'])->name('store_devices_to_sub_institution');

    Route::get('/DevicesFromSubToMainInstitution/{institution_slug}', [App\Http\Controllers\InstitutionController::class, 'devices_sub_main_institution'])->name('devices_sub_main_institution');
    Route::post('/Store_devices_to_main_institution/{institution_slug}', [App\Http\Controllers\InstitutionController::class, 'store_devices_to_main_institution'])->name('store_devices_to_main_institution');


    Route::post('/StoreInstitution', [App\Http\Controllers\InstitutionController::class, 'storeInstitution'])->name('storeInstitution');
    Route::post('/EditInstitution/{institution_slug}', [App\Http\Controllers\InstitutionController::class, 'updateInstitution'])->name('updateInstitution');
    // Route::post('/StoreDevices', [App\Http\Controllers\EmployeeController::class, 'store_import_request_notes'])->name('store_import_request_notes');

    // Institutions Mangament---------------------------


    // RedirectDevice Mangament---------------------------
    Route::get('/SelectNextSide/{institution_slug}', [App\Http\Controllers\RedirectDeviceController::class, 'selectNextSide'])->name('selectNextSide');
    Route::get('/SelectNextSideFromPerson/{employee_slug}', [App\Http\Controllers\RedirectDeviceController::class, 'selectNextSideFromPerson'])->name('selectNextSideFromPerson');
    Route::post('/RedirectDevicesTo', [App\Http\Controllers\RedirectDeviceController::class, 'storeRedirectDevice'])->name('storeRedirectDevice');
    Route::get('/RedirectDevicesNotesLog', [App\Http\Controllers\RedirectDeviceController::class, 'redirectDevicesNotesLog'])->name('redirectDevicesNotesLog');
    Route::get('/ShowRedirectDeviceNote/{redirect_note_slug}', [App\Http\Controllers\RedirectDeviceController::class, 'showRedirectDeviceNote'])->name('showRedirectDeviceNote');
    Route::get('/DestroyRedirectDeviceNote/{redirect_note_slug}', [App\Http\Controllers\RedirectDeviceController::class, 'destroyRedirectDeviceNote'])->name('destroyRedirectDeviceNote');


    // RedirectDevice Mangament---------------------------

});

// Route::group(['middleware' => 'auth'], function () {
  

// });