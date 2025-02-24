<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpensesRequest;
use App\Models\Category;
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
        $cat = Category:: withCount('expenses')->withSum('expenses','amount')->paginate(5);
        return view('expenses.index',compact('cat'));
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
        $budget = MonthlyBudget::where('user_id', Auth::id())
            ->where('month', $currentMonth)
            ->first();
        // Perform the transaction
        DB::transaction(function () use ($request, $cat_id, $budget) {
            $validated = $request->validated();

            // Create the expense entry
            Expenses::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'category_id' => $cat_id,
                'user_id' => Auth::id(),
                'monthly_budget_id' => $budget->id, // Corrected this
                'amount' => $validated['amount'],
            ]);
        });


        // Redirect to the show route for the given category
        return redirect()->route('expenses.show', $cat_id);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $expensesCat= Expenses::where('category_id',$id)->get();
        return view('expenses.show',compact('expensesCat'));
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
