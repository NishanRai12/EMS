<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryUser;
use App\Models\Expenses;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoryCount = Category::count();
        $userCount = User::count();
        $categoryUsage = Category::withSum('expenses','amount')->orderBy('expenses_sum_amount','desc')->first();
        $topCategoryUsage = Category::withSum('expenses','amount')->orderBy('expenses_sum_amount','desc')->limit(5)->get();
        return view('admin.index', compact('categoryCount', 'userCount','categoryUsage','topCategoryUsage'));

    }

    public function users()
    {
        $users = User::whereHas('roles', function ($findUser) {
            $findUser->where('role_name', 'user');
        })->get();
        return view('admin.users', compact('users'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function permission(Request $request){
        $allPermissions = Permission::where('group','!=', 'livewire')->get()->groupBy('group');
        return view('admin.permission',compact('allPermissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $permissionID=$request->input('permission');
        $role = Role::where('role_name', 'user')->first();
        $role->permissions()->attach($permissionID);
        return redirect()->back();
    }

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
        $user= User::findOrFail($user_id);
        $forecast= $user->categories()->where('month',$currMonth)->withPivot('percentage')->get();
        return view('admin.showCat',compact('currMonth','user_id','month','forecast','months'));
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
    public function destroy(string $id)
    {
       $permission= Permission::findOrfail($id);
       $permission->roles()->detach();
       return redirect()->back();

    }
}
