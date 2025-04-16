<x-app-layout>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Navbar Example</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <style>
            .child_div_1 {
                display: flex;
                flex-direction: column;
                margin-top: 10px;
                margin-left: 2rem;
                margin-bottom: 5px;
                background-color: #ffffff;
                padding: 25px;
                border-radius: 8px;
                width: 67rem;
                /*height: 7rem;*/

            }
            .search_bar {
                display: flex;
                color: black;

            }
            .form-inline {
                display: flex;
                flex-direction: row;
                align-items: center;
                column-gap: 9px;
            }
            .input_search{
                width: 20rem;
            }

            .search_button {
                border: white 2px solid;
                color: white;
                padding: 10px 20px;
                font-size: 16px;
                border-radius: 5px;
            }
            .bottom_container{
                display: flex;
                flex-direction: row;
            }
            .button{
                font-size: 16px;
                margin-bottom: 10px;
                background: #3260a8;
                padding: 5px 15px;
                border-radius: 4px;
                text-align: center;
                color: white;
                text-decoration: none;
            }
            .header2  {
                font-size: 16px;
                font-weight: bold;
                color: #333;
                margin-top: 20px;
            }
        </style>
    </head>
    <div style="background-color: #3260a8 ; color: white" class="card p-4 shadow-sm">
        <div class="search_bar">
            <h5 style="color: white; margin-top: 8px" class="fw-bold">EXPENSES FOR {{$thisYear}}</h5>
            <div style="margin-left: 55rem">
                <form class="form-inline" action="{{route('expenses.search')}}" method="POST">
                    @csrf
                    <input  name= "search_data" class="input_search" type="search" placeholder="Search Expenses" aria-label="Search">
                    <button class="search_button" type="submit">Search</button>
                </form>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <div class="ms-4">
                <p><i class="fas fa-flag text-dark"></i> <strong>Base Goal</strong> <br> {{$forecast??0 }}</p>
                <p><i class="fas fa-wallet text-warning"></i> <strong>Expenses</strong> <br> {{$totalExpenses->thisYearExpenses??0}}</p>
                <p><i class="fas fa-bag-shopping text-primary"></i> <strong>Total</strong> <br> {{$totalExpenses->thisYearExpensesCount??0}}</p>
            </div>
        </div>
    </div>

    <div class ="bottom_container">
        <div class = "left_div_container">
            <div class="container mt-4 d-flex ">
                <div style="height:20rem;margin-left: 20px; width: 16rem" class="card p-4 shadow-sm"  onclick=" window.location.href='{{route('expenses.index',['start_date' =>\Carbon\Carbon::now()->toDateString(),'end_date'=>\Carbon\Carbon::now()->toDateString()])}}'">
                    <h6 class="fw-bold">TODAY EXPENSES</h6>
                    <p class="text-muted">Remaining = 1200</p>
                    <div class="d-flex align-items-center" >
                        <div class="ms-4">
                            <p><i class="fas fa-flag text-dark"></i> <strong>Base Goal</strong> <br> {{$budget->limit??0 }}</p>
                            <p><i class="fas fa-wallet text-warning"></i> <strong>Expenses</strong> <br> {{ $totalExpenses->todayExpenses??0}}</p>
                            <p><i class="fas fa-bag-shopping text-primary"></i> <strong>Total</strong> <br> {{ $totalExpenses->todayExpensesCount??0}}</p>
                        </div>
                    </div>
                </div>
                <div style="height:20rem;width: 16rem;margin-left: 20px" class="card p-4 shadow-sm" onclick=" window.location.href='{{route('expenses.index',['start_date' =>\Carbon\Carbon::yesterday()->toDateString(),'end_date'=>\Carbon\Carbon::yesterday()->toDateString()])}}'">
                    <h6 class="fw-bold">YESTERDAY EXPENSES</h6>
                    <p class="text-muted">Remaining = 1200</p>
                    <div class="d-flex align-items-center">
                        <div class="ms-4">
                            <p><i class="fas fa-flag text-dark"></i> <strong>Base Goal</strong> <br> {{$budget->limit??0 }}</p>
                            <p><i class="fas fa-wallet text-warning"></i> <strong>Expenses</strong> <br> {{$totalExpenses->yesterdayExpenses??0}}</p>
                            <p><i class="fas fa-bag-shopping text-primary"></i> <strong>Total</strong> <br> {{$totalExpenses->yesterdayExpensesCount??0}}</p>
                        </div>
                    </div>
                </div>

                <div style="height:20rem; width: 16rem;margin-left: 20px" class="card p-4 shadow-sm" onclick=" window.location.href='{{route('expenses.index',['start_date' =>\Carbon\Carbon::now()->startOfMonth()->toDateString(),'end_date'=>\Carbon\Carbon::now()->endOfMonth()->toDateString()])}}'">
                    <h6 class="fw-bold"> EXPENSES FOR {{strtoupper(\Carbon\Carbon::now()->format('F'))}}</h6>
                    <p class="text-muted">Remaining = 1200</p>

                    <div class="d-flex align-items-center">

                        <div class="ms-4">
                            <p><i class="fas fa-flag text-dark"></i> <strong>Base Goal</strong> <br> {{$budget->limit??0 }}</p>
                            <p><i class="fas fa-wallet text-warning"></i> <strong>Expenses</strong> <br> {{$totalExpenses->monthExpenses??0}}</p>
                            <p><i class="fas fa-bag-shopping text-primary"></i> <strong>Total</strong> <br> {{$totalExpenses->monthExpensesCount??0}}</p>
                        </div>
                    </div>
                </div>
                <div style="height:20rem; width: 15rem;margin-left: 14px" class="card p-4 shadow-sm" onclick=" window.location.href='{{route('expenses.index',['start_date' =>\Carbon\Carbon::now()->startOfYear()->toDateString(),'end_date'=>\Carbon\Carbon::now()->endOfYear()->toDateString()])}}'">
                    <h6 class="fw-bold"> EXPENSES FOR {{strtoupper(\Carbon\Carbon::now()->format('o'))}}</h6>
                    <p class="text-muted">Remaining = 1200</p>

                    <div class="d-flex align-items-center">
                        <div class="ms-4">
                            <p><i class="fas fa-flag text-dark"></i> <strong>Base Goal</strong> <br> {{$budget->limit??0 }}</p>
                            <p><i class="fas fa-wallet text-warning"></i> <strong>Expenses</strong> <br> {{$totalExpenses->thisYearExpenses??0}}</p>
                            <p><i class="fas fa-bag-shopping text-primary"></i> <strong>Total</strong> <br> {{$totalExpenses->thisYearExpensesCount??0}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="child_div_1 d-flex justify-content-between align-items-center">
                <h6 class="header2"> <i class="fa-solid fa-calendar-week" style="margin-right: 10px;font-size: 20px; margin-bottom: 12px" ></i>STATEMENTS</h6>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Posting Date</th>
                        <th>Type</th>
                        <th>Amount</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($findStatements as $statementData)
                        <tr>
                            <td>{{$statementData->created_at->todateString()}}</td>
                            <td>
                                @if($statementData->statementable_type == "App\Models\Expenses")
                                    Expenses
                                @else
                                    Income
                                @endif
                            </td>
                            <td>
                                @if($statementData->statementable_type == "App\Models\Expenses")
                                    <span style="color: red;font-weight: bold"> Rs. -{{$statementData->amount}}</span>
                                @else
                                    <span style="color: green; font-weight: bold">Rs. {{$statementData->amount}}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div style="margin-left: 5px;width: 43rem; margin-top: 23px;margin-right:20px "class="card shadow-sm">
            <h6 class="fw-bold" style="margin-top: 20px;margin-left: 7rem"> <i class="fa-solid fa-calendar-week" style="margin-right: 10px;font-size: 20px; margin-bottom: 12px" ></i>EXPENSES HISTORY</h6>
            @foreach($getExpenses as $recentExpenses)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0 20px;">
                    <h1 style="font-size: 15px; font-weight: bold; margin-left: 15px"><i class="fa-solid fa-money-bill" style="margin-right: 13px"></i>{{ $recentExpenses->title }}</h1>
                    <h2 style="font-size: 15px; color: red; font-weight: bold; margin: 0;">Rs.{{ $recentExpenses->amount }}</h2>
                </div>
                <p style="margin-left: 32px;font-size: 13px">{{\Carbon\Carbon::parse($recentExpenses->created_at)->format('D d M, Y')}}</p>
                <hr style="border: 1px solid #b3afaf; margin: 2px 0;">
            @endforeach
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0 20px;">
                    <h1 style="font-size: 15px; font-weight: bold; margin-left: 15px"><i class="fa-solid fa-wallet" style="margin-right: 13px"></i>Missing Expenses?</h1>
                    <a href="{{ route('expenses.create', ['category_id' => 0, 'start_date' => now()->toDateString()]) }}" class="button">Add Expenses</a>
                </div>
            </div>
        </div>
    </div>
{{--    <div class="child_div_1 d-flex justify-content-between align-items-center">--}}
{{--        <h6 class="header2"> <i class="fa-solid fa-calendar-week" style="margin-right: 10px;font-size: 20px; margin-bottom: 12px" ></i>STATEMENTS</h6>--}}
{{--        <table class="table table-bordered">--}}
{{--            <thead>--}}
{{--            <tr>--}}
{{--                <th>Posting Date</th>--}}
{{--                <th>Type</th>--}}
{{--                <th>Amount</th>--}}
{{--                <th>Remaining</th>--}}

{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            @foreach($findStatements as $statementData)--}}
{{--                <tr>--}}
{{--                    <td>{{$statementData->created_at->todateString()}}</td>--}}
{{--                    <td>--}}
{{--                        @if($statementData->statementable_type == "App\Models\Expenses")--}}
{{--                            Expenses--}}
{{--                        @else--}}
{{--                            Income--}}
{{--                        @endif--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        @if($statementData->statementable_type == "App\Models\Expenses")--}}
{{--                            <span style="color: red;font-weight: bold"> Rs. -{{$statementData->amount}}</span>--}}
{{--                        @else--}}
{{--                            <span style="color: green; font-weight: bold">Rs. {{$statementData->amount}}</span>--}}
{{--                        @endif--}}
{{--                    </td>--}}
{{--                    <td>{{$statementData->remaining_balance}}</td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--            </tbody>--}}
{{--        </table>--}}
{{--    </div>--}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
</x-app-layout>

