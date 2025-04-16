<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomeRequest;
use App\Http\Requests\SortRequest;
use App\Models\Income;
use App\Models\User;
use App\Rules\DateValidation;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
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
        $incomes = Income::where('user_id', Auth::id())->get();
        return view('income.index', compact('incomes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('income.create');
    }
    public function FormCreate()
    {
        return view('userReg.newIncome');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(IncomeRequest $request)
    {

        $month = Carbon::now()->month;
        $validated = $request->validated();
        $total_income = Income::where('user_id', Auth::id())->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->sum('amount');
        $remaining= $total_income + $validated['amount'];
        DB::transaction(function () use ($request, $month, $validated, $remaining) {
            $income = Income::create([
                'amount' =>$validated['amount'],
                'month' =>$month,
                'user_id' =>Auth::id()
            ]);
            $income->statement()->create([
                'remaining_balance' => $remaining,
                'user_id' => Auth::id(),
                'amount' => $validated['amount']
            ]);
        });
        return back()->with('success','Income created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Auth::id() != $id, 403 );
        $user = User::find(Auth::id());
        $message ='';
        $timezone = new DateTime('now', new DateTimeZone('Asia/Kathmandu'));
        $hour = (int) $timezone->format('H');
        if ($hour >= 5 && $hour < 12) {
            $message = 'Good Morning !';
        } elseif ($hour >= 12 && $hour < 17) {
            $message = 'Good Afternoon !';
        } elseif ($hour >= 17 && $hour < 20) {
            $message = 'Good Evening !';
        } else {
            $message = 'Good Night !';
        }

        $incomes = Income::where('user_id', $id)->orderBy('created_at', 'desc')->simplePaginate(5);
        return view('income.show', compact('incomes','message','user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $income = Income::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('income.edit', compact('income'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
//        dd("hello");

      $validated=$request->validate([
            'date' => ['required', 'date', new DateValidation],
            'amount' => ['required', 'numeric', 'min:1'],
        ]);
        $income = Income::findOrfail($id);
        $update_income=$income->update([
            'amount' =>$validated['amount'],
            'created_at' =>$validated['date'],
            'month' => Carbon::now()->month
        ]);
        $income->statement->update([
            'amount' => $validated['amount'],
        ]);

        return back()->with('success','Income updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $income = Income::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $income->delete();
        return redirect()->route('income.show',Auth::id());
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
//        $user = Auth::user();
//        $month = Carbon::now()->format('n');
//        $does_exist=$user->Categories()->where('month', $month)->exists();
//        if($does_exist){
//            Income::create([
//                'user_id'=>Auth::id(),
//                'amount'      => $validatedData['amount'],
//                'month'       => $month,
//            ]);
//            return redirect()->route('monthlyBudget.index');
//        }else {
//            return redirect()->route('category.newFormCat');
            return redirect()->route('category.showFormCat');

    }

}
