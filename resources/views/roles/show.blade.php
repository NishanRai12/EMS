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

            .form-group label {
                flex: 1 1 30%;
                margin-bottom: 5px;
                font-size: 14px;
            }

            .form-group input, .form-group select {
                flex: 1 1 65%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            .button-group button {
                padding: 10px 15px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
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
            }

            .form-inline {
                display: flex;
                flex-direction: row;
                align-items: center;
                column-gap: 9px;
            }
        </style>
    </head>

    <div class="main_div">
        <div class="child_div_1">
            <div class="header">{{ strtoupper($roleUser->role_name)}} </div>
            <div style="display: flex; flex-direction: row; align-items: center;">
                <div>
                    <form class="form-inline" action="{{route('role.show',$roleUser->id)}}" method="GET">
                        <input name="search_data" class="input_search" type="search" placeholder="Search Users"
                               aria-label="Search">
                        <button class="search_button" type="submit">Search</button>
                    </form>
                </div>
                <div style="margin-left: auto;">
                    <form action="{{route('role.show',$roleUser->id) }}" method="GET">
                        <div class="input-group">
                            <input type="date" name="start_date" class="form-control me-2">
                            <input type="date" name="end_date" class="form-control me-2">
                            <button class="btn btn-primary" type="submit">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                @if($getAllUser->isEmpty())
                    <div style="display: flex;font-size: 22px;justify-self: center; margin-top: 10rem;color: #6b7280">
                        Roles Not Found
                    </div>
                @else
                    <table class="table">
                        <thead>
                        <tr>
                            <th>SN</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Joined</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($getAllUser as $user)
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->username}}</td>
                            <td>{{ $user->email}}</td>
                            <td>{{ $user->first_name}}</td>
                            <td>{{ $user->last_name}}</td>
                            <td>{{ $user->created_at->todateString()}}</td>
                            <td><a href="{{route('admin.removeUserRole',$roleUser->id)}}"><i class="fa-solid fa-trash"></i></a></td>
                        @endforeach

                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
