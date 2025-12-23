<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceInOut;
use App\Models\AttendanceType;
use App\Models\Employee;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $auth = authResource($request);
        return Inertia::render('Admin/Attendance/index', compact('auth'));
    }

    public function allAttendance(Request $request)
    {
        $from_date = $request->query('from_date');
        $to_date = $request->query('to_date');

        $auth = authResource($request);
        $company_id = $auth['company_id'];

        return Employee::where('company_id', $company_id)->with([
            'attendances'=> function ($query) use($from_date, $to_date) {
                $query->whereBetween('date',[date('Y-m-d', strtotime($from_date)),date('Y-m-d', strtotime($to_date))])
                ->select('id', 'date', 'employee_id', 'attendance_type', DB::raw("DAY(date) as day"));
            },
            'attendances.attendanceType',
            'attendances.inOuts'
        ])->get(['id', 'employee_name', 'employee_id']);
        
    }

    public function dailyAttendance(Request $request)
    {
        $date = $request->query('date');

        $auth = authResource($request);
        $company_id = $auth['company_id'];

        $employee = Employee::where('company_id', $company_id)->with([
            'attendances'=> function ($query) use($date) {
                $query->where('date', date('Y-m-d', strtotime($date)))
                ->select('id', 'date', 'employee_id', 'attendance_type', 'is_late');
            },
            'attendances.attendanceType',
            'attendances.inOuts'
        ])->get(['id', 'employee_name', 'employee_id']);

        return $employee->map(function($emp){
            $emp->attendance = $emp->attendances->first();
            unset($emp->attendances);
            return $emp;
        });
    }

    public function allAttendanceType(){
        return AttendanceType::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $auth = authResource($request);
        // return Inertia::render('Admin/SalarySetup/create', compact('auth'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'employee_id' => ['required'],
                'date'        => ['required', 'date'],
                'type'        => ['required'],
                'time_in'     => ['required_if:type,1'],
            ],
            [
                'time_in.required_if' => 'Time in is required',
            ]
        );

        $auth = authResource($request);
        $company_id = $auth['company_id'];
        $date = $request->date;

        $attendance = Attendance::where('company_id', $company_id)->where('employee_id', $request->employ_id)
        ->where('date',$request->date)->first();
        if($attendance){

        }
        else{
            $is_late = 0;

            if ($request->type == 1 && !empty($request->time_in)) {
                $attendanceIn = Carbon::parse($request->time_in);
                
                $setting = Setting::getModel($company_id, Setting::DAY_LIMIT);
                
                if (!empty($setting['start'])) {
                    $startTime = Carbon::parse($setting['start']);

                    if ($attendanceIn->gt($startTime)) {
                        $is_late = 1;
                    }
                }
            }

            $new_attendance = Attendance::create([
                'company_id'        =>$company_id,
                'employee_id'       =>$request->employee_id,
                'date'              =>$request->date,
                'attendance_type'   =>$request->type,
                'is_late'           =>$is_late
            ]);
            if($request->type == 1){
                AttendanceInOut::create([
                    'attendance_id' =>$new_attendance->id,
                    'time_in'       =>$request->time_in,
                    'time_out'      =>$request->time_out
                ]);
            }
        }

        $employee = Employee::where('company_id', $company_id)->where('id', $request->employee_id)->with([
            'attendances'=> function ($query) use($date) {
                $query->where('date', date('Y-m-d', strtotime($date)))
                ->select('id', 'date', 'employee_id', 'attendance_type');
            },
            'attendances.attendanceType',
            'attendances.inOuts'
        ])->first(['id', 'employee_name', 'employee_id']);

        $employee->attendance = $employee->attendances->first();
        unset($employee->attendances);
        return response(['employee'=>$employee], 200);
    }

    public function updateInOut(Request $request, $attendance_id){
        $attendance = Attendance::findOrFail($attendance_id);
        $attendance->attendance_type = 1;
        $attendance->save();

        $id = $request->id??null;
        $in_out = AttendanceInOut::updateOrCreate(
            [
                'id'=>$id,
                'attendance_id'=>$attendance_id
            ],
            [
                'time_in'    => $request->time_in,
                'time_out'   => $request->time_out
            ]
        );
        return response($in_out, 200);
    }

    public function updateAttendanceType(Request $request, $attendance_id){
        $attendance = Attendance::findOrFail($attendance_id);
        if($attendance->attendance_type == 1 && $request->type != 1){
            AttendanceInOut::where('attendance_id', $attendance_id)->delete();
        }
        $attendance->attendance_type = $request->type;
        $attendance->save();
        return response($attendance, 200);
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
