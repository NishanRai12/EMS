<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\CategoryUser;
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
        $categories = Category::withCount([
            'users' => function ($query) {
            $query->distinct();
            }
        ])->withTrashed()->get();
        return view('category.index', compact('categories'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validatedData = $request->validated();
            Category::create([
                'name' => $validatedData['cat_name'] ,
                'user_id' => Auth::id()
            ]);
        });
        return back()->with('success', 'Category created successfully');

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
     * Show the display the cat plus percentage
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $category= $user->categories()->where('category_id',$id)->withPivot('percentage')->first();
        $sumOfPercentage = $user->categories()->where('month',Carbon::now()->month)->withPivot('percentage')->sum('percentage');
        return view('category_user.edit',compact('category','sumOfPercentage'));
    }

    /**
     * Update the pivot table percentage of category
     */
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
        $fetch = Category::where('id', $id)->first();
        $fetch->delete();
        return back();
    }
    public function restore(string $id)
    {
        $fetch = Category::withTrashed()->find($id);
        $fetch->restore();
        return back();
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
    //validate and store the category and percentage
    public function storeFormSession(Request $request)
    {
        $categories = $request->input('categories', []); // Selected category IDs
        $percentages = $request->input('percentages', []);
        $percentage = array_sum($percentages);
        if(empty($categories)){
            return back()->with('catNull', 'No category selected!');
        } else if($percentage == 0){
            return back()->with('null', 'Please enter percentage');
        }else if($percentage >100){
            return back()->with('error', 'Percentage cannot be greater than 100%');
        }else{
            session([
                    'categories' => $categories,
                    'percentages' => $percentages]
            );
            return redirect()->route('submit.finalSubmit');

        }
    }
    //display the new form to add categories
    public function newForm(){
        $currentCategories = Category::all()->pluck('name')->toArray();
        return view('userReg.newCat',compact('currentCategories'));
    }
    //display the form to select the categories with percentage
    public function showFormCat(){
        $category = Category::all();
        return view('userReg.category',compact('category'));
    }
    public function getDataCat(Request $request){
        $newCategory = $request->input('newCategory');
        session(['newCategory' => $newCategory]);
        return redirect()->route('category.showFormCat');
    }
}

