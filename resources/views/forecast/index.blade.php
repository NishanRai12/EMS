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
            .main_div {
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
                display: flex;
                justify-content: center;
                align-items: center;
                margin: 0;
            }

            .child_div_1 {
                margin-top: 30px;
                background-color: #ffffff;
                padding: 25px;
                border-radius: 8px;
                width: 100%;
                max-width: 90%;
            }
            .header {
                font-size: 18px;
                font-weight: bold;
                margin-bottom: 10px;
                background: #e8eaf6;
                padding: 10px;
                border-radius: 4px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            /* Month Buttons Container */
            .months {
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
                justify-content: center;
            }

            /* Individual Button Style */
            .month-btn {
                padding: 10px 13px;
                font-size: 14px;
                background-color: #BEC5EA;
                color: black;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease, transform 0.2s ease;
                margin: 5px;
                text-decoration: none;
            }
            .month-btn:hover {
                background-color: #8081b8;
                transform: scale(1.1);
            }
            .income {
                margin-bottom: 20px;
                padding: 15px;
                border-radius: 8px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                font-family: Arial, sans-serif;
                color: #333;
                background-color: #e8f5e9;
                border-left: 5px solid #00bcd4;
            }

            .prediction {
                margin-bottom: 20px;
                padding: 15px;
                border-radius: 8px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                font-family: Arial, sans-serif;
                color: #333;
                background-color: #fff3e0;
                border-left: 5px solid #ff9800;
            }
            .actual {
                margin-bottom: 20px;
                padding: 15px;
                border-radius: 8px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                font-family: Arial, sans-serif;
                color: #333;
                background-color: #e0f7fa;
                border-left: 5px solid #4caf50;
            }

            strong {
                font-size: 18px;
                color: #333;
                font-weight: bold;
            }
            .header .left {
                font-size: 20px;
                color: #333;
            }

            .header .right {
                font-size: 18px;
                color: #4caf50;
            }



        </style>
    </head>
    <body>
    <div class="main_div">
        <div class="child_div_1" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
            <div class="header">
                <span class="left">EXPENSES TRACKING FOR [ {{ strtoupper($currentMonth) }} ]</span>
                <a href="{{ route('forecast.show', \Illuminate\Support\Carbon::now()->addMonth()->format('F')) }}" class="right">predict</a>
            </div>
            <div class="months">
                @foreach($months as $mon)
                    <a class="month-btn" href="{{route('forecast.shoeExpenses',$mon)}}">{{$mon}}</a>
                @endforeach
            </div>
            <br>
            <div class="income">
                <strong>Income: {{$income_amount }}</strong>
            </div>
            <div class="prediction">
                <strong>Expenses Prediction: {{$forecastExpenses }}</strong>
            </div>
            <div class="actual">
                <strong>Actual expenses: {{$expenses }}</strong>
            </div>
            <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Category</th>
                            <th>Prediction Percentage </th>
                            <th>Prediction Expenses</th>
                            <th>Actual Expenses</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($categoryUser as $data)
                                <tr>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->category_percentage ?? 0}} %</td>
                                    <td><span style="font-weight: bold">NRP</span> {{$expensesExpectation[$data->id] }}</td>
                                    <td>
                                        <span style="font-weight: bold">NRP</span> {{$data->expenses_sum ?? 0}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
        </div>
    </div>

    </body>

    </html>
</x-app-layout>
