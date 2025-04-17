<?php

namespace App\Http\Controllers;

use App\Http\Requests\MonthlyBudgetRequest;
use App\Models\CategoryUser;
use App\Models\Expenses;
use App\Models\Income;
use App\Models\MonthlyBudget;
use App\Models\Statement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use mysql_xdevapi\Collection;
use function Laravel\Prompts\select;

class MonthlyBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $findStatements = Statement::where('user_id', Auth::id())
            ->orderBy('statement_date', 'desc')
            ->limit(6)->get();
        $thisYear = Carbon::now()->format('Y');
        $totalExpenses = DB::table('expenses')
            ->select('expenses.user_id',
                DB::raw("
                    SUM(CASE WHEN DATE(expenses_date) = CURRENT_DATE()  AND YEAR(expenses_date) = YEAR(CURRENT_DATE())THEN amount ELSE NULL END) AS todayExpenses,
                    SUM(CASE WHEN DATE(expenses_date) = CURRENT_DATE - INTERVAL 1 DAY THEN amount ELSE 0 END) AS yesterdayExpenses,
                    SUM(CASE WHEN YEAR(expenses_date) = YEAR(CURRENT_DATE()) THEN amount ELSE 0 END) AS thisYearExpenses,
                    SUM(CASE WHEN MONTH(expenses_date)= MONTH(CURRENT_DATE()) AND YEAR(expenses_date) = YEAR(CURRENT_DATE()) THEN amount ELSE 0 END) AS monthExpenses,
                    COUNT(CASE WHEN DATE(expenses_date) = CURRENT_DATE() AND YEAR(expenses_date) = YEAR(CURRENT_DATE()) THEN id  END) AS todayExpensesCount,
                    COUNT(CASE WHEN DATE(expenses_date) = CURRENT_DATE() - INTERVAL 1 DAY AND YEAR(expenses_date) = YEAR(CURRENT_DATE()) THEN amount ELSE NULL END) AS yesterdayExpensesCount,
                     COUNT(CASE WHEN YEAR(expenses_date) = YEAR(CURRENT_DATE()) THEN amount ELSE NULL END) AS thisYearExpensesCount,
                    COUNT(CASE WHEN MONTH(expenses_date)= MONTH(CURRENT_DATE()) AND YEAR(expenses_date) = YEAR(CURRENT_DATE()) THEN amount ELSE NULL END) AS monthExpensesCount
                "))
            ->where('user_id',Auth::id())
            ->groupBy('expenses.user_id')->first();
        $getExpenses = Expenses::orderBy('expenses_date','DESC')->limit(9)->get();
       //sum of percentage user forecasted to spend
        $sumOfPercentage = $user->percentages()->where('month',Carbon::now()->month)->sum('percentage');
        $user_income = Income::where('user_id',Auth::user()->id)->whereMonth('income_date', Carbon::now()->format('n'))->sum('amount');
        $forecast = (($sumOfPercentage*$user_income)/100);
//        $remaining = $forecast-$totalExpenses->monthExpenses;
        return view('monthlyBudget.index',compact('totalExpenses','forecast','thisYear','getExpenses','findStatements'));
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
