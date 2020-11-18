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
    return redirect('employee/login');
})->name('user.home');

Route::get('/employee/home', 'HomeUserController@index')->name('user.home');
Route::post('/employee/home', 'HomeUserController@GetNullSheets')->name('user.home.GetNullSheets');
Route::get('/admin/home', 'HomeAdminController@index')->name('admin.home');
Route::post('/admin/home', 'HomeAdminController@GetNullSheets')->name('admin.home.GetNullSheets');


Route::get('/register', 'Auth\RegisterController@index')->name('register');
Route::post('/register/admin', 'Auth\RegisterController@registerAdmin')->name('register.admin');
Route::post('/register/employee', 'Auth\RegisterController@registerEmployee')->name('register.employee');
Route::post('/register/admin/code', 'Auth\RegisterController@AuthinticationEmail')->name('register.admin.code');

Route::get('/employee/login', 'Auth\LoginController@index')->name('user.login');
Route::post('/employee/login', 'Auth\LoginController@login')->name('user.login.submit');


Route::get('/admin/login', 'Auth\LoginAdminController@index')->name('admin.login');
Route::post('/admin/login', 'Auth\LoginAdminController@login')->name('admin.login.submit');

Route::get('/logout', 'Auth\LoginController@logout')->name('user.logout');
Route::get('/admin/logout', 'Auth\LoginAdminController@logout')->name('admin.logout');

// Get Labels Of Traceability
Route::post('/admin/labels', 'HomeAdminController@getLabels')->name('admin.get.labels');
Route::post('/user/labels', 'HomeUserController@getLabels')->name('user.get.labels');

/* Insert Sheets For Employee */

// Drowing
Route::post('employee/drowing', 'User\DrowingController@insertDrowing')->name('user.drowing');
Route::post('employee/findDrowingStandard', 'User\DrowingController@findJopOrderNumber')->name('user.findDrowingStandard');
Route::post('employee/drowing/get-row', 'User\DrowingController@getRow')->name('user.get.row.drowing');
Route::post('employee/drowing/checkRow', 'User\DrowingController@checkRow')->name('user.check.row.drowing');

// Stranding
Route::post('employee/stranding', 'User\StrandingController@insertStranding')->name('user.stranding');
Route::post('employee/findStrandingStandard', 'User\StrandingController@findJopOrderNumber')->name('user.findStrandingStandard');
Route::post('employee/stranding/get-row', 'User\StrandingController@getRow')->name('user.get.row.stranding');
Route::post('employee/stranding/checkRow', 'User\StrandingController@checkRow')->name('user.check.row.stranding');


// Insulation
Route::post('employee/insulation', 'User\InsulationController@insertInsulation')->name('user.insulation');
Route::post('employee/findInsulationStandard', 'User\InsulationController@findJopOrderNumber')->name('user.findInsulationStandard');
Route::post('employee/insulation/get-row', 'User\InsulationController@getRow')->name('user.get.row.insulation');
Route::post('employee/insulation/checkRow', 'User\InsulationController@checkRow')->name('user.check.row.insulation');

// Bedding
Route::post('employee/bedding', 'User\BeddingController@insertBedding')->name('user.bedding');
Route::post('employee/findBeddingStandard', 'User\BeddingController@findJopOrderNumber')->name('user.findBeddingStandard');
Route::post('employee/bedding/get-row', 'User\BeddingController@getRow')->name('user.get.row.bedding');
Route::post('employee/bedding/checkRow', 'User\BeddingController@checkRow')->name('user.check.row.bedding');

// Sheathing
Route::post('employee/sheathing', 'User\SheathingController@insertSheathing')->name('user.sheathing');
Route::post('employee/findSheathingStandard', 'User\SheathingController@findJopOrderNumber')->name('user.findSheathingStandard');
Route::post('employee/sheathing/get-row', 'User\SheathingController@getRow')->name('user.get.row.sheathing');
Route::post('employee/sheathing/checkRow', 'User\SheathingController@checkRow')->name('user.check.row.sheathing');

// Screen
Route::post('employee/screen', 'User\ScreenController@insertScreen')->name('user.screen');
Route::post('employee/findScreenStandard', 'User\ScreenController@findJopOrderNumber')->name('user.findScreenStandard');
Route::post('employee/screen/get-row', 'User\ScreenController@getRow')->name('user.get.row.screen');
Route::post('employee/screen/checkRow', 'User\ScreenController@checkRow')->name('user.check.row.screen');

// Assembly
Route::post('employee/assembly', 'User\AssemblyController@insertAssembly')->name('user.assembly');
Route::post('employee/findAssemblyStandard', 'User\AssemblyController@findJopOrderNumber')->name('user.findAssemblyStandard');
Route::post('employee/assembly/get-row', 'User\AssemblyController@getRow')->name('user.get.row.assembly');
Route::post('employee/assembly/checkRow', 'User\AssemblyController@checkRow')->name('user.check.row.assembly');

// Armouring
Route::post('employee/armouring', 'User\ArmouringController@insertArmouring')->name('user.armouring');
Route::post('employee/findArmouringStandard', 'User\ArmouringController@findJopOrderNumber')->name('user.findArmouringStandard');
Route::post('employee/armouring/get-row', 'User\ArmouringController@getRow')->name('user.get.row.armouring');
Route::post('employee/armouring/checkRow', 'User\ArmouringController@checkRow')->name('user.check.row.armouring');

