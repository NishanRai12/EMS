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
     * Display a listing of the resource.
     */
//    public function index()
//    {
//        $months = [
//            'January', 'February', 'March', 'April', 'May', 'June',
//            'July', 'August', 'September', 'October', 'November', 'December'
//        ];
//        $category= Category::all();
//        $currentMonth = Carbon::now()->format('F');
//        $currentMon = Carbon::now()->format('n');
//        $income = Income::where('user_id', Auth::id())
//            ->where('month', $currentMon)
//            ->first();
//        //percentage of the forecast
//        $Forecastpercentage = CategoryUser::where('user_id', Auth::id())->where('month', $currentMon)->sum('percentage');
//        // actual expenses of month
//        $expenses = Expenses::where('user_id', Auth::id())->whereMonth('created_at', $currentMon)->sum('amount');
//        //expenses into a number
//        $forecastExpenses = ($Forecastpercentage * $income->amount)/100;
//        //average
//        $nextMonthExpenses=($expenses + $forecastExpenses)/2;
//        //fetching from the pivot table
//        $categoryUser =  CategoryUser::where('user_id', Auth::id())->where('month', $currentMon)->get();
//        //this is the prediction for expenses
//        $catPer=[];
//        $actualExpenses=[];
//        foreach ($categoryUser as $findPer) {
////            converting the percentage forecast into a numerical
//            $percentage[$findPer->category_id]=$findPer->percentage;
//            $catPer[$findPer->category_id]= ($findPer->percentage * $income->amount)/100 ??0;
//        }
//        //finding the expenses for each category in a number
//        foreach ($category as $cat) {
//            $actualExpenses [$cat->id]= Expenses::where('user_id', Auth::id())->whereMonth('created_at', $currentMon)->where('category_id',$cat->id)->sum('amount') ;
//        }
//        return view('forecast.index',compact('currentMonth','months','percentage','currentMon','income','category','forecastExpenses','nextMonthExpenses','catPer','actualExpenses',));
//    }

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
        //
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
        $catPer=[];
        $actualExpenses=[];
        $category= Category::all();
        $currentMonth = $id;
        $currentMon = Carbon::parse($id)->subMonth()->format('n');
        $income = Income::where('user_id', Auth::id())
            ->where('month', $currentMon)
            ->sum();
        if($income){
            $user_income = $income->amount;
        }else{
            $user_income = 0;
        }
        //percentage of the forecast
        $Forecastpercentage = CategoryUser::where('user_id', Auth::id())->where('month', $currentMon)->sum('percentage');
        // actual expenses of month
        $expenses = Expenses::where('user_id', Auth::id())->whereMonth('created_at', $currentMon)->sum('amount');
       if($Forecastpercentage){
        //expenses into a number
        $forecastExpenses = ($Forecastpercentage *$user_income)/100;
           //average
           $nextMonthExpenses=($expenses + $forecastExpenses)/2;
       }else{
           $forecastExpenses = 0;
           $nextMonthExpenses=0;
       }
        //fetching from the pivot table
//        $categoryUser = Category::whereHas('users', function ($query)use ($currentMon) {
//            $query->where('user_id', Auth::id())->where('month',$currentMon);
//        })->get();
        $categoryUser=CategoryUser::where('user_id', Auth::id())->where('month', $currentMon)->get();
       if($categoryUser){
        //this is the prediction for expenses
        foreach ($categoryUser as $findPer) {
//            converting the percentage forecast into a numerical
            $catPer[$findPer->category_id]= ($findPer->percentage * $income->amount)/100 ??0;
        }
        //finding the expenses for each category in a number
        foreach ($category as $cat) {
            $actualExpenses [$cat->id]= Expenses::where('user_id', Auth::id())->whereMonth('created_at', $currentMon)->where('category_id',$cat->id)->sum('amount') ;
        }
       }
        return view('forecast.monthlyForecast',compact('currentMonth','currentMon','income','months','category','user_income','forecastExpenses','nextMonthExpenses','catPer','actualExpenses',));
    }
    public function showExpenses(string $id)
    {
        $currentMonth = Carbon::now()->format('F');
        $currentMon =Carbon::parse($id)->format('n');
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        //getting income
        $income_amount = Income::where('user_id', Auth::id())
            ->where('month', $currentMon)
            ->sum('amount');
        if(!$income_amount){
            $income_amount = 0;
        }
        //percentage of the forecast
        $forecastpercentage = Percentage::where('user_id', Auth::id())->where('month', $currentMon)->where('year',Carbon::now()->year)->sum('percentage');
       if($forecastpercentage){
            $forecastExpenses = ($forecastpercentage *  $income_amount)/100;
        }else{
            $forecastExpenses = 0 ;
        }
        // actual expenses of month
        $expenses = Expenses::where('user_id', Auth::id())->whereMonth('created_at', $currentMon)->sum('amount');
        //fetching from the pivot table
        $categoryUser = Category::whereHas('users', function ($query) use ($currentMon) {
            $query->where('user_id', Auth::id())->where('month',$currentMon);
        })->orwhereHas('expenses', function ($query) use ($currentMon) {
            $query->whereMonth('created_at',$currentMon)
                ->whereYear('created_at',Carbon::now()->year);
        })->withSum(['percentages as category_percentage' => function ($subQuery) use ($currentMon) {
            $subQuery
                ->where('user_id',Auth::id())->where('month', $currentMon)
                ->where('year',Carbon::now()->year);
        }],'percentage')
            ->withSum(['expenses as expenses_sum' => function ($subQuery) use ($currentMon) {
                $subQuery->where('user_id',Auth::id())
                    ->whereMonth('created_at',$currentMon)
                    ->whereYear('created_at', Carbon::now()->year);
            }],'amount')->get();
        $expensesExpectation = [];
        foreach ($categoryUser as $findPer) {
            $percentage = $findPer->category_percentage ?? 0;
            $expensesExpectation [$findPer->id] = ($percentage * $income_amount) / 100;
        }

        //this is the prediction for expenses
        return view('forecast.index',compact('currentMonth','months','income_amount','currentMon','categoryUser','expenses','forecastExpenses','expensesExpectation'));
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
