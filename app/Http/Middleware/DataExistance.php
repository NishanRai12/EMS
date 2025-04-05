<?php

namespace App\Http\Middleware;

use App\Models\Category;
use App\Models\Income;
use App\Models\Percentage;
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
        $currYear = Carbon::now()->format('Y');
        $findPer = Percentage::where('user_id', Auth::id())->where('month', $currMonth)->where('year', $currYear)->exists();
        $income = Income::where('user_id', Auth::user()->id)->where('month', $currMonth)->exists();
        if(Auth::user()->role=="admin"){
            return $next($request);
        }else{
            if(!$income){
                return to_route('income.create');
            }
            if (!$findPer) {
                return to_route('category.showFormCat');
            }
            else{
                return $next($request);
            }
        }
    }
}
