<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomeRequest;
use App\Models\Income;
use Carbon\Carbon;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('userReg.newIncome');
    }

    /**
     * Store a newly created resource in storage.
     */
//    public function store(Request $request)
//    {
//        $validatedData = $request->validate([
//
//        ])
//    }

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
    public function validate (IncomeRequest $request)
    {

            $month = Carbon::now()->format('n');
            $validatedData = $request->validated();
            session([
            'income_data' => [
            'amount'      => $validatedData['amount'],
            'month'       => $month
            ]
            ]);
        $user = Auth::user();
        $month = Carbon::now()->format('n');
        $does_exist=$user->Categories()->where('month', $month)->exists();
        if($does_exist){
            Income::create([
                'user_id'=>Auth::id(),
                'amount'      => $validatedData['amount'],
                'month'       => $month,
            ]);
            return redirect()->route('monthlyBudget.index');
        }else {
            return redirect()->route('category.newFormCat');
        }
    }

}