// Taps
Route::post('employee/taps', 'User\TapsController@insertTaps')->name('user.taps');
Route::post('employee/findTapsStandard', 'User\TapsController@findJopOrderNumber')->name('user.findTapsStandard');
Route::post('employee/taps/get-row', 'User\TapsController@getRow')->name('user.get.row.taps');
Route::post('employee/taps/checkRow', 'User\TapsController@checkRow')->name('user.check.row.taps');

// Lead
Route::post('employee/lead', 'User\LeadController@insertLead')->name('user.lead');
Route::post('employee/findLeadStandard', 'User\LeadController@findJopOrderNumber')->name('user.findLeadStandard');
Route::post('employee/lead/get-row', 'User\LeadController@getRow')->name('user.get.row.lead');
Route::post('employee/lead/checkRow', 'User\LeadController@checkRow')->name('user.check.row.lead');

// CCVInsulation
Route::post('employee/CCVInsulation', 'User\CCVInsulationController@insertCCVInsulation')->name('user.CCVInsulation');
Route::post('employee/findCCVInsulationStandard', 'User\CCVInsulationController@findJopOrderNumber')->name('user.findCCVInsulationStandard');
Route::post('employee/CCVInsulation/get-row', 'User\CCVInsulationController@getRow')->name('user.get.row.CCVInsulation');
Route::post('employee/CCVInsulation/checkRow', 'User\CCVInsulationController@checkRow')->name('user.check.row.CCVInsulation');


// Finish
Route::post('employee/finish', 'User\FinishController@insertFinish')->name('user.finish');

// Hold
Route::post('employee/hold', 'User\HoldController@insertHold')->name('user.hold');

// Rewind
Route::post('employee/rewind', 'User\RewindController@insertRewind')->name('user.rewind');


/* Insert Sheets For Admin */

// Drowing
Route::post('admin/drowing', 'Admin\DrowingController@insertDrowing')->name('admin.drowing');
Route::post('admin/findDrowingStandard', 'Admin\DrowingController@findJopOrderNumber')->name('admin.findDrowingStandard');
Route::post('admin/drowing/get-row', 'Admin\DrowingController@getRow')->name('admin.get.row.drowing');

// Stranding
Route::post('admin/stranding', 'Admin\StrandingController@insertStranding')->name('admin.stranding');
Route::post('admin/findStrandingStandard', 'Admin\StrandingController@findJopOrderNumber')->name('admin.findStrandingStandard');
Route::post('admin/stranding/get-row', 'Admin\StrandingController@getRow')->name('admin.get.row.stranding');


// Insulation
Route::post('admin/insulation', 'Admin\InsulationController@insertInsulation')->name('admin.insulation');
Route::post('admin/findInsulationStandard', 'Admin\InsulationController@findJopOrderNumber')->name('admin.findInsulationStandard');
Route::post('admin/insulation/get-row', 'Admin\InsulationController@getRow')->name('admin.get.row.insulation');

// Bedding
Route::post('admin/bedding', 'Admin\BeddingController@insertBedding')->name('admin.bedding');
Route::post('admin/findBeddingStandard', 'Admin\BeddingController@findJopOrderNumber')->name('admin.findBeddingStandard');
Route::post('admin/bedding/get-row', 'Admin\BeddingController@getRow')->name('admin.get.row.bedding');

// Sheathing
Route::post('admin/sheathing', 'Admin\SheathingController@insertSheathing')->name('admin.sheathing');
Route::post('admin/findSheathingStandard', 'Admin\SheathingController@findJopOrderNumber')->name('admin.findSheathingStandard');
Route::post('admin/sheathing/get-row', 'Admin\SheathingController@getRow')->name('admin.get.row.sheathing');

// Screen
Route::post('admin/screen', 'Admin\ScreenController@insertScreen')->name('admin.screen');
Route::post('admin/findScreenStandard', 'Admin\ScreenController@findJopOrderNumber')->name('admin.findScreenStandard');
Route::post('admin/screen/get-row', 'Admin\ScreenController@getRow')->name('admin.get.row.screen');

// Assembly
Route::post('admin/assembly', 'Admin\AssemblyController@insertAssembly')->name('admin.assembly');
Route::post('admin/findAssemblyStandard', 'Admin\AssemblyController@findJopOrderNumber')->name('admin.findAssemblyStandard');
Route::post('admin/assembly/get-row', 'Admin\AssemblyController@getRow')->name('admin.get.row.assembly');

// Armouring
Route::post('admin/armouring', 'Admin\ArmouringController@insertArmouring')->name('admin.armouring');
Route::post('admin/findArmouringStandard', 'Admin\ArmouringController@findJopOrderNumber')->name('admin.findArmouringStandard');
Route::post('admin/armouring/get-row', 'Admin\ArmouringController@getRow')->name('admin.get.row.armouring');

