<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class UserRegController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category=Category::all();
        return view('userReg.index',compact('category'));
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
    public function store(Request $request)
    {
        //
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
        //
    }

    public function validate(UserRequest $request){
        $validate = $request->validated();
        $username =$validate['username'];
        $email =$validate['email'];
        $password =$validate['password'];
        $firstName =$validate['first_name'];
        $lastName =$validate['last_name'];
        session([
            'user_data' => [
                'username' => $validate['username'],
                'email' => $validate['email'],
                'password' => $validate['password'],
                'first_name' => $validate['first_name'],
                'last_name' => $validate['last_name']
            ]
        ]);
        return redirect()->route('income.create');
    }

}
