<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    

    public function salarySheet(Request $request){

          $auth = authResource($request);

          $vouchers = Voucher::query()->with([
            'employee'=>fn($q)=>$q->with('department'),
            'items'=>fn($q)=>$q->with('payhead'),
          ])->get();
          $vouchers = $vouchers->map(function ($voucher) {
           
            $emp = $voucher->employee;
            $employeName = $emp->employee_name;
            $emp_id = $emp->employee_id;
            $departmentName = $emp->department->name;
            $designation = $emp->designation;
            $date = $voucher->date;
            $list = $voucher->items->map(function($item){
                $payheadName = $item->payhead->title;
                $type = $item->payhead->type;
                $amount = $item->amount;
                $payhead_id = $item->payhead->id;
                return compact('payheadName','type','amount','payhead_id');

            });
            return compact('date','employeName','departmentName','designation','emp_id','list');

          });

        return Inertia::render('Admin/Report/salarySheet',compact('auth','vouchers'));

    }
}