// Taps
Route::post('admin/taps', 'Admin\TapsController@insertTaps')->name('admin.taps');
Route::post('admin/findTapsStandard', 'Admin\TapsController@findJopOrderNumber')->name('admin.findTapsStandard');
Route::post('admin/taps/get-row', 'Admin\TapsController@getRow')->name('admin.get.row.taps');

// Lead
Route::post('admin/lead', 'Admin\LeadController@insertLead')->name('admin.lead');
Route::post('admin/findLeadStandard', 'Admin\LeadController@findJopOrderNumber')->name('admin.findLeadStandard');
Route::post('admin/lead/get-row', 'Admin\LeadController@getRow')->name('admin.get.row.lead');

// CCVInsulation
Route::post('admin/CCVInsulation', 'Admin\CCVInsulationController@insertCCVInsulation')->name('admin.CCVInsulation');
Route::post('admin/findCCVInsulationStandard', 'Admin\CCVInsulationController@findJopOrderNumber')->name('admin.findCCVInsulationStandard');
Route::post('admin/CCVInsulation/get-row', 'Admin\CCVInsulationController@getRow')->name('admin.get.row.CCVInsulation');

// Finish
Route::post('admin/finish', 'Admin\FinishController@insertFinish')->name('admin.finish');

// Hold
Route::post('admin/hold', 'Admin\HoldController@insertHold')->name('admin.hold');

// Rewind
Route::post('admin/rewind', 'Admin\RewindController@insertRewind')->name('admin.rewind');




/* Show Employees */
Route::get('/admin/showEmployee', 'Admin\ShowEmployeeController@showEmployee')->name('admin.show.employee');
Route::post('/admin/showEmployee/getEmployees', 'Admin\ShowEmployeeController@getEmployees')->name('admin.getEmployees');
Route::post('/admin/showEmployee/changeEmployeeShift', 'Admin\ShowEmployeeController@changeEmployeeShift')->name('admin.changeEmployeeShift.employee');
Route::post('/admin/showEmployee/logoutEmployee', 'Admin\ShowEmployeeController@logoutEmployee')->name('admin.logoutEmployee.employee');
Route::post('/admin/showEmployee/editEmployee', 'Admin\ShowEmployeeController@editEmployee')->name('admin.editEmployee.employee');
Route::post('/admin/showEmployee/getDataOfEmployee', 'Admin\ShowEmployeeController@getDataOfEmployee')->name('admin.getDataOfEmployee.employee');
Route::post('/admin/showEmployee/deleteEmployee', 'Admin\ShowEmployeeController@deleteEmployee')->name('admin.deleteEmployee.employee');

/* Show Admins */
Route::get('/admin/showAdmin', 'Admin\ShowAdminController@showAdmin')->name('admin.show.admin');
Route::post('/admin/showAdmin/getAdmins', 'Admin\ShowAdminController@getAdmins')->name('admin.getAdmins');
Route::post('/admin/showAdmin/changeAdminShift', 'Admin\ShowAdminController@changeAdminShift')->name('admin.changeAdminShift.admin');
Route::post('/admin/showAdmin/logoutAdmin', 'Admin\ShowAdminController@logoutAdmin')->name('admin.logoutAdmin.admin');
Route::post('/admin/showAdmin/editAdmin', 'Admin\ShowAdminController@editAdmin')->name('admin.editAdmin.admin');
Route::post('/admin/showAdmin/getDataOfAdmin', 'Admin\ShowAdminController@getDataOfAdmin')->name('admin.getDataOfAdmin.admin');
Route::post('/admin/showAdmin/deleteAdmin', 'Admin\ShowAdminController@deleteAdmin')->name('admin.deleteAdmin.admin');



/*  Show Data Actual  */

// Show Data Of Drowing Actual
Route::get('/admin/showData/Drowing/Actual', 'Admin\ShowData\Actual\ShowDrowingActualController@showDataDrowing')->name('admin.show.actual.drowing');
Route::post('/admin/showData/Drowing/Actual', 'Admin\ShowData\Actual\ShowDrowingActualController@getDataDrowing')->name('drowing.get');
Route::post('/admin/showData/Drowing/Actual/getISO', 'Admin\ShowData\Actual\ShowDrowingActualController@getISO')->name('drowing.get.iso');
Route::post('/admin/showData/Drowing/Actual/ISO', 'Admin\ShowData\Actual\ShowDrowingActualController@ISO')->name('drowing.iso');
Route::post('/admin/showData/Drowing/Actual/getRow', 'Admin\ShowData\Actual\ShowDrowingActualController@getRowToEditDataDrowing')->name('drowing.get.row');
Route::post('/admin/showData/Drowing/Actual/editRow', 'Admin\ShowData\Actual\ShowDrowingActualController@editDataDrowing')->name('drowing.edit.row');
Route::post('/admin/showData/Drowing/Actual/deleteRow', 'Admin\ShowData\Actual\ShowDrowingActualController@deleteDataDrowing')->name('drowing.delete.row');


