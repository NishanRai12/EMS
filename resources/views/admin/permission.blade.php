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
                overflow-y: auto;
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

            /* Table styling */
            .table th, .table td {
                text-align: center;
            }
        </style>
    </head>

    <div class="main_div">
        <div class="child_div_1">
                @foreach($allPermissions as $group => $permissions)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h2>{{ $group }}</h2>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Permission Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($permissions as $permission)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td>
                                            @if($permission->roles()->exists())
                                            <form method="POST" action="{{ route('admin.destroyPermission', $permission->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <x-primary-button class="mt-4">Delete</x-primary-button>
                                            </form>
                                            @else
                                                <form method="POST" action="{{ route('admin.createPermission', $permission->id) }}">
                                                    @csrf
                                                    <x-primary-button class="mt-4" name="permission" value="{{ $permission->id }}">Update</x-primary-button>
                                                </form>
                                            @endif
                                        </td>
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
