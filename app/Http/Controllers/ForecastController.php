<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryUser;
use App\Models\Expenses;
use App\Models\User;
use App\Models\Income;
use App\Models\Percentage;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ForecastController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        if (!in_array($id,$months)) {
            abort(404);
        }
        $catPer = [];
        $forecastCat = [];
        $currentMonth = $id;
        $currentMon = Carbon::parse($id)->subMonth()->format('n');
        $income = Income::where('user_id', Auth::id())
            ->whereMonth('income_date', $currentMon)
            ->sum('amount');
        if (!$income) {
            $income = 0;
        }
        $user = Auth::user();
        //percentage of the forecast
        $Forecastpercentage = Percentage::where('user_id', Auth::id())->where('month', $currentMon)->sum('percentage');
        // actual expenses of month
        $expenses = Expenses::where('user_id', Auth::id())->whereMonth('expenses_date', $currentMon)->sum('amount');
        if ($Forecastpercentage) {
            //expenses into a number
            $forecastExpenses = ($Forecastpercentage * $income) / 100;
            //average
            $nextMonthExpenses = ($expenses + $forecastExpenses) / 2;
        } else {
            $forecastExpenses = 0;
            $nextMonthExpenses = 0;
        }
        $categoryUser = Category::whereHas('users', function ($query) use ($currentMon) {
            $query->where('user_id', Auth::id())->where('month', $currentMon);
        })->orwhereHas('expenses', function ($query) use ($currentMon) {
            $query->whereMonth('created_at', $currentMon)
                ->whereYear('created_at', Carbon::now()->year);
        })->withSum(['percentages as category_percentage' => function ($subQuery) use ($currentMon) {
            $subQuery
                ->where('user_id', Auth::id())->where('month', $currentMon)
                ->where('year', Carbon::now()->year);
        }], 'percentage')
            ->withSum(['expenses as expenses_sum' => function ($subQuery) use ($currentMon) {
                $subQuery->where('user_id', Auth::id())
                    ->whereMonth('created_at', $currentMon)
                    ->whereYear('created_at', Carbon::now()->year);
            }], 'amount')->get();
        if ($categoryUser->isNotEmpty()) {
            foreach ($categoryUser as $cat) {
                $actualExpenses[$cat->id] = Expenses::where('user_id', Auth::id())
                    ->whereMonth('created_at', $currentMon)
                    ->where('category_id', $cat->id)
                    ->sum('amount');
                $expensesExpectationPercentage[$cat->id] = $cat->category_percentage ?? 0;
                $estimatedExpenses[$cat->id] = ($expensesExpectationPercentage[$cat->id] * $income ?? 0) / 100;

                $nextMonthEstimatedExpenses[$cat->id] = ($actualExpenses[$cat->id] + $estimatedExpenses[$cat->id]) / 2;
                $percentageConverted[$cat->id] = ($estimatedExpenses[$cat->id] / $income) * 100;
            }
        }
        return view('forecast.monthlyForecast', compact('currentMonth', 'currentMon', 'income', 'months', 'categoryUser', 'forecastCat', 'forecastExpenses', 'nextMonthExpenses', 'catPer', 'nextMonthEstimatedExpenses', 'percentageConverted'));
    }

    public function showExpenses(string $id)
    {
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        if (!in_array($id,$months)) {
            abort(404);
        }
        $currentMonth = Carbon::now()->format('F');
        $currentMon = Carbon::parse($id)->format('n');
        //getting income
        $income_amount = Income::where('user_id', Auth::id())
            ->whereMonth('income_date', $currentMon)
            ->sum('amount');
        if (!$income_amount) {
            $income_amount = 0;
        }
        //percentage of the forecast
        $forecastpercentage = Percentage::where('user_id', Auth::id())->where('month', $currentMon)->where('year', Carbon::now()->year)->sum('percentage');
        if ($forecastpercentage) {
            $forecastExpenses = ($forecastpercentage * $income_amount) / 100;
        } else {
            $forecastExpenses = 0;
        }
        // actual expenses of month
        $expenses = Expenses::where('user_id', Auth::id())->whereMonth('created_at', $currentMon)->sum('amount');
        //fetching from the pivot table
        $categoryUser = Category::whereHas('users', function ($query) use ($currentMon) {
            $query->where('user_id', Auth::id())->where('month', $currentMon);
        })->orwhereHas('expenses', function ($query) use ($currentMon) {
            $query->whereMonth('created_at', $currentMon)
                ->whereYear('created_at', Carbon::now()->year);
        })->withSum(['percentages as category_percentage' => function ($subQuery) use ($currentMon) {
            $subQuery
                ->where('user_id', Auth::id())->where('month', $currentMon)
                ->where('year', Carbon::now()->year);
        }], 'percentage')
            ->withSum(['expenses as expenses_sum' => function ($subQuery) use ($currentMon) {
                $subQuery->where('user_id', Auth::id())
                    ->whereMonth('created_at', $currentMon)
                    ->whereYear('created_at', Carbon::now()->year);
            }], 'amount')->get();
        $expensesExpectation = [];
        foreach ($categoryUser as $findPer) {
            $percentage = $findPer->category_percentage ?? 0;
            $expensesExpectation [$findPer->id] = ($percentage * $income_amount) / 100;
        }
        //this is the prediction for expenses
        return view('forecast.index', compact('currentMonth', 'months', 'income_amount', 'currentMon', 'categoryUser', 'expenses', 'forecastExpenses', 'expensesExpectation'));
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
    }
}
