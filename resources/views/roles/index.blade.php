<x-app-layout>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Categories</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

        <style>
            .main_div {
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
                display: flex;
                justify-content: center;
                /*align-items: center;*/
                margin-top: 30px;

            }

            .child_div_1 {
                background-color: #ffffff;
                padding: 25px;
                border-radius: 8px;
                width: 100%;
                max-width: 85rem;
                height: 80vh;
            }

            .header {
                font-size: 18px;
                font-weight: bold;
                margin-bottom: 10px;
                margin-top: 10px;
                background: #e8eaf6;
                padding: 10px;
                border-radius: 4px;
                text-align: center;
            }

            .button {
                padding: 10px 15px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                text-decoration: none;
                color: white;
                background-color: #0056b3;
            }

            .form-inline {
                display: flex;
                flex-direction: row;
                align-items: center;
                column-gap: 9px;
            }

            .input_search {
                width: 20rem;
            }

            .search_button {
                border: white 2px solid;
                color: white;
                background-color: #0056b3;
                padding: 10px 20px;
                font-size: 16px;
                border-radius: 5px;
            }
        </style>
    </head>

    <div class="main_div">
        <div class="child_div_1">
            <div class="header">Roles</div>
            <div style="display: flex; justify-self: center; margin-bottom: 34px">
                <form class="form-inline" action="{{route('role.index')}}" method="GET">
                        <input name="search_data" class="input_search" type="search" placeholder="Search Roles"
                           aria-label="Search">
                    <button class="search_button" type="submit">Search</button>
                </form>
            </div>
            <div style="display: flex; flex-direction: row; align-items: center;">
                <div>
                    <a class="button" href="{{ route('role.create') }}">
                        Add Category
                    </a>
                </div>
                <div style="margin-left: auto;">
                    <form action="{{route('role.index') }}" method="GET">
                        <div class="input-group">
                            <input type="date" name="start_date" class="form-control me-2">
                            <input type="date" name="end_date" class="form-control me-2">
                            <button class="btn btn-primary" type="submit">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                @if($roles->isEmpty())
                    <div style="display: flex;font-size: 22px;justify-self: center; margin-top: 10rem;color: #6b7280">Roles Not Found</div>
                @else
                    <table class="table">
                        <thead>
                        <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th>Created at</th>
                            <th>Count</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $roleUser)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $roleUser->role_name }}</td>
                                <td>{{ $roleUser->created_at }}</td>
                                <td>{{ $roleUser->users->count() }}</td>
                                <td>
                                    <a href="{{route('role.edit',$roleUser->id)}}"><i class="fa-solid fa-pen-to-square"></i></a>
                                </td>
                                <td><a href="{{route('role.show',$roleUser->id)}}"><i style="color: #0056b3" class="fa-solid fa-eye"></i></a>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</x-app-layout>
