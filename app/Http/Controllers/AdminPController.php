<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryUser;
use App\Models\Expenses;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function adminDashBoard()
    {
        $categoryCount = Category::count();
        $userCount = User::count();
        $categoryUsage = Category::withSum('expenses', 'amount')->orderBy('expenses_sum_amount', 'desc')->first();
        $topCategoryUsage = Category::withSum('expenses', 'amount')->orderBy('expenses_sum_amount', 'desc')->limit(5)->get();
        return view('admin.dashboard', compact('categoryCount', 'userCount', 'categoryUsage', 'topCategoryUsage'));

    }

    public function displayALLusers(Request $request)
    {
        $keyword = $request->get('search_data');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        if($keyword){
            $users = User::where('first_name', 'LIKE', "%{$keyword}%")
                ->orWhere('last_name', 'LIKE', "%{$keyword}%")
                ->orWhere('email', 'LIKE', "%{$keyword}%")
                ->orWhere('username', 'LIKE', "%{$keyword}%")
                ->simplePaginate(10);

        }else if ($request->input('start_date') && $request->input('end_date')){
            $users = User::whereDate('created_at', '>=',$start_date )
                ->whereDate('created_at', '<=',$end_date)
                ->simplePaginate(10);
        }
        else{
            $users = User::with('roles')->simplePaginate(10);
        }
        return view('admin.users', compact('users'));
    }

    public function displayALLCategories(Request $request)
    {
        if($request->input('search_data')){
            $keywords = $request->input('search_data');
            $categories = Category::withCount([
                'users' => function ($query) {
                $query->distinct();
            }
            ])->where('name', 'LIKE', "%{$keywords}%")->get();
        }else if($request->input('start_date') && $request->input('end_date')){
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $categories = Category::withCount([
                'users' => function ($query) {
                    $query->distinct();
                }
            ])->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->withTrashed()->get();
        }else{
            $categories = Category::withCount([
                'users' => function ($query) {
                    $query->distinct();
                }
            ])->withTrashed()->get();
        }
        return view('admin.category', compact('categories'));
    }

    public function editAdminCategory($id){
        $categoryData= Category::findOrfail($id);
        return view('admin.editCategory', compact('categoryData'));
    }
    public function updateAdminCategory(Request $request, $id){
        $old_name =$request->input('old_cat');
        $new_name = $request->input('cat_name');
        $request->validate([
            'cat_name' => 'required|min:3|unique:categories,name,',
        ]);
        if($old_name == $new_name) {
            return redirect()->back();
        }else{
             Category::where('id', $id)->update([
                'name' => $new_name,
            ]);
             return redirect()->back()->with('success', 'Category Updated Successfully');
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function createCategory()
    {
        return view('admin.createCategory');
    }
    public function storeCategory(Request $request){
        $request->validate([
            'cat_name' => 'required|min:3|unique:categories,name',
        ]);
        Category::create([
            'name' => $request->input('cat_name'),
            'user_id' => Auth::id(),
        ]);
        return redirect()->route('admin.displayALLCategories');
    }

    public function displaypermission(Request $request)
    {
        $allPermissions = Permission::where('group', '!=', 'livewire')->get()->groupBy('group');
        return view('admin.permission', compact('allPermissions'));
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show(string $month, int $user_id)
    {
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        $currMonth = Carbon::parse($month)->format('n');
        $user = User::findOrFail($user_id);
        $forecast = $user->categories()->where('month', $currMonth)->withPivot('percentage')->get();
        return view('admin.showCat', compact('currMonth', 'user_id', 'month', 'forecast', 'months'));
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

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyPermission(string $id)
    {
        $permission = Permission::findOrfail($id);
        $permission->roles()->detach();
        return redirect()->back();

    }
    public function createPermission(string $id)
    {
        $role = Role::where('role_name', 'user')->first();
        $role->permissions()->attach($id);
        return redirect()->back();
    }
    public function deleteCategory(string $id){
        $fetch = Category::findOrFail($id);
        $fetch->delete();
        return back();
    }
    public function restoreCategory(string $id){
        $fetch = Category::withTrashed()->findorfail($id);
        $fetch->restore();
        return back();
    }
}
