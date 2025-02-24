<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(10);
        return view('category.index', compact('categories'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
//        dd(auth()->user()); /
        DB::transaction(function () use ($request) {
            $validatedData = $request->validated();
//            dd($validatedData['cat_name']);
            Category::create([
                'name' => $validatedData['cat_name'] , // Ensure key exists
                'user_id' => $request->input('user_logged')
            ]);
        });
        return back();

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
//    public function validate(CategoryRequest $request){
//        $validatedData = $request->validated();
//        $name = $validatedData['cat_name'];
//
//        return back()->with(['name' =>  $name]);
//    }
    public function validate(CategoryRequest $request)
    {
        // Validate the request
        $validatedData = $request->validated();
        $name = $validatedData['cat_name'];

        // Store selected categories in session
        session()->flash('selected_categories', request('categories', []));
        return back()->with('success', 'Category added successfully!')->with('name', $name);
    }
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
            return back()->with('success', '1');
        }
    }
    public function newFormCat(Request $request){

    }
    public function newForm(){
        //store in array and check all the cat
        $categories = Category::all();
        $categoriesArray = $categories->toArray();
        return view('userReg.newCat',compact('categoriesArray'));
    }
public function showFormCat(Request $request){
        $category = Category::all();
        return view('userReg.category',compact('category'));
}
    public function getDataCat(Request $request){
        $newCategory = $request->input('newCategory');
        session(['newCategory' => $newCategory]);
        return back();
    }

}
