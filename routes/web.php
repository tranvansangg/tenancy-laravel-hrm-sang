

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DegreeController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\EducationLevelController;
use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\Admin\EmployeeTypeController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Admin\JobApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ContactController as AdminContactController; 
use App\Http\Controllers\Manager\ManagerDashboardController;
use App\Http\Controllers\Employee\EmployeeDashboardController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Controllers\Admin\AllowanceController;
use App\Http\Controllers\Admin\DeductionController;
use App\Http\Controllers\Admin\BonusController;
use App\Http\Controllers\Admin\LeavesController as AdminLeavesController;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Admin\InsuranceRecordController;
use App\Http\Controllers\Employee\LeaveController;
use App\Http\Controllers\Manager\BusinessTripController;
use App\Http\Controllers\Employee\BusinessTripController as EmployeeBusinessTripController;
use App\Http\Controllers\Admin\BusinessTripController as AdminBusinessTripController;
use App\Http\Controllers\Employee\LeavesController as EmployeeLeaveController;
use App\Http\Controllers\Manager\LeavesController as ManagerLeavesController;
use App\Http\Controllers\Manager\OvertimeController as ManagerOvertimeController;
use App\Http\Controllers\Admin\OvertimeController as AdminOvertimeController;
use App\Http\Controllers\Employee\OvertimeController;
use App\Http\Controllers\Admin\HolidayController;
use App\Http\Controllers\Admin\HolidayRequestController as AdminHolidayRequestController;
use App\Http\Controllers\Employee\HolidayRequestController as EmployeeHolidayRequestController;
use App\Http\Controllers\Manager\HolidayRequestController as ManagerHolidayRequestController;
use App\Http\Controllers\Admin\AdminGroupController;
use App\Http\Controllers\Manager\ManagerGroupController;
use App\Http\Controllers\Employee\EmployeeGroupController;
use App\Http\Controllers\Employee\EmployeeGroupRequestController;
use App\Http\Controllers\Admin\AccountController as AdminAccountController;
use App\Http\Controllers\Manager\AccountController as ManagerAccountController;
use App\Http\Controllers\Employee\AccountController as EmployeeAccountController;
use App\Http\Controllers\Manager\ManagerInsuranceController;
use App\Http\Controllers\Employee\EmployeeInsuranceController;
use App\Http\Controllers\Manager\PayrollController as ManagerPayrollController;
use App\Http\Controllers\Employee\EmployeePayrollController;
use App\Http\Controllers\Admin\PayrollController as AdminPayrollController;

use App\Http\Controllers\Manager\ManagerEmployeesController;













/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('layouts.welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.forgot');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');








