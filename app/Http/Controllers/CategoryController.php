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
}
