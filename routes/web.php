<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\PayHeadController;
use App\Http\Controllers\SalaryScaleController;
use App\Http\Controllers\SalarySetupController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::get('/', [AuthController::class, 'loginPage'])->name('login');
Route::post('/', [AuthController::class, 'login'])->name('login.post');




Route::post('/employee-logout', [AuthController::class, 'logoutEmployee'])->middleware('auth:employee')->name('employeeLogout');
Route::post('/admin-logout', [AuthController::class, 'logoutAdmin'])->middleware('auth:web')->name('adminLogout');

Route::prefix('/admin')->name('admin.')
    ->middleware('auth:web')
    ->group(function () {
        Route::get('/', [HomeController::class, 'home'])->name('home');
        Route::resource("/employees", EmployeeController::class)->except('update')->names("employee");
        Route::post("/employees/{employee}", [EmployeeController::class,'update'])->name("employee.update");
        Route::get('/employee-dropdowns/{company_id}', [EmployeeController::class, 'dropdowns'])->name('employee.dropdowns');
        Route::resource("departments", DepartmentController::class)->names("department");
        Route::resource("/payheads", PayHeadController::class)->names("payhead");
        Route::get('/payhead-ledgers', [PayHeadController::class, 'ledgers'])->name('payhead.ledgers');
        Route::get('/payhead-dropdowns/{company_id}', [PayHeadController::class, 'dropdowns'])->name('payhead.dropdowns');
        Route::resource("/salary-scales", SalaryScaleController::class)->names("salaryScale");
        Route::get('/salary-scales-dropdowns/{company_id}',[SalaryScaleController::class,'dropdowns'])->name('salaryScale.dropdowns');
        Route::resource("/salary-setups", SalarySetupController::class)->names("salarySetup");
        Route::resource('/attendances', AttendanceController::class)->names('Attendance');
        Route::get('/all-attendances', [AttendanceController::class, 'allAttendance'])->name('attendance.all');
        Route::get('/all-attendance-type', [AttendanceController::class, 'allAttendanceType'])->name('attendance.type.all');
        Route::post('/update-in-out/{attendance_id}', [AttendanceController::class, 'updateInOut'])->name('attendance.updateInOut');
        Route::post('/update-attendance-type/{attendance_id}', [AttendanceController::class, 'updateAttendanceType'])->name('attendance.updateType');
        Route::get("/leave-applications", [LeaveRequestController::class, 'adminIndex'])->name("leaveApp");
    });


Route::prefix('/home')->middleware('auth:employee')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [HomeController::class, 'home'])->name('employee.home');
    Route::resource("/leave-applications", LeaveRequestController::class)->names("leaveApp");
});