// Show Data Of Stranding Actual
Route::get('/admin/showData/Stranding/Actual', 'Admin\ShowData\Actual\ShowStrandingActualController@showDataStranding')->name('admin.show.actual.stranding');
Route::post('/admin/showData/Stranding/Actual', 'Admin\ShowData\Actual\ShowStrandingActualController@getDataStranding')->name('stranding.get');
Route::post('/admin/showData/Stranding/Actual/getISO', 'Admin\ShowData\Actual\ShowStrandingActualController@getISO')->name('stranding.get.iso');
Route::post('/admin/showData/Stranding/Actual/ISO', 'Admin\ShowData\Actual\ShowStrandingActualController@ISO')->name('stranding.iso');
Route::post('/admin/showData/Stranding/Actual/getRow', 'Admin\ShowData\Actual\ShowStrandingActualController@getRowToEditDataStranding')->name('stranding.get.row');
Route::post('/admin/showData/Stranding/Actual/editRow', 'Admin\ShowData\Actual\ShowStrandingActualController@editDataStranding')->name('stranding.edit.row');
Route::post('/admin/showData/Stranding/Actual/deleteRow', 'Admin\ShowData\Actual\ShowStrandingActualController@deleteDataStranding')->name('stranding.delete.row');


// Show Data Of Insulation Actual
Route::get('/admin/showData/Insulation/Actual', 'Admin\ShowData\Actual\ShowInsulationActualController@showDataInsulation')->name('admin.show.actual.insulation');
Route::post('/admin/showData/Insulation/Actual', 'Admin\ShowData\Actual\ShowInsulationActualController@getDataInsulation')->name('insulation.get');
Route::post('/admin/showData/Insulation/Actual/getISO', 'Admin\ShowData\Actual\ShowInsulationActualController@getISO')->name('insulation.get.iso');
Route::post('/admin/showData/Insulation/Actual/ISO', 'Admin\ShowData\Actual\ShowInsulationActualController@ISO')->name('insulation.iso');
Route::post('/admin/showData/Insulation/Actual/getRow', 'Admin\ShowData\Actual\ShowInsulationActualController@getRowToEditDataInsulation')->name('insulation.get.row');
Route::post('/admin/showData/Insulation/Actual/editRow', 'Admin\ShowData\Actual\ShowInsulationActualController@editDataInsulation')->name('insulation.edit.row');
Route::post('/admin/showData/Insulation/Actual/deleteRow', 'Admin\ShowData\Actual\ShowInsulationActualController@deleteDataInsulation')->name('insulation.delete.row');

// Show Data Of CCVInsulation Actual
Route::get('/admin/showData/CCVInsulation/Actual', 'Admin\ShowData\Actual\ShowCCVInsulationActualController@showDataCCVInsulation')->name('admin.show.actual.CCVInsulation');
Route::post('/admin/showData/CCVInsulation/Actual', 'Admin\ShowData\Actual\ShowCCVInsulationActualController@getDataCCVInsulation')->name('CCVInsulation.get');
Route::post('/admin/showData/CCVInsulation/Actual/getISO', 'Admin\ShowData\Actual\ShowCCVInsulationActualController@getISO')->name('CCVInsulation.get.iso');
Route::post('/admin/showData/CCVInsulation/Actual/ISO', 'Admin\ShowData\Actual\ShowCCVInsulationActualController@ISO')->name('CCVInsulation.iso');
Route::post('/admin/showData/CCVInsulation/Actual/getRow', 'Admin\ShowData\Actual\ShowCCVInsulationActualController@getRowToEditDataCCVInsulation')->name('CCVInsulation.get.row');
Route::post('/admin/showData/CCVInsulation/Actual/editRow', 'Admin\ShowData\Actual\ShowCCVInsulationActualController@editDataCCVInsulation')->name('CCVInsulation.edit.row');
Route::post('/admin/showData/CCVInsulation/Actual/deleteRow', 'Admin\ShowData\Actual\ShowCCVInsulationActualController@deleteDataCCVInsulation')->name('CCVInsulation.delete.row');

// Show Data Of Screen Actual
Route::get('/admin/showData/Screen/Actual', 'Admin\ShowData\Actual\ShowScreenActualController@showDataScreen')->name('admin.show.actual.screen');
Route::post('/admin/showData/Screen/Actual', 'Admin\ShowData\Actual\ShowScreenActualController@getDataScreen')->name('screen.get');
Route::post('/admin/showData/Screen/Actual/getISO', 'Admin\ShowData\Actual\ShowScreenActualController@getISO')->name('screen.get.iso');
Route::post('/admin/showData/Screen/Actual/ISO', 'Admin\ShowData\Actual\ShowScreenActualController@ISO')->name('screen.iso');
Route::post('/admin/showData/Screen/Actual/getRow', 'Admin\ShowData\Actual\ShowScreenActualController@getRowToEditDataScreen')->name('screen.get.row');
Route::post('/admin/showData/Screen/Actual/editRow', 'Admin\ShowData\Actual\ShowScreenActualController@editDataScreen')->name('screen.edit.row');
Route::post('/admin/showData/Screen/Actual/deleteRow', 'Admin\ShowData\Actual\ShowScreenActualController@deleteDataScreen')->name('screen.delete.row');


