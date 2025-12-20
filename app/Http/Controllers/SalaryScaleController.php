<?php

namespace App\Http\Controllers;

use App\Models\SalaryScale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class SalaryScaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $auth = authResource($request);
        $salaryScales = SalaryScale::query()->with(['items' => fn($q) => $q->with(['payhead', 'parcentOf'])])->get();
      
        return Inertia::render('Admin/SalaryScale/index', compact('auth', 'salaryScales'));
    }


    public function dropdowns($company_id)
    {
        $salaryScales = SalaryScale::query()->where('company_id', $company_id)
        ->with(['items' => fn($q) => $q->with(['payhead', 'parcentOf'])])->get();
        return response()->json($salaryScales);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $auth = authResource($request);
        return Inertia::render('Admin/SalaryScale/create', compact('auth'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $company_id = $request->company_id;
        $request->validate([
            'title' => ['required', 'string', Rule::unique('payroll_salary_scales', 'title')->where('company_id', $request->company_id)],
            'items' => ['required', 'array'],
            'items.*' => ['required', 'array'],
            'items.*.payhead_id' => ['required', 'numeric'],
            'items.*.calc_type' => ['required', 'string'],
            'items.*.value' => ['required', 'numeric'],
            'items.*.formula' => ['required', 'string'],
            'items.*.parcent_of_id' => ['nullable', 'numeric'],
            'items.*.basis' => ['nullable', 'string']
        ]);
        return DB::transaction(function () use ($request, $company_id) {
            $title = $request->title;
            $items = $request->items;
            $scale = SalaryScale::create(compact('title', 'company_id'));
            foreach ($items as $item) {
                $scale->items()->create($item);
            }
            return response()->json($scale);
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