//admin
Route::prefix('admin')->name('admin.')->middleware(['is_admin'])->group(function () {

// ...
    Route::get('/admin/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');
    Route::resource('departments', DepartmentController::class);
    Route::resource('positions', PositionController::class);
    Route::resource('degrees', DegreeController::class);
    Route::resource('education_levels', EducationLevelController::class);
    Route::resource('specialties', SpecialtyController::class);
    Route::resource('employee_types', EmployeeTypeController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('users', UserController::class);
    Route::resource('jobs', AdminJobController::class);
    Route::resource('applications', JobApplicationController::class)->only(['index','show','destroy']);
    Route::resource('contacts', AdminContactController::class)->only(['index','destroy']);
    Route::get('contacts/{contact}/reply', [AdminContactController::class, 'reply'])->name('contacts.reply');
    Route::post('contacts/{contact}/send-reply', [AdminContactController::class, 'sendReply'])->name('contacts.sendReply');
    Route::delete('contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
    // Payroll routes
    Route::resource('allowances', AllowanceController::class);
    Route::resource('deductions', DeductionController::class);
    Route::resource('bonuses', BonusController::class);
    Route::resource('insurances_records', InsuranceRecordController::class);
    //holiday
    Route::resource('holidays', HolidayController::class);


  Route::get('leaves', [AdminLeavesController::class, 'index'])->name('leaves.index');

    // Duyệt/cập nhật đơn nghỉ phép
    Route::get('leaves/{id}/edit', [AdminLeavesController::class, 'edit'])->name('leaves.edit');
    Route::put('leaves/{id}', [AdminLeavesController::class, 'update'])->name('leaves.update');



   // routes/web.php

Route::prefix('business-trips')->middleware(['is_admin'])->group(function() {
    Route::get('business-trips', [AdminBusinessTripController::class, 'index'])->name('business_trips.index');
    Route::get('business-trips/{id}', [AdminBusinessTripController::class, 'show'])->name('business_trips.show');
    Route::get('business-trips/{id}/edit', [AdminBusinessTripController::class, 'edit'])->name('business_trips.edit');
    Route::put('business-trips/{id}', [AdminBusinessTripController::class, 'update'])->name('business_trips.update');
    
    // Duyệt / Từ chối
    Route::post('business-trips/{id}/approve', [AdminBusinessTripController::class, 'approve'])->name('business_trips.approve');
    Route::post('business-trips/{id}/reject', [AdminBusinessTripController::class, 'reject'])->name('business_trips.reject');

    Route::delete('business-trips/{id}', [AdminBusinessTripController::class, 'destroy'])->name('business_trips.destroy');
});
Route::prefix('admin')->group(function () {
   // Admin danh sách OT
Route::get('overtimes', [AdminOvertimeController::class, 'index'])->name('overtimes.index');

// Admin xem chi tiết OT
Route::get('overtimes/{id}', [AdminOvertimeController::class, 'show'])->name('overtimes.show');

// Admin xoa OT
Route::delete('overtimes/{id}', [AdminOvertimeController::class, 'destroy'])->name('overtimes.destroy');
Route::post('overtimes/create', [AdminOvertimeController::class, 'create'])->name('overtimes.approve');

// Admin duyệt hoặc từ chối OT
Route::post('overtimes/handle/{id}', [AdminOvertimeController::class, 'handle'])->name('overtimes.handle');

});
Route::prefix('admin')->group(function(){
    Route::get('/overtimes',[AdminOvertimeController::class,'index'])->name('overtimes.index');
    Route::post('/overtimes/approve/{id}',[AdminOvertimeController::class,'approve'])->name('overtimes.approve');
    Route::post('/overtimes/decline/{id}',[AdminOvertimeController::class,'decline'])->name('overtimes.decline');
});
 Route::get('holiday-requests', [AdminHolidayRequestController::class, 'index'])->name('holiday_requests.index');
    Route::post('holiday-requests/{holidayRequest}/approve', [AdminHolidayRequestController::class, 'approve'])->name('holiday_requests.approve');
    Route::post('holiday-requests/{holidayRequest}/reject', [AdminHolidayRequestController::class, 'reject'])->name('holiday_requests.reject');


    Route::get('groups',[AdminGroupController::class, 'indexGroups'])->name('groups.index');
    Route::get('groups/create',[AdminGroupController::class, 'createGroup'])->name('groups.create');
    Route::post('groups/store',[AdminGroupController::class, 'storeGroup'])->name('groups.store');
    Route::get('groups/{id}/edit-leader',[AdminGroupController::class, 'editLeader'])->name('groups.edit_leader');
    Route::put('groups/{id}/update-leader',[AdminGroupController::class, 'updateLeader'])->name('groups.update');
    Route::get('groups/toggle/{id}',[AdminGroupController::class, 'toggleGroupStatus'])->name('groups.toggle');


     Route::get('/account/edit', [AdminAccountController::class, 'edit'])->name('account.edit');
    Route::put('/account/update', [AdminAccountController::class, 'update'])->name('account.update');
    Route::get('/account/change-password', [AdminAccountController::class, 'changePasswordForm'])->name('account.changePassword');
    Route::post('/account/change-password', [AdminAccountController::class, 'changePassword'])->name('account.change-password');

        Route::get('payrolls', [AdminPayrollController::class, 'index'])->name('payrolls.index');

});








// Manager Dashboard
Route::group(['middleware' => ['isManager']], function() {
    Route::get('/manager/dashboard', [ManagerDashboardController::class, 'index'])->name('manager.dashboard');
Route::prefix('manager')->name('manager.')->group(function () {
    Route::get('business_trips/create', [BusinessTripController::class, 'create'])->name('business_trips.create');
    Route::post('business_trips', [BusinessTripController::class, 'store'])->name('business_trips.store');
    route::get('business_trips/{id}/edit', [BusinessTripController::class, 'edit'])->name('business_trips.edit');
    route::put('business_trips/{id}', [BusinessTripController::class, 'update'])->name('business_trips.update');
    route::get('business_trips', [BusinessTripController::class, 'index'])->name('business_trips.index');
    route::get('business_trips/{id}', [BusinessTripController::class, 'show'])->name('business_trips.show');
    route::delete('business_trips/{id}', [BusinessTripController::class, 'destroy'])->name('business_trips.destroy');

    //danh sách nhân viên trong phòng
        Route::get('/manager/employees', [ManagerEmployeesController::class, 'index'])->name('employees.index');

});
Route::prefix('manager')->name('manager.')->group(function(){

    
    // Danh sách đơn nhân viên trong phòng (trưởng phòng duyệt)
    Route::get('leaves', [ManagerLeavesController::class, 'index'])->name('leaves.index');

    // Danh sách đơn của chính trưởng phòng
    Route::get('leaves/my', [ManagerLeavesController::class, 'myLeaves'])->name('leaves.my_leaves');

    // Tạo đơn nghỉ phép
    Route::get('leaves/create', [ManagerLeavesController::class, 'create'])->name('leaves.create');
    Route::post('leaves', [ManagerLeavesController::class, 'store'])->name('leaves.store');

    // Sửa đơn chưa duyệt
    Route::get('leaves/{id}/edit', [ManagerLeavesController::class, 'edit'])->name('leaves.edit');
    Route::put('leaves/{id}', [ManagerLeavesController::class, 'update'])->name('leaves.update');

    // Xem chi tiết đơn nghỉ phép của trưởng phòng
    Route::get('leaves/{id}', [ManagerLeavesController::class, 'show'])->name('leaves.show');

    // Duyệt/Từ chối đơn nghỉ phép của nhân viên
    Route::post('leaves/{id}/approve', [ManagerLeavesController::class, 'approve'])->name('leaves.approve');
    
});
Route::prefix('manager')->name('manager.')->group(function () {
    
    Route::get('/overtimes',[ManagerOvertimeController::class,'index'])->name('overtimes.index');
   Route::get('/overtimes/create',[ManagerOvertimeController::class,'create'])->name('overtimes.create');
    Route::post('/overtimes/store',[ManagerOvertimeController::class,'store'])->name('overtimes.store');
    Route::post('/overtimes/accept-decline/{id}', [ManagerOvertimeController::class,'acceptDecline'])->name('overtimes.accept');
    Route::post('/overtimes/reject-decline/{id}', [ManagerOvertimeController::class,'rejectDecline'])->name('overtimes.reject');
});
Route::prefix('manager')->name('manager.')->group(function () {
    
  Route::get('holiday_requests', [ManagerHolidayRequestController::class, 'index'])->name('holiday_requests.index');
    Route::get('holiday_requests/create', [ManagerHolidayRequestController::class, 'create'])->name('holiday_requests.create');
    Route::post('holiday_requests', [ManagerHolidayRequestController::class, 'store'])->name('holiday_requests.store');
    Route::post('holiday_requests/{holidayRequest}/approve', [ManagerHolidayRequestController::class, 'approve'])->name('holiday_requests.approve');
    Route::post('holiday_requests/{holidayRequest}/reject', [ManagerHolidayRequestController::class, 'reject'])->name('holiday_requests.reject');
});
Route::prefix('manager')->name('manager.')->group(function () {
    Route::get('/account', [ManagerAccountController::class, 'index'])->name('account.index');
  Route::get('/account/edit', [ManagerAccountController::class, 'editt'])->name('account.edit');
    Route::post('/account/update', [ManagerAccountController::class, 'update'])->name('account.update');
    Route::get('/account/change-password', [ManagerAccountController::class, 'changePasswordForm'])->name('account.changePassword');
    Route::post('/account/change-password', [ManagerAccountController::class, 'changePassword'])->name('account.change-password');
});
Route::prefix('manager')->name('manager.')->group(function () {
    // Bảo hiểm của chính trưởng phòng
    Route::get('/my-insurance', [ManagerInsuranceController::class, 'myInsurance'])
        ->name('insurance.my');

    // Bảo hiểm của nhân viên trong phòng
    Route::get('/employees/{employee_id}/insurance', [ManagerInsuranceController::class, 'show'])
        ->name('insurance.show');
        Route::get('/employees/insurance', [ManagerInsuranceController::class, 'index'])
        ->name('insurance.index');


});

Route::prefix('manager')->group(function() {
    // Xem nhóm Trưởng phòng quản lý
    Route::get('/groups', [ManagerGroupController::class, 'myGroups'])->name('manager.groups.index');

    // Quản lý nhân viên trong nhóm
    Route::get('/groups/{group}/edit-employees', [ManagerGroupController::class, 'editEmployees'])->name('manager.groups.edit_employees');
    Route::put('/groups/{group}/update-employees', [ManagerGroupController::class, 'updateEmployees'])->name('manager.groups.update_employees');

    // Duyệt/từ chối rời nhóm
    Route::post('/groups/{group}/handle-exit/{employee}', [ManagerGroupController::class, 'handleExit'])->name('manager.groups.handle_exit');
});



// Middleware 'auth' và 'manager' giả sử đã có, đảm bảo chỉ trưởng phòng vào được
Route::prefix('manager')->name('manager.')->group(function () {

    // Xem bảng lương
    Route::get('payrolls', [ManagerPayrollController::class, 'indexx'])->name('payrolls.indexx');

    // Tính lương toàn công ty
    Route::get('payrolls/generate', [ManagerPayrollController::class, 'generatePayroll'])->name('payrolls.generate');

    // Tính lương từng nhân viên
    Route::get('payrolls/calculate-employee/{employeeId}', [ManagerPayrollController::class, 'calculatePayrollForEmployee'])->name('payrolls.calculate');

    // Xuất Excel
    Route::get('payrolls/export', [ManagerPayrollController::class, 'export'])->name('payrolls.export');

});
Route::prefix('manager')->name('manager.')->group(function () {
    
    Route::get('mypayrolls', [ManagerPayrollController::class, 'mypayroll'])->name('payrolls.mypayroll');

});


});











// Employee Dashboard
Route::prefix('employee')->name('employee.')->middleware(['isEmployee'])->group(function () {
    Route::get('/employee/dashboard', [EmployeeDashboardController::class, 'index'])->name('dashboard');
     // Danh sách đơn nghỉ phép
    Route::get('leaves', [EmployeeLeaveController::class, 'index'])->name('leaves.index');

    // Tạo đơn nghỉ phép
    Route::get('leaves/create', [EmployeeLeaveController::class, 'create'])->name('leaves.create');
    Route::post('leaves', [EmployeeLeaveController::class, 'store'])->name('leaves.store');
    Route::get('leaves/{id}', [EmployeeLeaveController::class, 'show'])->name('leaves.show');


    // Chỉnh sửa đơn nghỉ phép (chỉ đơn pending)
    Route::get('leaves/{id}/edit', [EmployeeLeaveController::class, 'edit'])->name('leaves.edit');
    Route::put('leaves/{id}', [EmployeeLeaveController::class, 'update'])->name('leaves.update');


    
      Route::get('/business-trips', action: [EmployeeBusinessTripController::class, 'index'])->name('business_trips.index');
    Route::get('/business-trips/{id}', [EmployeeBusinessTripController::class, 'show'])->name('business_trips.show');

    //OT
       Route::get('/overtimes', [OvertimeController::class,'index'])->name('overtimes.index');
    Route::post('/overtimes/{id}/decline', [OvertimeController::class,'decline'])->name('overtimes.decline');
       Route::resource('holiday-requests', EmployeeHolidayRequestController::class)
        ->names('holiday_requests')
        ->only(['index', 'create', 'store']);



        Route::get('qswdefrt/account/edit', action: [EmployeeAccountController::class, 'edit'])->name('account.edit');
    Route::post('/account/update', [EmployeeAccountController::class, 'update'])->name('account.update');
    Route::get('/account/change-password', [EmployeeAccountController::class, 'changePasswordForm'])->name('account.changePassword');
    Route::post('/account/change-password', [EmployeeAccountController::class, 'changePassword'])->name('account.change-password');
        //nhóm
       

  Route::get('/employee/groups', [EmployeeGroupController::class, 'myGroups'])->name('groups.index');

    // Xin rời nhóm
    Route::post('/employee/groups/{group}/request-exit', [EmployeeGroupController::class, 'requestExit'])->name('groups.request_exit');

    // Leader quản lý nhân viên
    Route::get('/employee/groups/{group}/edit-employees', [EmployeeGroupController::class, 'editEmployees'])->name('groups.edit_employees');
    Route::put('/employee/groups/{group}/update-employees', [EmployeeGroupController::class, 'updateEmployees'])->name('groups.update_employees');

    // Leader duyệt/từ chối rời nhóm
    Route::post('/employee/groups/{group}/handle-exit/{employee}', [EmployeeGroupController::class, 'handleExit'])->name('groups.handle_exit');
Route::get('/my-insurance', [EmployeeInsuranceController::class, 'index'])
        ->name('insurance.index');

           Route::get('/payrolls', [EmployeePayrollController::class, 'index'])
        ->name('payrolls.index');


});













// tuyển dụng
Route::get('/tuyendung', [JobController::class, 'index'])->name('jobs.index');
Route::get('/tuyendung/{job}/apply', [JobController::class, 'apply'])->name('jobs.apply');
Route::post('/tuyendung/{job}/submit', [JobController::class, 'submitApplication'])->name('jobs.submitApplication');
// liên hệ
Route::get('lienhe', [ContactController::class, 'showForm'])->name('contacts.form');
Route::post('lienhe', [ContactController::class, 'submit'])->name('contact.submit');


