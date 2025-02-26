<?php

namespace App\Http\Controllers;

use App\Http\Requests\MonthlyBudgetRequest;
use App\Models\MonthlyBudget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MonthlyBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentMonth = Carbon::now()->month;
        $budget = MonthlyBudget::withSum('expenses','amount')->where('month', $currentMonth)->first();
        $remaining= $budget->limit - $budget->expenses_sum_amount;

        return view('monthlyBudget.index',compact('budget','remaining'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('monthlyBudget.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MonthlyBudgetRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();
            MonthlyBudget::create([
                   'month'=> $validated['month'],
                    'limit'=>$validated['amount'],
                    'user_id'=>Auth::user()->id,
                ]
            );
        });
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $budget = MonthlyBudget::where('user_id', $id)->get();

        return view('monthlyBudget.show', compact('budget'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $budget= MonthlyBudget::where('id', $id)->first();
        return view('monthlyBudget.edit',compact('budget'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MonthlyBudgetRequest $request, string $id)
    {
//        // Validate the request data
        DB::transaction(function () use ($request, $id) {
            $validate = $request->validated();
            $budget = MonthlyBudget::where('id', $id)->first();
            $current_month = $budget->month;
            $selected_month = $request->input('edit_month');
            if ($current_month == $selected_month) {
                $budget->update([
                    'limit' => $validate['amount'],
                    'month' => $current_month,
                ]);
            } else {
                $budget->update([
                    'month' => $validate['month'],
                    'limit' => $validate['amount'],
                ]);
            }

        });
            return redirect()->route('monthlyBudget.edit', $id)->with('success', 'Budget updated successfully');
        // Redirect with a success message
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $budget = MonthlyBudget::where('id', $id)->first();
        $budget->delete();
        return back();
    }


}
