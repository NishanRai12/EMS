<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome | Expense Tracker</title>
    <!-- Styles -->
    <style>
        *{
            margin: 0;
        }
        .main_div {
            display: flex;
            flex-direction: row;
            background: #38517e;
            height: 100vh;
        }
        .left_div, .right_div {
            width: 50%;
        }
        .right_div img {
            margin-top: 8rem;
        }
        .left_div {
            margin-top: 20rem;
        }
        .main_billboard{
            color: white;
            font-family: 'Poppins', sans-serif;
            font-size: 3rem;
            margin-left: 7rem;
        }
        .child_slogan{
            color: #fffbfb8f;
            font-family: 'Poppins', sans-serif;
            font-size: 22px;
            margin-top: 10px;
            margin-left: 7rem;
        }
        .button_started {
            padding: 12px 29px;
            width: 80px;
            margin-left: 7rem;
            margin-top: 20px;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            background-color: #e3eff9;
            transition: background-color 0.3s ease;
        }
        .button_started a{
            text-decoration: none;
            font-size: 14px;
            color: black;
            font-weight: bold;
            font-family: 'Poppins', sans-serif;
        }
        .button_started:hover {
            background-color: #63bfee; /* Darker green on hover */
        }
    </style>
</head>
<body>
<main class="main-content">
    <div class="main_div">
        <div class="left_div">
            <h1 class="main_billboard" >Better Solutions For</h1>
            <h1 class="main_billboard" >Your Expenses</h1>
            <p class="child_slogan">Track Your Money, Achieve Your Goals.</p>
            <div class="button_started">
                @if(Auth::user())
                    <a href="{{ route('monthlyBudget.index') }}" class="bg-blue-400 hover:bg-blue-500 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition-all duration-200">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('user') }}" class="bg-blue-400 hover:bg-blue-500 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition-all duration-200">
                        Get Started
                    </a>
                @endif
            </div>
        </div>
        <div class="right_div">
            <img src="{{ asset('storage/uploads/img.png') }}" alt="Business Illustration" style="height: 35rem">
        </div>
    </div>
</main>
</body>
</html>
