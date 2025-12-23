<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Payhead;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function Symfony\Component\Clock\now;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $auth = authResource($request);
        $vouchers = Voucher::query()->with([
            'employee:id,employee_name,avatar',
            'items' => fn($q) => $q->with('payhead')
        ])->get();

        return Inertia::render('Admin/Voucher/index', compact('auth', 'vouchers'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $auth = authResource($request);

        $admin = $request->user('web');
        $company_id = $admin->company_id;

        $employees = Employee::query()->select('id', 'employee_name', 'avatar')
            ->with([
                'salarySetup' => fn($q) => $q->with(['items' => fn($q) => $q->with('payhead')])
            ])
            ->where('company_id', $company_id)->get();
        $payheads = Payhead::query()->where('company_id', $company_id)->get();
        return Inertia::render('Admin/Voucher/create', compact('auth', 'employees', 'payheads'));
    }

    public function absentCount(Request $request)
    {
        $request->validate([
            'month' => ['required', 'string', 'starts_with:20'],
            'employee_id' => ['required', 'numeric']
        ]);

        $month = $request->month;
        $employee_id = $request->employee_id;
        return Attendance::query()->where('employee_id', $employee_id)->where('attendance_type', 1)->where('date', "LIKE", "$month%")->count();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'items' => ['required', 'array'],
            'items.*' => ['required', 'array'],
            'items.*.employee_id' => ['required', 'numeric'],
            'items.*.total' => ['required', 'numeric'],
            'items.*.date' => ['required', 'date'],
            'items.*.items' => ['required', 'array'],
            'items.*.items.*' => ['required', 'array'],
            'items.*.items.*.amount' => ['required', 'numeric'],
            'items.*.items.*.payhead' => ['required', 'numeric'],
        ]);

        $items = $request->items;

        foreach ($items as $item) {
            $employee_id = $item['employee_id'];
            $amount = $item['total'];
            $date = $item['date'];
            $voucher = Voucher::create(compact('employee_id', 'amount', 'date'));

            foreach ($item['items'] as $o) {
                $amount = $o['amount'];
                $payhead_id = $o['payhead'];
                $voucher->items()->create(compact('amount', 'payhead_id'));
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Voucher $voucher)
    {

        $auth = authResource($request);
        $voucher->load([
            'employee.department',
            'items' => fn($q) => $q->with('payhead')
        ]);

   
        return Inertia::render('Admin/Voucher/paySlip', compact('auth', 'voucher'));
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
