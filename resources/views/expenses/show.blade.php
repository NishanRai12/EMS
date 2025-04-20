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
                background-color: #f3f4f6;
                display: flex;
                justify-content: center;
                align-items: center;
                margin: 0;
            }

            .child_div_1 {
                height: 90vh;
                margin-top: 30px;
                background-color: #ffffff;
                padding: 40px 100px ;
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
            .form-group label {
                flex: 1 1 30%;
                margin-bottom: 5px;
                font-size: 14px;
            }
            .table th {
                background-color: #f1f3f5;
                text-align: center;
            }
            .table td {
                text-align: center;
            }
            .button-group button {
                padding: 10px 15px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }
            .btn-container {
                display: flex;
                flex-direction: row;
                gap: 10px; /* Adjust spacing between buttons */
                justify-content: center;

            }
            .button {
                background-color: #3260a8;
                color: white;
                border: none;
                padding: 8px 15px;
                border-radius: 5px;
                cursor: pointer;
                text-decoration: none;
                transition: background 0.3s;
            }
            .btn a {
                color: white;
                text-decoration: none;
                display: block;
            }

        </style>
    </head>
    <body>
    <div class="main_div">
        <div class="child_div_1">
            <h1 class="header">EXPENSES FOR {{strtoupper($cat_name)}}</h1>
            <div style="display: flex; flex-direction: row; align-items: center;">
                <div>
                    <a class="button" href="{{ route('expenses.create', ['category_id' => request('category_id'), 'start_date' => request('start_date')]) }}">
                        Add Expenses
                    </a>
                </div>
                <div style="margin-left: auto;">
                    <form action="{{ route('expenses.showCatExpenses') }}" method="GET">
                        <div class="input-group">
                            <input type="date" name="start_date" class="form-control me-2">
                            <input type="date" name="end_date" class="form-control me-2">
                            <input type="hidden" name = "category_id" value="{{request('category_id')}}">
                            <button class="btn btn-primary" type="submit">Filter</button>
                        </div>
                    </form>
                </div>
            </div>

            <div style="margin-bottom: 20rem">
                @if(!$expensesCat->isEmpty())
                    @foreach($expensesCat as $expenses)
                        <div style="margin-left: 4rem;margin-top: 20px;margin-right: 20rem; width: 65rem" class="card p-4 shadow-sm">
                            <h6 class="fw-bold" style="font-size: 17px">{{ $expenses->title }} [<span style="color: #0056b3;">{{ $expenses->category->name }}</span>]
                                <a href="{{ route('expenses.edit',$expenses->id)}}?start_date={{request('start_date')}}&end_date={{request('end_date')}}" title="Edit">
                                    <i class="fas fa-edit ms-2"></i>
                                </a>
                            </h6>
                            <p class="text-muted">{{\Carbon\Carbon::parse($expenses->expenses_date)->format('D d M, Y')}}</p>
                            <p><span style="font-weight: bold">Rs.</span>{{$expenses->amount}}</p>
                            <p>{{$expenses->description}}</p>
                        </div>
                    @endforeach
                @else
                    <div style="display: flex;font-size: 22px;justify-self: center; margin-top: 14rem;color: #6b7280">Expenses Not Found</div>
                @endif
            </div>
            <div class="container mt-5 d-flex justify-content-center">
                {{ $expensesCat->appends(['category_id' => request('category_id'), 'start_date' => request('start_date'), 'end_date' => request('end_date')])->links() }}
            </div>
        </div>
    </div>

    </body>

    </html>
</x-app-layout>
