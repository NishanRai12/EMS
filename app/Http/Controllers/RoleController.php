<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('users')->get();
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
    public function show($id)
    {
      $roleUser= Role::findOrFail($id);
      $getAllUser=$roleUser->users()->simplePaginate(5);
       return view('roles.show',compact('getAllUser','roleUser'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
    }
}
