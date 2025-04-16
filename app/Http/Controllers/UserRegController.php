<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomeRequest;
use App\Http\Requests\UserRequest;
use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRegController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category=Category::all();
        return view('userReg.create',compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('userReg.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
//        $validate = $request->validated();
//        $user=User::create([
//            'username' => $validate['username'],
//            'first_name' => $validate['first_name'],
//            'last_name' => $validate['last_name'],
//            'email' => $validate['email'],
//            'password' => Hash::make($validate['password']),
//        ]);
//        $role = Role::where('role_name', 'user')->first();
//        $user->roles()->attach($role->id);
//        dd("hi");

        return redirect()->route('userReg.formIncome');
    }
    public function incomeFormCreate(IncomeRequest $request){
//        dd('aabb');
        return view('userReg.income');
    }
    public function incomeFormStore(IncomeRequest $request){
        return view('userReg.income');
    }
//    public function incomeStore(IncomeRequest $request){
//        dd('hello');
//    }
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