// Show Data Of Assembly Actual
Route::get('/admin/showData/Assembly/Actual', 'Admin\ShowData\Actual\ShowAssemblyActualController@showDataAssembly')->name('admin.show.actual.assembly');
Route::post('/admin/showData/Assembly/Actual', 'Admin\ShowData\Actual\ShowAssemblyActualController@getDataAssembly')->name('assembly.get');
Route::post('/admin/showData/Assembly/Actual/getISO', 'Admin\ShowData\Actual\ShowAssemblyActualController@getISO')->name('assembly.get.iso');
Route::post('/admin/showData/Assembly/Actual/ISO', 'Admin\ShowData\Actual\ShowAssemblyActualController@ISO')->name('assembly.iso');
Route::post('/admin/showData/Assembly/Actual/getRow', 'Admin\ShowData\Actual\ShowAssemblyActualController@getRowToEditDataAssembly')->name('assembly.get.row');
Route::post('/admin/showData/Assembly/Actual/editRow', 'Admin\ShowData\Actual\ShowAssemblyActualController@editDataAssembly')->name('assembly.edit.row');
Route::post('/admin/showData/Assembly/Actual/deleteRow', 'Admin\ShowData\Actual\ShowAssemblyActualController@deleteDataAssembly')->name('assembly.delete.row');


// Show Data Of Bedding Actual
Route::get('/admin/showData/Bedding/Actual', 'Admin\ShowData\Actual\ShowBeddingActualController@showDataBedding')->name('admin.show.actual.bedding');
Route::post('/admin/showData/Bedding/Actual', 'Admin\ShowData\Actual\ShowBeddingActualController@getDataBedding')->name('bedding.get');
Route::post('/admin/showData/Bedding/Actual/getISO', 'Admin\ShowData\Actual\ShowBeddingActualController@getISO')->name('bedding.get.iso');
Route::post('/admin/showData/Bedding/Actual/ISO', 'Admin\ShowData\Actual\ShowBeddingActualController@ISO')->name('bedding.iso');
Route::post('/admin/showData/Bedding/Actual/getRow', 'Admin\ShowData\Actual\ShowBeddingActualController@getRowToEditDataBedding')->name('bedding.get.row');
Route::post('/admin/showData/Bedding/Actual/editRow', 'Admin\ShowData\Actual\ShowBeddingActualController@editDataBedding')->name('bedding.edit.row');
Route::post('/admin/showData/Bedding/Actual/deleteRow', 'Admin\ShowData\Actual\ShowBeddingActualController@deleteDataBedding')->name('bedding.delete.row');

// Show Data Of Armouring Actual
Route::get('/admin/showData/Armouring/Actual', 'Admin\ShowData\Actual\ShowArmouringActualController@showDataArmouring')->name('admin.show.actual.armouring');
Route::post('/admin/showData/Armouring/Actual', 'Admin\ShowData\Actual\ShowArmouringActualController@getDataArmouring')->name('armouring.get');
Route::post('/admin/showData/Armouring/Actual/getISO', 'Admin\ShowData\Actual\ShowArmouringActualController@getISO')->name('armouring.get.iso');
Route::post('/admin/showData/Armouring/Actual/ISO', 'Admin\ShowData\Actual\ShowArmouringActualController@ISO')->name('armouring.iso');
Route::post('/admin/showData/Armouring/Actual/getRow', 'Admin\ShowData\Actual\ShowArmouringActualController@getRowToEditDataArmouring')->name('armouring.get.row');
Route::post('/admin/showData/Armouring/Actual/editRow', 'Admin\ShowData\Actual\ShowArmouringActualController@editDataArmouring')->name('armouring.edit.row');
Route::post('/admin/showData/Armouring/Actual/deleteRow', 'Admin\ShowData\Actual\ShowArmouringActualController@deleteDataArmouring')->name('armouring.delete.row');

// Show Data Of Lead Actual
Route::get('/admin/showData/Lead/Actual', 'Admin\ShowData\Actual\ShowLeadActualController@showDataLead')->name('admin.show.actual.lead');
Route::post('/admin/showData/Lead/Actual', 'Admin\ShowData\Actual\ShowLeadActualController@getDataLead')->name('lead.get');
Route::post('/admin/showData/Lead/Actual/getISO', 'Admin\ShowData\Actual\ShowLeadActualController@getISO')->name('lead.get.iso');
Route::post('/admin/showData/Lead/Actual/ISO', 'Admin\ShowData\Actual\ShowLeadActualController@ISO')->name('lead.iso');
Route::post('/admin/showData/Lead/Actual/getRow', 'Admin\ShowData\Actual\ShowLeadActualController@getRowToEditDataLead')->name('lead.get.row');
Route::post('/admin/showData/Lead/Actual/editRow', 'Admin\ShowData\Actual\ShowLeadActualController@editDataLead')->name('lead.edit.row');
Route::post('/admin/showData/Lead/Actual/deleteRow', 'Admin\ShowData\Actual\ShowLeadActualController@deleteDataLead')->name('lead.delete.row');

