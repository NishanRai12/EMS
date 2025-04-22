<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->get('search_data')){
            $keyword = $request->get('search_data');
            $roles = Role::with('users')->where('role_name','LIKE',"%{$keyword}%")->get();
        }else if($request->input('start_date') && $request->input('end_date')){
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $roles = Role::with('users')
                ->whereDate('created_at','>=',"{$start_date}")
                ->whereDate('created_at','<=',"{$end_date}")
                ->get();
        }
        else{
            $roles = Role::with('users')->get();
        }
        return view('roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validatedData = $request->validated();
           Role::create([
               'role_name' => $validatedData['role_name'],
               ]
           );
        });
        return back()->with('success', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $roleUser = Role::findOrFail($id);
        $keyword = $request->get('search_data');
        if($keyword){
            $getAllUser = User::whereHas('roles', function ($query) use ($id) {
                $query->where('id', $id);
            })->where(function ($query) use ($keyword) {
                    $query->where('first_name', 'LIKE', "%{$keyword}%")
                        ->orWhere('last_name', 'LIKE', "%{$keyword}%")
                        ->orWhere('email', 'LIKE', "%{$keyword}%")
                        ->orWhere('username', 'LIKE', "%{$keyword}%");
                })
                ->with('roles')
                ->simplePaginate(5);

        }else if($request->input('start_date') && $request->input('end_date')){
            dd('hello');
        }else {
            $getAllUser = User::whereHas('roles', function ($query) use ($id) {
                $query->where('id', $id);
            })->with('roles')->simplePaginate(5);;
        }
       return view('roles.show',compact('getAllUser','roleUser'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categoryData= Role::findOrfail($id);
        return view('roles.edit',compact('categoryData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $cat_data=Role::findOrfail($id);
        $old_name = $request->input('old_name');
        $new_name= $request->input('role_name');
        if($old_name == $new_name){
            return back();
        }else{
            $request->validate([
                'role_name'=>'required|unique:roles,role_name,min:3'
            ]);
          Role::where('role_name',$old_name)->update([
               'role_name'=>$new_name
           ]);
        }
        return redirect()->back()->with('success', 'Role updated successfully');
    }
    //admin dellete the category
    public function delete($id){
        Role::findorFail($id)->delete();
        return redirect()->route('role.index');
    }
    //admin detach the category from the user role
    public function removeRole($id){
        $role = Role::where('id',$id)->firstOrFail();
        $role->users()->detach();
        return redirect()->route('role.show',$id);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {

    }
}
