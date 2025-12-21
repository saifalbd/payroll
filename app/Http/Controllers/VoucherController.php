<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payhead;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $auth = authResource($request);
        return Inertia::render('Admin/Voucher/index', compact('auth'));
    }


    public function findSalarySetup(Employee $employee){
        $setup = $employee->salarySetup;
        $name = $employee->employee_name;
         abort_if(!$setup,404,"Selary Setup Not found by employee: $name");
        $setup->load('items.payhead');
        return response()->json($setup);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
            $auth = authResource($request);

            $admin = $request->user('web');
        $company_id = $admin->company_id;

        $employees = Employee::query()->select('id','employee_name','avatar')->where('company_id',$company_id)->get();
        $payheads = Payhead::query()->where('company_id',$company_id)->get();
        
        

            
        return Inertia::render('Admin/Voucher/create', compact('auth','employees','payheads'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
