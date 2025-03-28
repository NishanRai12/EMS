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
                background-color: #8081b8;  /* Darker green */
                transform: scale(1.1);  /* Slightly enlarge on hover */
            }
        </style>
    </head>

    <div class="main_div">
        <div class="child_div_1">

            @foreach($allPermissions as $group => $permissions)
                <div class="card mb-4">
                    <div class="card-header">
                        <h2>{{ $group }}</h2> <!-- Display group name -->
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Permission Name</th>
                                <th>Description</th> <!-- Add more columns if you have more fields -->
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($permissions as $permission)
                                <tr>
                                    <td>{{ $loop->iteration }}</td> <!-- Display index number -->
                                    <td>{{ $permission->name }}</td> <!-- Assuming 'name' is the permission name field -->
                                    <td>{{ $permission->description ?? 'No Description' }}</td> <!-- Assuming 'description' is a field (optional) -->
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
