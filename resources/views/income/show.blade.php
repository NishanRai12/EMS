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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <style>
            .main_div {
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }
            .child_div_1 {
                margin-top: 10px;
                margin-bottom: 5px;
                background-color: #ffffff;
                padding: 25px;
                border-radius: 8px;
                width: 60rem;
                height: 7rem;

            }

            strong {
                font-size: 18px;
                color: #333;
                font-weight: bold;
            }
            .header2  {
                font-size: 17px;
                font-weight: bold;
                color: #333;
            }
            .header1  {
                font-size: 17px;
                /*font-weight: bold;*/
                color: white;
            }
            .header3  {
                font-size: 14px;
                font-weight: bold;
                color: white;
            }

            .header .right {
                font-size: 18px;
                color: #4caf50;
            }
            .income {
                margin-bottom: 20px;
                padding: 15px;
                border-radius: 8px;
                font-family: Arial, sans-serif;
                background-color: #3260a8;
                border-left: 5px solid #8b91b6;
                width: 80rem;
                margin-top: 15px;
                height: 12rem;
            }
            .button_add {
                font-size: 16px;
                font-weight: bold;
                margin-bottom: 10px;
                background: white;
                padding: 2px 16px;
                border-radius: 4px;
                text-align: center;
                color: #3260a8;
                text-decoration: none;
                margin-left: 67rem;
            }
        </style>
    </head>
    <body>
    <div class="main_div">
        <div class="income">
            <div style="display: flex; flex-direction: row">
                <h1 class ="header1"> {{$message}}</h1>
                <a class="button_add" href="{{route('income.create')}}">Add</a>
            </div>
            <h2 class="header1" style="font-weight: bold; font-size:25px "> {{$user->fullname()}}</h2>
            <h3 class ="header3" >NPR <span style="font-size:19px">{{$incomes->sum('amount')}}</span></h3>
        </div>
        @foreach($incomes as $incomeData)
            <div class="child_div_1 d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="header2">NPR {{$incomeData->amount}}</h1>
                    <p><i class="fa-solid fa-clock"></i> {{$incomeData->created_at->toDateString()}}</p>
                </div>
              <div  style="position: relative;">
                  <a class="dropdown-item" href="{{ route('income.edit', $incomeData->id) }}"> <i class="fa-solid fa-pen-to-square"></i></a>
                </div>
            </div>
        @endforeach
        {{$incomes->links()}}
    </div>

    </body>

    </html>
</x-app-layout>
