<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpensesRequest;
use App\Models\Category;
use App\Models\CategoryUser;
use App\Models\Expenses;
use App\Models\MonthlyBudget;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cat = Category:: all();
        $expenses = Expenses::with('category')->where('user_id', Auth::id())->get();
        //willstore the array of each category total expenses
        $totalExpensesPerCat = [];
        $foodCount = [];
        foreach ($cat as $value) {
            $totalExpensesPerCat[$value->id] = $expenses->where('category_id', $value->id)->sum('amount')??0;
            $foodCount[$value->id] = $expenses->where('category_id', $value->id)->count()??0;
        }
//        dd($totalExpensesPerCat);
        return view('expenses.index',compact('cat','totalExpensesPerCat','foodCount'));
    }
    //displat the expenses of today
    public function today()
    {
        //fetch all category
        $cat = Category:: all();
        //recent time and month
        $date = Carbon::now()->format('j');
        $month = Carbon::now()->format('F');
        $expenses = Expenses::with('category')
            ->where('user_id', Auth::id())
            ->whereDate('created_at', Carbon::now()->toDateString())
            ->get();

        //willstore the array of each category total expenses
        $totalExpensesPerCat = [];
        $foodCount = [];
        foreach ($cat as $value) {
            $totalExpensesPerCat[$value->id] = $expenses->where('category_id', $value->id)->sum('amount')??0;
            $foodCount[$value->id] = $expenses->where('category_id', $value->id)->count()??0;
        }
        return view('expenses.today',compact('cat','date','month','totalExpensesPerCat','foodCount'));
    }
    public function yesterday()
    {
        //fetch all category
        $cat = Category:: all();
        //recent time and month
        $date = Carbon::yesterday()->format('j');
        $month = Carbon::yesterday()->format('F');
//        dd(Carbon::yesterday()->format('j'));
        $expenses = Expenses::with('category')->where('user_id', Auth::id())->whereDate('created_at', Carbon::yesterday()->toDateString())->get();
        //will store the array of each category total expenses
        $totalExpensesPerCat = [];
        $foodCount = [];
        foreach ($cat as $value) {
            $totalExpensesPerCat[$value->id] = $expenses->where('category_id', $value->id)->sum('amount')??0;
            $foodCount[$value->id] = $expenses->where('category_id', $value->id)->count()??0;
        }
        return view('expenses.yesterday',compact('cat','date','month','totalExpensesPerCat','foodCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $categoryId = $request->category_id;
        $category = Category::where('id',$categoryId)->first();

        return view('expenses.create',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpensesRequest $request)
    {
        $cat_id = $request->input('category_id'); // Get category ID from the request
        $currentMonth = Carbon::now()->month;
//        $budget= MonthlyBudget::where('user_id',Auth::user()->id)->where('month', $currentMonth)->first();
//        $budget = MonthlyBudget::where('user_id', Auth::id())
//            ->where('month', $currentMonth)
//            ->first();
        // Perform the transaction
        DB::transaction(function () use ($request, $cat_id) {
            $validated = $request->validated();

            // Create the expense entry
            Expenses::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'category_id' => $cat_id,
                'user_id' => Auth::id(),
//                'monthly_budget_id' => $budget->id, // Corrected this
                'amount' => $validated['amount'],
            ]);
        });
        return back()->with('success','Expense created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $expensesCat= Expenses::where('category_id',$id)->get();
        return view('expenses.show',compact('expensesCat'));
    }
    public function todayShow(string $id)
    {
        $expensesCat = Expenses::where('category_id', (int)$id)->whereDate('created_at',Carbon::now()->toDateString())->get();
        return view('expenses.todayShow', compact('expensesCat'));
    }
     public function yesterdayShow(string $id)
    {
        $expensesCat = Expenses::where('category_id', (int)$id)->whereDate('created_at',Carbon::yesterday()->toDateString())->get();
        return view('expenses.yesterdayShow', compact('expensesCat'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $expenses = Expenses::where('id',$id)->first();
        return view('expenses.edit',compact('expenses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpensesRequest $request, string $id)
    {
        $validate=$request->validated();
        $expenses = Expenses::where('id',$id)->first();
        $expenses->update([
            'title'=> $validate['title'],
            'description'=> $validate['description'],
            'amount'=> $validate['amount']
        ]);
        return redirect()->back()->with('success','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $expenses = Expenses::where('id',$id);
        $expenses->delete();
        return redirect()->back();
    }

}
