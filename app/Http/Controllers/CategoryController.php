<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\CategoryUser;
use App\Models\User;
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
        $categories = Category::with('user')->get();
//        $totalUserCategories=$categories->mapWithKeys(function($categories){
//            return [$categories->id=>CategoryUser::where('category_id',$categories->id)->distinct('user_id')->count()];
//        });
        $totalUserCategories = Category::leftJoin('category_user', 'categories.id', '=', 'category_user.category_id')
            ->leftJoin('users', 'category_user.user_id', '=', 'users.id')
            ->select('categories.id', 'categories.name', 'categories.user_id', DB::raw('COUNT(DISTINCT category_user.user_id) as users_count'))
            ->groupBy('categories.id', 'categories.name', 'categories.user_id')
            ->get();
        return view('category.index', compact('categories','totalUserCategories'));
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
                'name' => $validatedData['cat_name'] , // Ensure key exists
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
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