// Show Data Of Taps Actual
Route::get('/admin/showData/Taps/Actual', 'Admin\ShowData\Actual\ShowTapsActualController@showDataTaps')->name('admin.show.actual.taps');
Route::post('/admin/showData/Taps/Actual', 'Admin\ShowData\Actual\ShowTapsActualController@getDataTaps')->name('taps.get');
Route::post('/admin/showData/Taps/Actual/getISO', 'Admin\ShowData\Actual\ShowTapsActualController@getISO')->name('taps.get.iso');
Route::post('/admin/showData/Taps/Actual/ISO', 'Admin\ShowData\Actual\ShowTapsActualController@ISO')->name('taps.iso');
Route::post('/admin/showData/Taps/Actual/getRow', 'Admin\ShowData\Actual\ShowTapsActualController@getRowToEditDataTaps')->name('taps.get.row');
Route::post('/admin/showData/Taps/Actual/editRow', 'Admin\ShowData\Actual\ShowTapsActualController@editDataTaps')->name('taps.edit.row');
Route::post('/admin/showData/Taps/Actual/deleteRow', 'Admin\ShowData\Actual\ShowTapsActualController@deleteDataTaps')->name('taps.delete.row');


// Show Data Of Sheathing Actual
Route::get('/admin/showData/Sheathing/Actual', 'Admin\ShowData\Actual\ShowSheathingActualController@showDataSheathing')->name('admin.show.actual.sheathing');
Route::post('/admin/showData/Sheathing/Actual', 'Admin\ShowData\Actual\ShowSheathingActualController@getDataSheathing')->name('sheathing.get');
Route::post('/admin/showData/Sheathing/Actual/getISO', 'Admin\ShowData\Actual\ShowSheathingActualController@getISO')->name('sheathing.get.iso');
Route::post('/admin/showData/Sheathing/Actual/ISO', 'Admin\ShowData\Actual\ShowSheathingActualController@ISO')->name('sheathing.iso');
Route::post('/admin/showData/Sheathing/Actual/getRow', 'Admin\ShowData\Actual\ShowSheathingActualController@getRowToEditDataSheathing')->name('sheathing.get.row');
Route::post('/admin/showData/Sheathing/Actual/editRow', 'Admin\ShowData\Actual\ShowSheathingActualController@editDataSheathing')->name('sheathing.edit.row');
Route::post('/admin/showData/Sheathing/Actual/deleteRow', 'Admin\ShowData\Actual\ShowSheathingActualController@deleteDataSheathing')->name('sheathing.delete.row');


/* Show Standard */

// Show Data Of Drowing Standard 
Route::get('/admin/showData/Drowing/Standard', 'Admin\ShowData\Standard\ShowDrowingStandardController@showStandardDrowing')->name('admin.show.standard.drowing');
Route::post('/admin/showData/Drowing/Standard', 'Admin\ShowData\Standard\ShowDrowingStandardController@getStandardDrowing')->name('drowing.standard.get');
Route::post('/admin/showData/Drowing/Standard/getRow', 'Admin\ShowData\Standard\ShowDrowingStandardController@getRowToEditStandardDrowing')->name('drowing.standard.get.row');
Route::post('/admin/showData/Drowing/Standard/editRow', 'Admin\ShowData\Standard\ShowDrowingStandardController@editStandardDrowing')->name('drowing.standard.edit.row');

// Show Data Of Stranding Standard
Route::get('/admin/showData/Stranding/Standard', 'Admin\ShowData\Standard\ShowStrandingStandardController@showStandardStranding')->name('admin.show.standard.stranding');
Route::post('/admin/showData/Stranding/Standard', 'Admin\ShowData\Standard\ShowStrandingStandardController@getStandardStranding')->name('stranding.standard.get');
Route::post('/admin/showData/Stranding/Standard/getRow', 'Admin\ShowData\Standard\ShowStrandingStandardController@getRowToEditStandardStranding')->name('stranding.standard.get.row');
Route::post('/admin/showData/Stranding/Standard/editRow', 'Admin\ShowData\Standard\ShowStrandingStandardController@editStandardStranding')->name('stranding.standard.edit.row');

// Show Data Of Insulation Standard
Route::get('/admin/showData/Insulation/Standard', 'Admin\ShowData\Standard\ShowInsulationStandardController@showStandardInsulation')->name('admin.show.standard.insulation');
Route::post('/admin/showData/Insulation/Standard', 'Admin\ShowData\Standard\ShowInsulationStandardController@getStandardInsulation')->name('insulation.standard.get');
Route::post('/admin/showData/Insulation/Standard/getRow', 'Admin\ShowData\Standard\ShowInsulationStandardController@getRowToEditStandardInsulation')->name('insulation.standard.get.row');
Route::post('/admin/showData/Insulation/Standard/editRow', 'Admin\ShowData\Standard\ShowInsulationStandardController@editStandardInsulation')->name('insulation.standard.edit.row');

// Show Data Of CCVInsulation Standard
Route::get('/admin/showData/CCVInsulation/Standard', 'Admin\ShowData\Standard\ShowCCVInsulationStandardController@showStandardCCVInsulation')->name('admin.show.standard.CCVInsulation');
Route::post('/admin/showData/CCVInsulation/Standard', 'Admin\ShowData\Standard\ShowCCVInsulationStandardController@getStandardCCVInsulation')->name('CCVInsulation.standard.get');
Route::post('/admin/showData/CCVInsulation/Standard/getRow', 'Admin\ShowData\Standard\ShowCCVInsulationStandardController@getRowToEditStandardCCVInsulation')->name('CCVInsulation.standard.get.row');
Route::post('/admin/showData/CCVInsulation/Standard/editRow', 'Admin\ShowData\Standard\ShowCCVInsulationStandardController@editStandardCCVInsulation')->name('CCVInsulation.standard.edit.row');

