<?php

namespace App\Providers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeSalarySetup;
use App\Models\LeaveApplication;
use App\Models\Payhead;
use App\Policies\DepartmentPolicy;
use App\Policies\EmployeePolicy;
use App\Policies\EmployeeSalarySetupPolicy;
use App\Policies\LeaveApplicationPolicy;
use App\Policies\PayheadPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Department::class, DepartmentPolicy::class);
        Gate::policy(Employee::class, EmployeePolicy::class);
        Gate::policy(EmployeeSalarySetup::class, EmployeeSalarySetupPolicy::class);
        Gate::policy(LeaveApplication::class, LeaveApplicationPolicy::class);
        Gate::policy(Payhead::class, PayheadPolicy::class);
    }
}
