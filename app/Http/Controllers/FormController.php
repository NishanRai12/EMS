<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Income;
use App\Models\Percentage;
use App\Models\Role;
use App\Models\Statement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FormController extends Controller
{
    public function finalSubmit(){
        DB::transaction(function () {
            $incomeSum = Income::where('user_id', Auth::id())->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->sum('amount');
            $form1Data = session( 'user_data');
            $incomeData = session('income_data');
            $oldCatData = session('percentages');
            $newCatData = session('newCategory');
            //This is for the new registration of the user
            if($form1Data){
                $user=User::create([
                    'username' => $form1Data['username'],
                    'first_name' => $form1Data['first_name'],
                    'last_name' => $form1Data['last_name'],
                    'email' => $form1Data['email'],
                    'password' => Hash::make($form1Data['password']),
                ]);
                $role = Role::where('role_name', 'user')->first();
                $user->roles()->attach($role->id);
                $income=Income::create([
                    'amount' => $incomeData['amount'],
                    'month' => $incomeData['month'],
                    'user_id'=> $user->id,
                ]);
                $income ->statements()->create([
                    'user_id' => Auth::id(),
                    'remaining_balance' => $incomeSum + $incomeData['amount'],
                    'amount' => $incomeData['amount']
                ]);
                if($oldCatData){
                    foreach ($oldCatData as $key => $value){
                        if($value!=null){
                            //attaching on the pivot table
                            Percentage::create([
                                'user_id'    => $user->id,
                                'category_id'=> $key,
                                'percentage' => $value,
                                'month'      => Carbon::now()->format('n'),
                                'year'       => Carbon::now()->year,
                            ]);
                            $user->categories()->attach($key,['year'=>Carbon::now()->year,'month'=>Carbon::now()->format('n')]);
                        }
                    }
                }
                //if the new cat data exists
                if($newCatData){
                    $newCat=explode(',',$newCatData);
                    foreach( $newCat as $data){
                        Category::create([
                            'name' => $data,
                            'user_id' =>  $user->id,
                        ]);
                    }
                }
            }else{
                $month = Carbon::now()->format('n');
                //for the next month
                $user=Auth::user();
                $user_id=Auth::id();
                if($incomeData){
                    $income =  Income::create([
                        'amount' => $incomeData['amount'],
                        'month' => $incomeData['month'],
                        'user_id'=> $user_id
                    ]);
                    $income ->statements()->create([
                        'user_id' => Auth::id(),
                        'amount' => $incomeData['amount'],
                        'remaining_balance' => $incomeSum + $incomeData['amount']
                    ]);
                }
                if($oldCatData){
                    foreach ($oldCatData as $key => $value){
                        if($value!=null){
                            Percentage::create([
                                'user_id'    => $user->id,
                                'category_id'=> $key,
                                'percentage' => $value,
                                'month'      => Carbon::now()->format('n'),
                                'year'       => Carbon::now()->year,
                            ]);
                        }
                    }
                }
                if($newCatData){
                    $newCat=explode(',',$newCatData);
                    foreach( $newCat as $data){
                        Category::create([
                            'name' => $data,
                            'user_id' =>  $user->id,
                        ]);
                    }
                }
            }
        });
        return redirect()->route('user');
    }
}
