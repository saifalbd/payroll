<?php

namespace App\Http\Controllers;

use App\Models\LedgerGroupWithAll;
use App\Models\Payhead;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class PayHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        $auth = authResource($request);
        $company_id = $auth['company_id'];
        $payheads = Payhead::query()->where('company_id',$company_id)->with('ledger')->get();

        return Inertia::render('Admin/PayHead/index', compact('auth', 'payheads'));
    }

    public function dropdowns($company_id){
        return Payhead::query()->where('company_id',$company_id)->get();
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $auth = authResource($request);
        return Inertia::render('Admin/PayHead/create', compact('auth'));
    }

       public static function normalizeLedgers($items)
    {
        $collection = $items->map(function ($item) {
            $ledgers = $item->ledgers->map(function ($item) {
                $value = $item->id;
                $text = $item->title;
                return compact('value', 'text');
            })->toArray();
            if (count($item->subGroups)) {
                $list = static::normalizeLedgers($item->subGroups);
                foreach ($list as $lg) {
                    array_push($ledgers, $lg);
                }
            }

            if (count($ledgers)) {
                return $ledgers;
            } else {
                return [];
            }
        })->collapse();
        return $collection;
    }

   public function ledgers(Request $request)
    {


        $request->validate(['type' => ['required', 'in:earning,dedcutions']]);
        $type = $request->type;
            $admin = $request->user('web');

            $company_id = $admin->company_id;

        if ($type == 'earning') {
            $items = LedgerGroupWithAll::query()
            ->where('company_id',$company_id)
            ->whereIn('group_code', [52, 53, 54])->get();
            return static::normalizeLedgers($items);
        } else {
            $items = LedgerGroupWithAll::query() ->where('company_id',$company_id)->whereIn('group_code', [22])->get();
            return static::normalizeLedgers($items);
        }
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $request->validate([

            'name' => ['required', 'string', Rule::unique('payroll_payheads', 'title')],
            'type' => ['required', 'string', 'in:earning,dedcutions'],
            'ledger' => ['required', 'numeric'],
        ]);

     $admin = $request->user('web');
    $company_id = $admin->company_id;
        $title = $request->name;
        $type = $request->type;
        $ledger_id = $request->ledger;

       $payhead =  Payhead::updateOrCreate(compact('company_id', 'title'), compact('type', 'ledger_id'));
       $payhead->load('ledger');
       return response()->json($payhead);
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
