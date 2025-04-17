<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\EstimateRequest;
use App\Http\Requests\IncomeRequest;
use App\Http\Requests\PercentageRequest;
use App\Http\Requests\UserRequest;
use App\Models\Category;
use App\Models\Income;
use App\Models\Percentage;
use App\Models\Role;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category=Category::all();
        return view('registration.create',compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('registration.userForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $validate = $request->validated();
        $user=User::create([
            'username' => $validate['username'],
            'first_name' => $validate['first_name'],
            'last_name' => $validate['last_name'],
            'email' => $validate['email'],
            'password' => Hash::make($validate['password']),
        ]);
        $role = Role::where('role_name', 'user')->first();
        $user->roles()->attach($role->id);
        Auth::login($user);
        return redirect()->route('registration.IncomeRegistration');
    }
    public function showIncomeRegistration()
    {
        return view('registration.incomeForm');
    }
    public function storeIncomeRegistration(IncomeRequest $request){
        $month = Carbon::now()->format('n');
        $validatedData = $request->validated();
//        Income::create([
//            'amount'      => $validatedData['amount'],
//            'month'       => $month,
//            'user_id' => Auth::id()
//        ]);
        return redirect()->route('registration.categoryRegistration');
    }
    public function showCategoryRegistration()
    {
        $category = Category::where('user_id',1)->orwhere('user_id',Auth::id())->get();
        return view('registration.categoryForm',compact('category'));
    }
    public function storeCategoryRegistration(EstimateRequest $request){
        $categories = $request->input('categories', []);
        foreach ($categories as $categoryId) {
            $user= Auth::user();
            $user->categories()->attach($categoryId,['year'=> \Carbon\Carbon::now()->year,'month'=>Carbon::now()->format('n')]);
        }
        return redirect()->route('registration.percentageRegistration');
    }
    public function showPercentageRegistration()
    {
        $user=Auth::user();
        $fetchUserCat = $user->categories()->get();
        return view('registration.percentageForm',compact('fetchUserCat'));
    }
    public function storePercentageRegistration(PercentageRequest $request){

        $percentages = $request->input('percentage', []);
        foreach ($percentages as $key => $values) {
            Percentage::Create([
                'user_id' => Auth::id(),
                'category_id' => $key,
                'percentage' =>$values,
                'month'      => Carbon::now()->format('n'),
                'year'       => Carbon::now()->year,
            ]);
        }
        return redirect()->route('monthlyBudget.index');
    }

    public function storeNewCatRegistration(CategoryRequest $request){
        $validate=$request->validated();
        $adminRole = Role::with('users')->where('role_name', 'admin')->first();
        $admin_id =$adminRole->users->first()->id;
        $searchExistance = Category::where('name',$validate['cat_name'])->first();
        if($searchExistance){
            if($searchExistance->user_id == $admin_id || $searchExistance->user_id == Auth::id()){
                return redirect()->back()->withErrors(['cat_name'=>'Category Already Exist']);
            }else {
                $users = Auth::user();
                //check if the category is already on the pivot table or not
                $checkInpivot = $users->categories()->where('category_id', $searchExistance->id)
                    ->where('year', Carbon::now()->year)
                    ->where('month', Carbon::now()->format('n'))
                    ->first();
                if ($checkInpivot) {
                    return redirect()->back()->withErrors(['categories' => 'Category Already Selected']);
                } else {
                    $users->categories()->attach($searchExistance->id, [
                        'year' => \Carbon\Carbon::now()->year,
                        'month' => Carbon::now()->format('n')
                    ]);
                    return back()->with('success', 'Category Successfully Added will be displayed on next page');
                }
            }
        }else{
            Category::create([
                'name' => $validate['cat_name'],
                'user_id' => Auth::id(),
            ]);
            return redirect()->back();
        }
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
        //
    }
}
