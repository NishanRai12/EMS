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
            }
        </style>
    </head>
    <body>
    <div class="main_div">
        <div class="child_div_1" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
            <div class="header">EXPENSES FOR {{strtoupper($month).' '. $date}}</div>
            @php
                $colors = ['bg-secondary','bg-primary', 'bg-success', 'bg-danger', 'bg-warning', 'bg-info', 'bg-light', 'bg-dark'];
            @endphp
            @foreach($categories as $index => $category)
                <div class="card text-{{ $colors[$index % count($colors)] }} mb-3" style="max-width: 80%; margin-left: 10%" onclick="window.location.href='{{ route('expenses.todayShow', $category->id) }}'">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>{{ $category->name }}</span>
                        <a href="{{ route('expenses.create', ['category_id' => $category->id]) }}">
                            <i class="fa-regular fa-square-plus"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">Items: {{ $category->expenses->count() }}</h6>
                        <h6 class="card-title">Cost: {{ $category->expenses->sum('amount') }}</h6>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </body>
    </html>
</x-app-layout>
