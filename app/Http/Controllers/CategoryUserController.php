<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        $month= Carbon::now()->format('n');
        //collect the categories
        $categories = $request->input('categories', []);
        $percentages = $request->input('percentages', []);
        //total sum of the data
        $percentage = array_sum($percentages);
        //it will display the current precentage usage
        $sumOfPercentage = CategoryUser::where('user_id',Auth::id())->where('month',Carbon::now()->month)->sum('percentage');
//        dd($sumOfPercentage+$percentage);
        $percentage = array_sum($percentages);
        if(empty($categories)){
            return back()->with('catNull', 'No category selected!');
        } else if($percentage == 0){
            return back()->with('null', 'Please enter percentage');
        }else if( $sumOfPercentage + $percentage > 100){
            return back()->with('error', 'Percentage cannot be greater than 100%');
        }else {
            foreach ($percentages as $key => $value) {
                if ($value != null) {
                    //attaching on the pivot table
                    $user->categories()->attach($key, ['percentage' => $value, 'month' => $month]);
                }
            }
            return redirect()->route('category_user.show',Auth::user()->id);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find(Auth::id());
        $percentage = $user->categories()->withPivot('percentage')->where('month',Carbon::now()->month)->get();
        return view('category_user.show',compact('percentage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = CategoryUser::with('category')->where('user_id',Auth::id())->where('category_id',$id)->first();
        //it will display the current precentage usage
        $sumOfPercentage = CategoryUser::where('user_id', Auth::id())->where('month', \Illuminate\Support\Carbon::now()->month)->sum('percentage');
        $percentage = $category->percentage;

        return view('category_user.edit',compact('category','percentage','sumOfPercentage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user=Auth::user();
        $oldPercentage = CategoryUser::where('user_id',Auth::id())->where('category_id',$id)->first()->percentage;
        $newPercentage = $request->input('percentage');
        $sumOfPercentage = CategoryUser::where('user_id',Auth::id())->sum('percentage');

        $previewPercentage= $sumOfPercentage-$oldPercentage+$newPercentage;
         if($previewPercentage >100){
             return back()->with('error', 'The estimated percentage usage will be above 100%');
         }
        $user->categories()->syncWithoutDetaching([
            $id => ['percentage' => $newPercentage]
        ]);
        return back()->with('success', 'The percentage has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = CategoryUser::where('user_id',Auth::id())->where('category_id',$id);
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