// Show Data Of Screen Standard
Route::get('/admin/showData/Screen/Standard', 'Admin\ShowData\Standard\ShowScreenStandardController@showStandardScreen')->name('admin.show.standard.screen');
Route::post('/admin/showData/Screen/Standard', 'Admin\ShowData\Standard\ShowScreenStandardController@getStandardScreen')->name('screen.standard.get');
Route::post('/admin/showData/Screen/Standard/getRow', 'Admin\ShowData\Standard\ShowScreenStandardController@getRowToEditStandardScreen')->name('screen.standard.get.row');
Route::post('/admin/showData/Screen/Standard/editRow', 'Admin\ShowData\Standard\ShowScreenStandardController@editStandardScreen')->name('screen.standard.edit.row');

// Show Data Of Assembly Standard
Route::get('/admin/showData/Assembly/Standard', 'Admin\ShowData\Standard\ShowAssemblyStandardController@showStandardAssembly')->name('admin.show.standard.assembly');
Route::post('/admin/showData/Assembly/Standard', 'Admin\ShowData\Standard\ShowAssemblyStandardController@getStandardAssembly')->name('assembly.standard.get');
Route::post('/admin/showData/Assembly/Standard/getRow', 'Admin\ShowData\Standard\ShowAssemblyStandardController@getRowToEditStandardAssembly')->name('assembly.standard.get.row');
Route::post('/admin/showData/Assembly/Standard/editRow', 'Admin\ShowData\Standard\ShowAssemblyStandardController@editStandardAssembly')->name('assembly.standard.edit.row');

// Show Data Of Bedding Standard
Route::get('/admin/showData/Bedding/Standard', 'Admin\ShowData\Standard\ShowBeddingStandardController@showStandardBedding')->name('admin.show.standard.bedding');
Route::post('/admin/showData/Bedding/Standard', 'Admin\ShowData\Standard\ShowBeddingStandardController@getStandardBedding')->name('bedding.standard.get');
Route::post('/admin/showData/Bedding/Standard/getRow', 'Admin\ShowData\Standard\ShowBeddingStandardController@getRowToEditStandardBedding')->name('bedding.standard.get.row');
Route::post('/admin/showData/Bedding/Standard/editRow', 'Admin\ShowData\Standard\ShowBeddingStandardController@editStandardBedding')->name('bedding.standard.edit.row');

// Show Data Of Armouring Standard
Route::get('/admin/showData/Armouring/Standard', 'Admin\ShowData\Standard\ShowArmouringStandardController@showStandardArmouring')->name('admin.show.standard.armouring');
Route::post('/admin/showData/Armouring/Standard', 'Admin\ShowData\Standard\ShowArmouringStandardController@getStandardArmouring')->name('armouring.standard.get');
Route::post('/admin/showData/Armouring/Standard/getRow', 'Admin\ShowData\Standard\ShowArmouringStandardController@getRowToEditStandardArmouring')->name('armouring.standard.get.row');
Route::post('/admin/showData/Armouring/Standard/editRow', 'Admin\ShowData\Standard\ShowArmouringStandardController@editStandardArmouring')->name('armouring.standard.edit.row');

// Show Data Of Lead Standard
Route::get('/admin/showData/Lead/Standard', 'Admin\ShowData\Standard\ShowLeadStandardController@showStandardLead')->name('admin.show.standard.lead');
Route::post('/admin/showData/Lead/Standard', 'Admin\ShowData\Standard\ShowLeadStandardController@getStandardLead')->name('lead.standard.get');
Route::post('/admin/showData/Lead/Standard/getRow', 'Admin\ShowData\Standard\ShowLeadStandardController@getRowToEditStandardLead')->name('lead.standard.get.row');
Route::post('/admin/showData/Lead/Standard/editRow', 'Admin\ShowData\Standard\ShowLeadStandardController@editStandardLead')->name('lead.standard.edit.row');

// Show Data Of Taps Standard
Route::get('/admin/showData/Taps/Standard', 'Admin\ShowData\Standard\ShowTapsStandardController@showStandardTaps')->name('admin.show.standard.taps');
Route::post('/admin/showData/Taps/Standard', 'Admin\ShowData\Standard\ShowTapsStandardController@getStandardTaps')->name('taps.standard.get');
Route::post('/admin/showData/Taps/Standard/getRow', 'Admin\ShowData\Standard\ShowTapsStandardController@getRowToEditStandardTaps')->name('taps.standard.get.row');
Route::post('/admin/showData/Taps/Standard/editRow', 'Admin\ShowData\Standard\ShowTapsStandardController@editStandardTaps')->name('taps.standard.edit.row');

