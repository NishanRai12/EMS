<?php

namespace App\Http\Middleware;

use App\Models\Category;
use App\Models\Income;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DataExistance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currMonth = Carbon::now()->format('n');
        $category = DB::table("category_user")->where("user_id", Auth::user()->id)->exists();
        $income = Income::where('user_id', Auth::user()->id)->where('month', $currMonth)->exists();
//        dd($income);
        if(!$income){
            return to_route('income.create');
        }
        if (!$category) {
            return to_route('category.showFormCat');
        }
        else{
            return $next($request);
        }

    }
}
