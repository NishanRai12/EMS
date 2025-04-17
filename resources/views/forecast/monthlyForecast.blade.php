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
                height: 90vh;
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
            }
            .header {
                font-size: 24px;
                font-weight: bold;
                margin-bottom: 20px;
                text-align: center;
                color: #333;
            }
            .months {
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
                justify-content: center;
            }
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
                background-color: #8081b8;  /* Darker green */
                transform: scale(1.1);  /* Slightly enlarge on hover */
            }
        </style>
    </head>
    <body>
    <div class="main_div">
        <div class="child_div_1" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
            <div class="header">FORECAST PREDICTION EXPENSES FOR [ {{strtoupper($currentMonth)}} ]</div>
            @if(session('error'))
                <h1>{{ session('error') }}</h1>
            @else
                <div> <strong>Expenses: {{$nextMonthExpenses }} NRP</strong></div>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Category</th>
                        <th>Percentage </th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($categoryUser as $data)
                            <tr>
                                <td>{{ $data->name }}</td>
                                <td><span style="font-weight: bold">NRP</span> {{$nextMonthEstimatedExpenses[$data->id]}}</td>
                                <td>{{ $percentageConverted[$data->id]?? 0 }} %</td>
                            </tr>
                        @endforeach

                    </tbody>

                </table>
            @endif
        </div>
    </div>
    </body>
    </html>
</x-app-layout>
