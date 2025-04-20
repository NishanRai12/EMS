<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryPercentageRequest;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\EstimateRequest;
use App\Models\Category;
use App\Models\CategoryUser;
use App\Models\Percentage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fetch_admin = User::whereHas('roles', function ($query) {
            $query->where('role_name', 'admin');
        })->first();
        $fetch_adminCat = Category::where('user_id', $fetch_admin->id)
            ->whereDoesntHave('users', function ($query) {
                $query->where('user_id', Auth::id())->where('year', Carbon::now()->year)->where('month', Carbon::now()->month);
            })
            ->simplePaginate(3);
        $user_cat = Category::with(['percentages' => function ($query) {
            $query->where('user_id', Auth::id())
                ->where('year', Carbon::now()->year)
                ->where('month', Carbon::now()->month);
        }])->whereHas('users', function ($query) {
            $query->where('user_id', Auth::id())
                ->where('year', Carbon::now()->year)
                ->where('month', Carbon::now()->month);
        })->simplePaginate(3);
        return view('category.index', compact('fetch_adminCat', 'user_cat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $totalPercentageFormonth = Percentage::where('user_id',Auth::id())
            ->where('year', Carbon::now()->year)
            ->where('month', Carbon::now()->month)
            ->sum('percentage');
        return view('category.create', compact('totalPercentageFormonth'));
    }

    public function createCategoryPercentage(Request $request){

        $totalPercentageFormonth = Percentage::where('user_id',Auth::id())
            ->where('year', Carbon::now()->year)
            ->where('month', Carbon::now()->month)
            ->sum('percentage');
        $request->validate([
            'selectData' => 'required'
        ],[
            'selectData.required' => 'Please select at least one category.',
        ]);
        $selectedCategories = $request->input('selectData');
        $category = Category::whereIn('id', $selectedCategories)->get();
        if ($category->isEmpty()) {
            abort(404); // No categories found
        }
        return view('category.createCategoryPercentage',compact('category','totalPercentageFormonth'));
    }
    public function storeCategoryPercentage(CategoryPercentageRequest $request){

        $totalPercentageFormonth = Percentage::where('user_id',Auth::id())
            ->where('year', Carbon::now()->year)
            ->where('month', Carbon::now()->month)
            ->sum('percentage');
        $validated = $request->validated();
        $percentageCat = $validated['categoryPercentage'];
        $inputPercentage = array_sum($percentageCat);
        if($inputPercentage+$totalPercentageFormonth > 100){
            return redirect()->back()->withErrors([
                'cat_error' => 'Total Percentage is more than 100 percentage.',
            ]);
        }else {
            $user = Auth::user();
            foreach ($percentageCat as $key => $value) {
                Percentage::create([
                    'user_id' => $user->id,
                    'category_id' => $key,
                    'percentage' => $value,
                    'month' => Carbon::now()->format('n'),
                    'year' => Carbon::now()->year,
                ]);
                $user->categories()->attach($key, [
                    'month' => Carbon::now()->month,
                    'year' => Carbon::now()->year
                ]);
            }
            return redirect()->route('category.index');
        }
    }
    public function editCategoryPercentage(string $id){

        $editCat = Category::with(['percentages' => function ($query) {
            $query->where('user_id', Auth::id())
                ->where('year', Carbon::now()->year)
                ->where('month', Carbon::now()->month);
        }])->where('id', $id)->first();
        $totalPercentageFormonth = Percentage::where('user_id',Auth::id())
            ->where('year', Carbon::now()->year)
            ->where('month', Carbon::now()->month)
            ->sum('percentage');
        return view('category.editCategoryPercentage',compact('totalPercentageFormonth','editCat'));
    }
    public function storeModifiedCategoryPercentage(Request $request){
        $oldCat = $request->input('old_cat');
        //get total percentage of the user for this month
        $user = Auth::user();
        $totalPercentageFormonth = Percentage::where('user_id',Auth::id())
            ->where('year', Carbon::now()->year)
            ->where('month', Carbon::now()->month)
            ->sum('percentage');
        $request->validate([
            'category_name' => 'required','min:1',
            'category_percentage' =>  'required|numeric|min:0|max:100',
        ]);
        $category=Category::where('name', $request->category_name)->first();
        if($oldCat !=  $request->category_name){
            $usedCategory=Percentage::where('user_id',$user->id)->where('year', Carbon::now()->year)
                ->where('month', Carbon::now()->month)->where('category_id', $category->id)
                ->first();
            if ($usedCategory) {
                return redirect()->back()->withErrors([
                    'category_name' => 'Category already used for this month.',
                ]);
            }
        }else {

            $category_name = $request->input('category_name');
            $category_percentage = $request->input('category_percentage');
            //get old cat name
            $old_category_name = Category::where('name', $request->input('old_cat'))->first();
            //check if the category exist or not
            $inputCategoryCheck = Category::where('name', $category_name)->first();
            //check if the pwrecentage to input is greater than 100 or not
            if ($totalPercentageFormonth + $category_percentage > 100) {
                return redirect()->back()->withErrors([
                    'category_percentage' => 'Total Percentage is more than 100 percentage.',
                ]);
            } else {
                if ($inputCategoryCheck) {
                    //get previous category percentage
                    $pervCatPercentage = Percentage::where('user_id', Auth::id())
                        ->where('category_id', $old_category_name->id)
                        ->where('year', Carbon::now()->year)
                        ->where('month', Carbon::now()->month)
                        ->first();
                    //detach previous
                    Auth::user()->categories()
                        ->wherePivot('month', Carbon::now()->format('n'))
                        ->wherePivot('year', Carbon::now()->year)
                        ->detach($old_category_name->id);
                    //attach new user category
                    Auth::user()->categories()->attach($inputCategoryCheck->id, [
                        'month' => Carbon::now()->format('n'),
                        'year' => Carbon::now()->year
                    ]);
                    //create new percentage
                    Percentage::create([
                        'user_id' => Auth::id(),
                        'category_id' => $inputCategoryCheck->id,
                        'percentage' => $category_percentage,
                        'month' => Carbon::now()->format('n'),
                        'year' => Carbon::now()->year,
                    ]);
                    //remove prev category perentage
                    $pervCatPercentage->delete();
                    return redirect()->route('category.index');
                } else {
                    $newCategoryCreated = Category::create([
                        'name' => $category_name,
                        'user_id' => Auth::id()
                    ]);
                    //attach new categorty
                    Auth::user()->categories()->attach($newCategoryCreated->id, [
                        'month' => Carbon::now()->format('n'),
                        'year' => Carbon::now()->year
                    ]);
                    //create new percentage
                    Percentage::create([
                        'user_id' => Auth::id(),
                        'category_id' => $newCategoryCreated->id,
                        'percentage' => $category_percentage,
                        'month' => Carbon::now()->format('n'),
                        'year' => Carbon::now()->year,
                    ]);
                    return redirect()->route('category.index');
                }
            }
        }
    }
    public function deleteCategoryPercentage(string $id){
//        dd($id);
        $getPercentage = Percentage::where('user_id', Auth::id())
            ->where('category_id', $id)
            ->where('year', Carbon::now()->year)
            ->where('month', Carbon::now()->month)
            ->first();
        $getPercentage->delete();
        Auth::user()->categories()
            ->wherePivot('month', Carbon::now()->format('n'))
            ->wherePivot('year', Carbon::now()->year)
            ->detach( $id);

        return back();
    }
    public function category()
    {
        $category = Category::simplePaginate(3);
        return view('category.category', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        //total percentage of the user for this month
        $totalPercentageFormonth = Percentage::where('user_id',Auth::id())
            ->where('year', Carbon::now()->year)
            ->where('month', Carbon::now()->month)
            ->sum('percentage');
        $validatedData = $request->validated();
        $fetch_adminID = User::whereHas('roles', function ($query) {
            $query->where('role_name', 'admin');
        })->pluck('id')->toArray();
        $findCat = Category::where('name', $validatedData['cat_name'])->first();
        if( $totalPercentageFormonth + $validatedData['percentage'] > 100){
            return redirect()->back()->withErrors(['percentage' => 'Total Percentage is more than 100 percentage.']);
        }else {
            if ($findCat) {
                //check if the category is deleted or not
                if ($findCat->deleted_at == null) {
                    if (in_array($findCat->user_id, $fetch_adminID)) {
                        //check if the admin already created the category or jnot
                        return back()->withErrors(['cat_name' => 'Category already exists']);
                    } else {
                        $user = Auth::user();
                        //checking before entering in pivot table
                        $existingCategory = $user->categories()->where('category_id', $findCat->id)->exists();
                        //if the category is used for this month error is displayed
                        if ($existingCategory) {
                            return back()->withErrors(['cat_name' => 'Category already used']);
                        } else {
                            $user->categories()->attach($findCat->id, [
                                'year' => Carbon::now()->year,
                                'month' => Carbon::now()->month,
                            ]);
                            Percentage::create([
                                'user_id' => Auth::id(),
                                'category_id' =>$findCat->id,
                                'percentage' => $validatedData['percentage'],
                                'month' => Carbon::now()->format('n'),
                                'year' => Carbon::now()->year,
                            ]);
                            return back()->with('success', 'Category created successfully');
                        }
                    }
                } else {
                    return back()->withErrors(['cat_name' => 'This name is not allowed.Please choose a different one.']);
                }
            } else {
                DB::transaction(function () use ($request, $validatedData) {
                    $category = Category::create([
                        'name' => $validatedData['cat_name'],
                        'user_id' => Auth::id()
                    ]);
                    $category->users()->attach(Auth::id(), [
                        'category_id' => $category->id,
                        'year' => Carbon::now()->year,
                        'month' => Carbon::now()->month,
                    ]);
                    Percentage::create([
                        'user_id' => Auth::id(),
                        'category_id' =>$category->id,
                        'percentage' => $validatedData['percentage'],
                        'month' => Carbon::now()->format('n'),
                        'year' => Carbon::now()->year,
                    ]);
                });
                return back()->with('success', 'Category created successfully');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {

    }

    /**
     * Show the display the cat plus percentage
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $category = $user->categories()->where('category_id', $id)->withPivot('percentage')->first();
        $sumOfPercentage = $user->categories()->where('month', Carbon::now()->month)->withPivot('percentage')->sum('percentage');
        return view('category_user.edit', compact('category', 'sumOfPercentage'));
    }

    /**
     * Update the pivot table percentage of category
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        $oldPercentage = $user->categories()->withPivot('percentage')->where('month', Carbon::now()->month)->first()->pivot->percentage;
        $newPercentage = $request->input('percentage');
        $sumOfPercentage = $user->categories()->where('month', Carbon::now()->month)->withPivot('percentage')->sum('percentage');
        $previewPercentage = $sumOfPercentage - $oldPercentage + $newPercentage;
        if ($previewPercentage > 100) {
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


    //restore soft delete
    public function restore(string $id)
    {
    }

    public function validate(CategoryRequest $request)
    {
        // Validate the request
        $validatedData = $request->validated();
        $name = $validatedData['cat_name'];
        // Store selected categories in session
        session()->flash('selected_categories', request('categories', []));
        return back()->with('success', 'Category added successfully!')->with('name', $name);
    }
}