// Show Data Of Sheathing Standard
Route::get('/admin/showData/Sheathing/Standard', 'Admin\ShowData\Standard\ShowSheathingStandardController@showStandardSheathing')->name('admin.show.standard.sheathing');
Route::post('/admin/showData/Sheathing/Standard', 'Admin\ShowData\Standard\ShowSheathingStandardController@getStandardSheathing')->name('sheathing.standard.get');
Route::post('/admin/showData/Sheathing/Standard/getRow', 'Admin\ShowData\Standard\ShowSheathingStandardController@getRowToEditStandardSheathing')->name('sheathing.standard.get.row');
Route::post('/admin/showData/Sheathing/Standard/editRow', 'Admin\ShowData\Standard\ShowSheathingStandardController@editStandardSheathing')->name('sheathing.standard.edit.row');

/* Reports */


// Show Data Of Finish
Route::get('/admin/reports/Finish', 'Admin\Reports\FinishReportController@FinishReport')->name('report.finish');
Route::post('/admin/reports/Finish', 'Admin\Reports\FinishReportController@getDataFinish')->name('finish.get');
Route::post('/admin/reports/Finish/getRow', 'Admin\Reports\FinishReportController@getRowToEditDataFinish')->name('finish.get.row');
Route::post('/admin/reports/Finish/editRow', 'Admin\Reports\FinishReportController@editDataFinish')->name('finish.edit.row');
Route::post('/admin/reports/Finish/deleteRow', 'Admin\Reports\FinishReportController@deleteDataFinish')->name('finish.delete.row');
Route::post('/admin/reports/Finish/printData', 'Admin\Reports\FinishReportController@printData')->name('finish.print.data');

// Show Data Of Hold
Route::get('/admin/reports/Hold', 'Admin\Reports\HoldReportController@HoldReport')->name('report.hold');
Route::post('/admin/reports/Hold', 'Admin\Reports\HoldReportController@getDataHold')->name('hold.get');
Route::post('/admin/reports/Hold/getRow', 'Admin\Reports\HoldReportController@getRowToEditDataHold')->name('hold.get.row');
Route::post('/admin/reports/Hold/editRow', 'Admin\Reports\HoldReportController@editDataHold')->name('hold.edit.row');
Route::post('/admin/reports/Hold/deleteRow', 'Admin\Reports\HoldReportController@deleteDataHold')->name('hold.delete.row');
Route::post('/admin/reports/Hold/printData', 'Admin\Reports\HoldReportController@printData')->name('Hold.print.data');
Route::post('/admin/reports/Hold/releaseHold', 'Admin\Reports\HoldReportController@releaseHold')->name('hold.release');
Route::post('/admin/reports/Hold/getReleasedHold', 'Admin\Reports\HoldReportController@getReleasedHold')->name('hold.get.release');

// Show Data Of Rewind
Route::get('/admin/reports/Rewind', 'Admin\Reports\RewindReportController@RewindReport')->name('report.rewind');
Route::post('/admin/reports/Rewind', 'Admin\Reports\RewindReportController@getDataRewind')->name('rewind.get');
Route::post('/admin/reports/Rewind/getRow', 'Admin\Reports\RewindReportController@getRowToEditDataRewind')->name('rewind.get.row');
Route::post('/admin/reports/Rewind/editRow', 'Admin\Reports\RewindReportController@editDataRewind')->name('rewind.edit.row');
Route::post('/admin/reports/Rewind/deleteRow', 'Admin\Reports\RewindReportController@deleteDataRewind')->name('rewind.delete.row');
Route::post('/admin/reports/Rewind/printData', 'Admin\Reports\RewindReportController@printData')->name('Rewind.print.data');

// Extrusion_Report
Route::get('/admin/reports/Extrusion', 'Admin\Reports\ExtrusionReportController@index')->name('report.extrusion');
Route::post('/admin/reports/Extrusion', 'Admin\Reports\ExtrusionReportController@getDataExtrusion')->name('report.extrusion.get');
Route::post('/admin/reports/Extrusion/printData', 'Admin\Reports\ExtrusionReportController@printData')->name('report.extrusion.print');
Route::post('/admin/reports/Extrusion/remark', 'Admin\Reports\ExtrusionReportController@remark')->name('report.remark.extrusion');
Route::post('/admin/reports/Extrusion/getRemark', 'Admin\Reports\ExtrusionReportController@getRemark')->name('report.extrusion.get.remark');

// Stranding_Report
Route::get('/admin/reports/Stranding', 'Admin\Reports\StrandingReportController@StrandingReport')->name('report.stranding');
Route::post('/admin/reports/Stranding', 'Admin\Reports\StrandingReportController@getDataStranding')->name('report.stranding.get');
Route::post('/admin/reports/Stranding/printData', 'Admin\Reports\StrandingReportController@printData')->name('report.stranding.print');
Route::post('/admin/reports/Stranding/remark', 'Admin\Reports\StrandingReportController@remark')->name('report.remark.stranding');
Route::post('/admin/reports/Stranding/getRemark', 'Admin\Reports\StrandingReportController@getRemark')->name('report.stranding.get.remark');

// Watching_Employee
Route::get('/admin/WatchingEmployee/{id}', 'Admin\WatchingEmployeeControler@index')->name('watching.employee.index');
Route::post('/admin/WatchingEmployee/{id}/getData', 'Admin\WatchingEmployeeControler@getData')->name('watching.employee.get.data');
