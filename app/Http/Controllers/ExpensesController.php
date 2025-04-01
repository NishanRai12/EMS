<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpensesRequest;
use App\Models\Category;
use App\Models\CategoryUser;
use App\Models\Expenses;
use App\Models\MonthlyBudget;
use App\Models\User;
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

        $month = Carbon::now()->format('m');
        $categories = Category::with(['expenses' => function ($query) use($month) {
            $query->whereMonth('created_at', $month)->where('user_id',Auth::id());
        }])->get();

//        dd($categories);
        return view('expenses.index',compact('categories','month'));
    }
    //displat the expenses of today
    public function today()
    {
        $date = Carbon::today()->format('j');
        $month = Carbon::today()->format('F');
        $categories = Category::with([
            'expenses'=>function($query) {
                $query->whereDate('created_at', Carbon::now()->toDateString())->where('user_id',Auth::id());
            }
        ])->get();
        return view('expenses.today', compact('categories','date','month'));
    }
    public function yesterday()
    {
        //recent time and month
        $date = Carbon::yesterday()->format('j');
        $month = Carbon::yesterday()->format('F');

        $categories = Category::with([
            'expenses'=>function($query) {
             $query->whereDate('created_at', Carbon::yesterday()->toDateString())->where('user_id',Auth::id());
            }
        ])->get();
        return view('expenses.yesterday',compact('date','month','categories'));
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
        // Perform the transaction
        DB::transaction(function () use ($request, $cat_id) {
            $validated = $request->validated();

            // Create the expense entry
           $expenses= Expenses::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'category_id' => $cat_id,
                'user_id' => Auth::id(),
                'amount' => $validated['amount'],
            ]);
           $expenses->statements()->create([
               'amount' => $validated['amount']
           ]);
        });
        return back()->with('success','Expense created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $month = Carbon::now()->format('m');
        $expensesCat= Expenses::where('category_id',$id)->whereMonth('created_at',$month)->get();
        return view('expenses.show',compact('expensesCat'));
    }
    public function todayShow(string $id)
    {
        $expensesCat = Expenses::where('category_id', $id)->whereDate('created_at',Carbon::now()->toDateString())->get();
        return view('expenses.todayShow', compact('expensesCat'));
    }
     public function yesterdayShow(string $id)
    {
        $expensesCat = Expenses::where('category_id', $id)->whereDate('created_at',Carbon::yesterday()->toDateString())->get();
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
        DB::transaction(function () use ($request, $id) {
            $validate=$request->validated();
            $expenses = Expenses::where('id',$id)->first();
            $expenses->update([
                'title'=> $validate['title'],
                'description'=> $validate['description'],
                'amount'=> $validate['amount']
            ]);
        });
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
