<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpensesRequest;
use App\Http\Requests\SortRequest;
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
    public function index(Request $request)
    {
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $parsed_start_date = Carbon::parse($start_date)->startOfDay();
        $parsed_end_date = Carbon::parse($end_date)->endOfDay();
        $categories = Category::with(['expenses' => function ($query) use ($parsed_start_date, $parsed_end_date) {
            $query->whereBetween('created_at', [$parsed_start_date, $parsed_end_date]);
        }])->get();

        return view('expenses.index', compact('categories', 'start_date', 'end_date'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $store_date=$request->start_date;
        $categoryId = $request->category_id;
        $category = Category::where('id',$categoryId)->first();
        return view('expenses.create',compact('category', 'store_date'));
    }
    //store the expeses
    public function store(ExpensesRequest $request)
    {
        $validated = $request->validated();
        $cat_id = $request->input('category_id');
        DB::transaction(function () use ( $validated, $cat_id) {
            // Create the expense entry
            $expenses= Expenses::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'category_id' => $cat_id,
                'user_id' => Auth::id(),
                'amount' => $validated['amount'],
            ]);
            $expenses->created_at = $validated['date'];
            $expenses->save();
            $expenses->statements()->create([
                'amount' => $validated['amount']
            ]);
        });
        return back()->with('success','Expense created successfully');
    }
    function search(Request $request){
        $keyword = $request->get('search_data');
        $expensesCat = DB::table('expenses')
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->select('expenses.id','expenses.title',
                'expenses.description',
                'expenses.amount',
                'expenses.created_at',
                'categories.name as category_name',
                'expenses.user_id')
            ->where('expenses.user_id', Auth::id())
            ->where(function ($query) use ($keyword) {
                $query->where('expenses.title', 'LIKE', "%{$keyword}%")
                    ->orWhere('expenses.description', 'LIKE', "%{$keyword}%")
                    ->orWhere('categories.name', 'LIKE', "%{$keyword}%");
            })->get();
        return view('expenses.search',compact('expensesCat'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function sortExpenses(SortRequest $request)
    {
        $validated  = $request->validated();
        $start_date = $validated['start_date'];
        $end_date =$validated['end_date'];
        $parsed_start_date = Carbon::parse($start_date)->startOfDay();
        $parsed_end_date = Carbon::parse($end_date)->endOfDay();
        $categories = Category::with(['expenses' => function ($query) use ($parsed_start_date, $parsed_end_date) {
            $query->whereBetween('created_at', [$parsed_start_date, $parsed_end_date]);
        }])->get();

        return view('expenses.index', compact('categories', 'start_date', 'end_date'));

    }
    //display all expenses
    public function show(Request $request)
    {
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $parsed_start_date = Carbon::parse($start_date)->startOfDay();
        $parsed_end_date = Carbon::parse($end_date)->endOfDay();
        $expensesCat = Expenses::where('category_id', $request->get('category_id'))->whereBetween('created_at', [$parsed_start_date, $parsed_end_date])->get();
        return view('expenses.show', compact('expensesCat'));

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
