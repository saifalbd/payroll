<?php

namespace App\Http\Controllers;

use App\Models\EmployeeSalarySetup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SalarySetupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $auth = authResource($request);
        $salarySetups = EmployeeSalarySetup::query()->whereHas('employee')->with([
            'employee',
            'items' => fn($q) => $q->with(['payhead', 'parcentOf'])
        ])->get();

        return Inertia::render('Admin/SalarySetup/index', compact('auth', 'salarySetups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $auth = authResource($request);
        return Inertia::render('Admin/SalarySetup/create', compact('auth'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'eff_date' => ['required', 'date'],
            'employee' => ['required', 'numeric'],
            'items' => ['required', 'array'],
            'items.*' => ['required', 'array'],
            'items.*.payhead_id' => ['required', 'numeric'],
            'items.*.calc_type' => ['required', 'string'],
            'items.*.value' => ['required', 'numeric'],
            'items.*.formula' => ['required', 'string'],
            'items.*.parcent_of_id' => ['nullable', 'numeric'],
            'items.*.basis' => ['nullable', 'string']
        ]);

        return DB::transaction(function () use ($request) {
            $title = $request->title;
            $items = $request->items;
            $employee_id = $request->employee;
            $eff_date = $request->eff_date;
            $admin = $request->user('web');
            $company_id = $admin->company_id;
            $setup = EmployeeSalarySetup::create(compact('employee_id', 'eff_date', 'company_id'));
            foreach ($items as $item) {
                $setup->items()->create($item);
            }
            return redirect()->route('admin.salarySetup.index');
        });
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
    public function edit(Request $request, $id)
    {

        $salarySetup = EmployeeSalarySetup::findOrFail($id);
        $salarySetup->load([
            'employee',
            'items' => fn($q) => $q->with(['payhead', 'parcentOf'])
        ]);

        $auth = authResource($request);
        return Inertia::render('Admin/SalarySetup/create', compact('auth', 'salarySetup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $salarySetup = EmployeeSalarySetup::findOrFail($id);

        $request->validate([
            'eff_date' => ['required', 'date'],
            'employee' => ['required', 'numeric'],
            'items' => ['required', 'array'],
            'items.*' => ['required', 'array'],
            'items.*.payhead_id' => ['required', 'numeric'],
            'items.*.calc_type' => ['required', 'string'],
            'items.*.value' => ['required', 'numeric'],
            'items.*.formula' => ['required', 'string'],
            'items.*.parcent_of_id' => ['nullable', 'numeric'],
            'items.*.basis' => ['nullable', 'string']
        ]);

        return DB::transaction(function () use ($request, $salarySetup) {
            $title = $request->title;
            $items = $request->items;
            $employee_id = $request->employee;
            $eff_date = $request->eff_date;
            $admin = $request->user('web');
            $company_id = $admin->company_id;
            $salarySetup->items()->delete();
            $salarySetup->update(compact('employee_id', 'eff_date', 'company_id'));
            foreach ($items as $item) {
                $salarySetup->items()->create($item);
            }
           // return redirect()->route('admin.salarySetup.index');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
