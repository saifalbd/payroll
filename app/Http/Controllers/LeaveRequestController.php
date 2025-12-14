<?php

namespace App\Http\Controllers;

use App\Models\LeaveApplication;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
          $auth = authResource($request);
          $leaveApplications = LeaveApplication::query()->with('employee')->get();
        return Inertia::render('Admin/LeaveRequest/index',compact('auth','leaveApplications'));
    }


    public function adminIndex(Request $request){
       $auth = authResource($request);
          $leaveApplications = LeaveApplication::query()->with('employee')->get();
        return Inertia::render('Admin/LeaveRequest/index',compact('auth','leaveApplications'));  
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request){
       $auth = authResource($request);
        
        return Inertia::render('Admin/LeaveRequest/create',compact('auth'));  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
     $emp = $request->user('employee');



        $request->validate([
            'dates' => ['required', 'array'],
            'dates.*' => ['required', 'date'],
            'leaveType' => ['required', 'string'],
            'subject' => ['required', 'string'],
            'message' => ['required', 'string']
        ]);

        $emp_id = $emp->id;
        $dates = $request->dates;
        $type = $request->leaveType;
        $subject = $request->subject;
        $message = $request->message;
        $company_id = $emp->company_id;

        LeaveApplication::create(compact('emp_id', 'dates', 'type', 'subject', 'message', 'company_id'));
        
        return redirect()->intended(route('leaveApp.index'));
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
