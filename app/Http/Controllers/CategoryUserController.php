<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryUserController extends Controller
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
        $category = Category::whereDoesntHave('users', function ($query)  {
            $query->where('user_id', Auth::user()->id)->where('month', Carbon::now()->month);
        })->get();
        return view('category_user.create',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'selectData' => 'required'
        ]);
       $user= Auth::user();
       foreach ($request->input('selectData') as $value) {
           $user->categories()->attach($value,[
               'month' => Carbon::now()->month,
               'year' => Carbon::now()->year
           ]);
       }
       return back();

    }
//    public function show(string $id){
//        $user = User::find(Auth::id());
//        $percentage = $user->categories()->withPivot('percentage')->where('month',Carbon::now()->month)->get();
//        return view('category_user.show',compact('percentage'));
//    }
    public function edit(string $id)
    {
        $user = Auth::user();
        $category= $user->categories()->where('category_id',$id)->withPivot('percentage')->first();
        $sumOfPercentage = $user->categories()->where('month',Carbon::now()->month)->withPivot('percentage')->sum('percentage');
        return view('category_user.edit',compact('category','sumOfPercentage'));
    }

    public function update(Request $request, string $id)
    {
        $user=Auth::user();
        $oldPercentage = $user->categories()->withPivot('percentage')->where('month',Carbon::now()->month)->first()->pivot->percentage;
        $newPercentage = $request->input('percentage');
        $sumOfPercentage = $user->categories()->where('month',Carbon::now()->month)->withPivot('percentage')->sum('percentage');
        $previewPercentage= $sumOfPercentage-$oldPercentage+$newPercentage;
        if($previewPercentage >100){
            return back()->with('error', 'The estimated percentage usage will be above 100%');
        }
        $user->categories()->syncWithoutDetaching([
            $id => ['percentage' => $newPercentage]
        ]);
        return back()->with('success', 'The The percentage has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        dd($id);
    }
}
