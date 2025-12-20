<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $auth = authResource($request);
        $departments = Department::query()->get();

        return Inertia::render('Admin/Department/index', compact('auth', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $auth = authResource($request);
        return Inertia::render('Admin/Department/create', compact('auth'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $admin = $request->user('web');
        $company_id = $admin->company_id;
        $request->validate([
            'name' => ['required', 'required', Rule::unique("payroll_departments", 'name')->where('company_id', $company_id)]
        ]);

        $name = $request->name;


        $department = Department::create(compact('company_id', 'name'));

        return response()->json($department);
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
    public function update(Request $request, Department $department)
    {
        $admin = $request->user('web');
        $company_id = $admin->company_id;
        $request->validate([
            'name' => ['required', 'required', Rule::unique("payroll_departments", 'name')->where('company_id', $company_id)
                ->whereNot('id', $department->id)]
        ]);

        $name = $request->name;


        $department = $department->update(compact('name'));



        return response()->json($department);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        Gate::authorize('delete', $department);
        $department->delete();
    }
}
