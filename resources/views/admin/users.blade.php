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
            <div class="header">Users</div>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>User Name</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $userData)
                    <tr>
                        <td>{{$userData->username}}</td>
                        <td>{{$userData->first_name}}</td>
                        <td>{{$userData->last_name}}</td>
                        <td>{{$userData->email}}</td>
{{--                        <td> <a href="{{route('admin.show',$userData->id)}}">Categories</a></td>--}}
                        <td>
                            <a href="{{ route('admin.show', ['month' => \Carbon\Carbon::now()->format('F'), 'user_id' => $userData->id]) }}">Categories</a>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
