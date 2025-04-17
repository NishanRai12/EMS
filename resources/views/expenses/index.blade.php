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
                    .input-group {
                        display: flex;
                        justify-content: space-between;
                        gap: 10px;
                        align-items: center;
                        max-width: 600px;
                        margin: 0 auto;
                        padding-bottom: 15px;
                        padding-top: 20px;
                    }

                </style>
            </head>
            <body>
                <div class="main_div">
                    <div class="child_div_1" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
                        @if($start_date == $end_date)
                        <div class="header">EXPENSES FOR {{$start_date}}</div>
                        @else
                            <div class="header">EXPENSES FROM {{$start_date}} TO {{$end_date}}</div>
                        @endif
                            @error('start_date')
                            <div class="alert alert-danger" role="alert">
                                <span>{{$message}}</span>
                            </div>
                            @enderror
                            @error('end_date')
                            <div class="alert alert-danger" role="alert">
                                <span>{{$message}}</span>
                            </div>
                            @enderror
                        <form action="{{route('expenses.index')}}" method="GET">
                            @csrf
                            <div class="input-group">
                                <input type="date" name="start_date" class="form-control">
                                <input type="date" name="end_date" class="form-control">
                                <button class="btn btn-primary" type="submit">Filter</button>
                            </div>
                        </form>
                        @php
                            $colors = ['bg-secondary','bg-primary', 'bg-success', 'bg-danger', 'bg-warning', 'bg-info', 'bg-light', 'bg-dark'];
                        @endphp
                        @foreach($categories as $index => $category)
                            <div class="card text-{{ $colors[$index % count($colors)] }} mb-3" style="max-width: 80%; margin-left: 10%" onclick="window.location.href='{{ route('expenses.showCatExpenses',['category_id'=>$category->id,'start_date'=>$start_date,'end_date'=>$end_date])}}'">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <span>{{ $category->name }}</span>
                                        <a href="{{ route('expenses.create', ['category_id' => $category->id,'start_date'=>$start_date]) }}">
                                            <i class="fa-regular fa-square-plus"></i>
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="card-title">Items:- {{ $category->expense_count ?? 0}} </h6>
                                        <h6 class="card-title">Cost:- {{ $category->expenses_sum ?? 0}} </h6>
                                    </div>
                            </div>
                        @endforeach
                            <div class="d-flex justify-content-center mt-4">
                                {{ $categories->appends(['start_date' => request('start_date'), 'end_date' => request('end_date')])->links() }}
                            </div>
                    </div>
                </div>
            </body>
        </html>
</x-app-layout>
