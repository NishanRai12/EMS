<x-app-layout>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Categories</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
{{--        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>--}}

        <style>
            .main_div {
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .child_div_1 {
                height: 80vh;
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
                text-align: center;
            }
        </style>
    </head>

    <div class="main_div">
        <div class="child_div_1">
{{--            display the header--}}
            <div class="header">ESTIMATE CATEGORIES EXPENSES FOR {{ strtoupper(\Carbon\Carbon::now()->format('F')) }}  <a href="{{route('category.create')}}"><i class="fa-solid fa-square-plus"></i></a></div>
{{--            display success message--}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <!-- Link to add percentage -->
            <a href="{{route('category_user.create')}}" style="margin-bottom: 20px" class="btn btn-primary">Assign Percentage</a>

            @php
                $colors = ['bg-secondary', 'bg-primary', 'bg-success', 'bg-danger', 'bg-warning', 'bg-info', 'bg-light', 'bg-dark'];
            @endphp

            @foreach($percentage as $index => $categories)
                <div class="card {{ $colors[$index % count($colors)] }} text-white mb-3" style="max-width: 80%; margin-left: 10%">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>{{ $categories->name }} [{{ $categories->pivot->percentage }}%]</span>
{{--                        <span>{{ $categories->id}}</span>--}}

                        <!-- Dropdown Button -->
                        <div class="dropdown">
                            <button class="btn btn-sm text-white dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('category_user.edit', $categories->id) }}">Edit</a></li>
                                <li>
                                    <form method="POST" action="{{ route('category_user.destroy', $categories->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item text-danger" type="submit">Delete</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
