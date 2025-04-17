<?php

namespace App\Http\Controllers;

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
        $user_cat = Category::whereHas('users', function ($query) {
            $query->where('user_id', Auth::id())->where('year', Carbon::now()->year)->where('month', Carbon::now()->month);
        })->simplePaginate(3);

        return view('category.index', compact('fetch_adminCat', 'user_cat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    public function category()
    {
        $category = Category::simplePaginate(3);
        return view('category.category', compact('category'));
    }
//    public function saveCategeory (){}
//
//    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $validatedData = $request->validated();
        $fetch_adminID = User::whereHas('roles', function ($query) {
            $query->where('role_name', 'admin');
        })->pluck('id')->toArray();
        $findCat = Category::where('name', $validatedData['cat_name'])->first();
        if ($findCat) {
            //ckeck if the category is deleted or not
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
            });
            return back()->with('success', 'Category created successfully');
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

//soft delete
    public function destroy(string $id)
    {
//        dd($id);
//        $fetch = Category::where('id', $id)->first();
        $fetch = Category::findOrFail($id);
        $fetch->delete();
        return back();
    }

    //restore soft delete
    public function restore(string $id)
    {
        $fetch = Category::withTrashed()->findorfail($id);
        $fetch->restore();
        return back();
    }

    //force delete
    public function removeUse(string $id)
    {
        $categoryFetch = Category::withTrashed()->findOrFail($id);
        $categoryFetch->users()->detach(Auth::id());
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

    //validate and store the category and percentage in a session used for store a new and also for when the category is empty
    public function storeFormSession(EstimateRequest $request)
    {
        $categories = $request->input('categories', []);
        $percentages = $request->input('percentages', []);
        $percentage = array_sum($percentages);
        if (empty($categories)) {
            return back()->with('catNull', 'No category selected!');
        } else if ($percentage == 0) {
            return back()->with('null', 'Please enter percentage');
        } else if ($percentage > 100) {
            return back()->with('error', 'Percentage cannot be greater than 100%');
        } else {
            //at start of month
            //if the authentication is done
            if (Auth::user()) {
                $user = Auth::user();
                foreach ($percentages as $key => $value) {
                    if ($value != null) {
                        $check = $user->categories()
                            ->where('category_id', $key)
                            ->wherePivot('month', Carbon::now()->format('n'))
                            ->wherePivot('year', Carbon::now()->year)
                            ->exists();

                        Percentage::create([
                            'user_id' => Auth::id(),
                            'category_id' => $key,
                            'percentage' => $value,
                            'month' => Carbon::now()->format('n'),
                            'year' => Carbon::now()->year,
                        ]);
                        if (!$check) {
                            $user->categories()->attach($key, ['year' => Carbon::now()->year, 'month' => Carbon::now()->format('n')]);
                        }
                    }
                }
                return redirect()->route('percentage.show', Auth::user()->id);
            }
        }
    }

    //display the new form to add categories
    public function newForm()
    {
        $currentCategories = Category::all()->pluck('name')->toArray();
        return view('registration.newCat', compact('currentCategories'));
    }

//    display the form to select the categories with percentage
    public function showFormCat()
    {
        $category = Category::simplePaginate(3);
        return view('registration.categoryForm', compact('category'));
    }

    //create a session for a new category
    public function getDataCat(Request $request)
    {
        $newCategory = $request->input('newCategory');
        session(['newCategory' => $newCategory]);
        return redirect()->route('submit.finalSubmit');
    }
}

