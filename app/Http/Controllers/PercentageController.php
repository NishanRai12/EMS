<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryUser;
use App\Models\Percentage;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PercentageController extends Controller
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
    //done
    public function create()
    {
        $category = Category::whereDoesntHave('percentages', function ($query)  {
            $query->where('user_id', Auth::user()->id)
                ->where('month', Carbon::now()->month)
            ->where('year', Carbon::now()->year);
        })->whereHas('users', function ($query)  {
            $query-> where('user_id',Auth::id())
                ->where('month', Carbon::now()->month)
                ->where('year', Carbon::now()->year);
        })->get();
        return view('percentage.create',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    //done
    public function store(Request $request)
    {
        $user = Auth::user();
        //collect the categories
        $categories = $request->input('categories', []);
        $percentages = $request->input('percentages', []);
        //it will display the current precentage usage
        $sumOfPercentage = Percentage::where('user_id', Auth::id())->where('month', Carbon::now()->month)->where('year',Carbon::now()->year)->sum('percentage');
        $percentage = array_sum($percentages);
        if (empty($categories)) {
            return back()->with('catNull', 'No category selected!');
        } else if ($percentage == 0) {
            return back()->with('null', 'Please enter percentage');
        } else if ($sumOfPercentage + $percentage > 100) {
            return back()->with('error', 'Percentage cannot be greater than 100%');
        } else {
            foreach ($percentages as $key => $value) {
                if ($value != null) {
                    //attaching on the pivot table
                    Percentage::create([
                        'user_id'    => $user->id,
                        'category_id'=> $key,
                        'percentage' => $value,
                        'month'      => Carbon::now()->format('n'),
                        'year'       => Carbon::now()->year,
                    ]);
                }
            }
            return redirect()->back();
        }
    }
    //done
    public function show(string $id){
        $user = User::find(Auth::id());
        $percentage = $user->percentages()->where('month',Carbon::now()->month)->where('year',Carbon::now()->year)->get();
        return view('percentage.show',compact('percentage'));
    }
//    done
    public function edit(string $id)
    {
        $user = Auth::user();
        $category= $user->percentages()->where('category_id',$id)->first();
        $sumOfPercentage = $user->percentages()->where('month',Carbon::now()->month)->where('year',Carbon::now()->year)->sum('percentage');
        return view('percentage.edit',compact('category','sumOfPercentage'));
    }

    public function update(Request $request, string $id)
    {
        $user=Auth::user();
        $oldPercentage = $user->percentages()->where('month',Carbon::now()->month)->where('year',Carbon::now()->year)->pluck('percentage')->first();
        $newPercentage = $request->input('percentage');
        $sumOfPercentage = $user->percentages()->where('month',Carbon::now()->month)->where('year',Carbon::now()->year)->sum('percentage');
        $previewPercentage= $sumOfPercentage-$oldPercentage+$newPercentage;
        if($previewPercentage >100){
            return back()->with('error', 'The estimated percentage usage will be above 100%');
        }
        $percentage = $user->percentages()->where('category_id', $id)->where('month', Carbon::now()->month)->where('year', Carbon::now()->year)->first();
        $percentage->update(['percentage' => $newPercentage]);
        return back()->with('success', 'The The percentage has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Percentage::where('user_id',Auth::id())->where('category_id',$id);
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
