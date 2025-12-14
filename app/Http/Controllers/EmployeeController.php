<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $admin = $request->user('web');
        $auth = authResource($request);

        $company_id = $admin->company_id;
        $employees = Employee::query()->where('company_id', $company_id)->with('department')->get();
        return Inertia::render('Admin/Employee/index', compact('auth', 'employees'));
    }


    public function dropdowns($company_id)
    {
        $employees = Employee::query()->where('company_id', $company_id)->get();
        return response()->json($employees);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $auth = authResource($request);
        $departments = Department::query()->get();
        return Inertia::render('Admin/Employee/create', compact('auth', 'departments'));
    }


    public function imageUpload(UploadedFile $file)
    {
        $disk  = 'public';
        $timestamp = strtotime("now");
        $extension = $file->getClientOriginalExtension();
        $file_name = $timestamp . '.' . $extension;

        $path = Storage::disk($disk)->putFileAs('employees', $file, $file_name);
        return $path;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $admin = $request->user('web');
        $request->validate([
            "employee_id" => ['required', 'numeric', Rule::unique('payroll_employees', 'employee_id')],
            "employee_name" => ['required', 'string'],
            "designation" => ['nullable', 'string'],
            "department" => ['required', 'numeric'],
            "joining_date" => ['nullable', 'date'],
            "contact_no" => ['nullable', 'string'],
            "email" => ['required', 'string', Rule::unique('users', 'email')],
            "linkedin" => ['nullable', 'string'],
            "nid" => ['nullable', 'string'],
            "current_address" => ['nullable', 'string'],
            "permanent_address" => ['nullable', 'string'],
            "district" => ['nullable', 'string'],
            "police_station" => ['nullable', 'string'],
            "post_office" => ['nullable', 'string'],
            "village" => ['nullable', 'string'],
            "father" => ['nullable', 'string'],
            "mother" => ['nullable', 'string'],
            "avatar" => ['nullable', 'image'],
            'password' => ['required', 'string']
        ]);



        $data = $request->only(
            'employee_id',
            "employee_name",
            "designation",
            "joining_date",
            "contact_no",
            "email",
            "linkedin",
            "nid",
            "current_address",
            "permanent_address",
            "district",
            "police_station",
            "post_office",
            "village",
            "father",
            "mother"
        );


        $department_id = $request->department;

        $password = Hash::make($request->password);
        $company_id = $admin->company_id;

        $avatar = '';
        if ($request->hasFile('avatar')) {
            $avatar = $this->imageUpload($request->file('avatar'));
        }


        $data = array_merge($data, compact('company_id', 'avatar', 'password', 'department_id'));
        //  dd($data);

        $emp =  Employee::create($data);

        $emp->load(['department']);
        return response()->json($emp);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Employee $employee)
    {

        $auth = authResource($request);
        $employee->load('department');
        return Inertia::render('Admin/Employee/show', compact('auth', 'employee'));
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
