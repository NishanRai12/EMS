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
                height: 100vh;
            }

            .child_div_1 {
                background-color: #ffffff;
                padding: 25px;
                border-radius: 8px;
                width: 100%;
                max-width: 800px;
            }
        </style>
    </head>
    <body>
    <div class="main_div">
        <div  style="height: fit-content" class="child_div_1" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">
                Add Categories
            </button>

            <div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel" style="height:50%; width: 100%;">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasTopLabel">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <form action="{{ route('category.store') }}" method="POST" id="tagForm">
                        @csrf
                        <input type="hidden" name="user_logged" value="{{ Auth::id() }}">
                        <div class="mb-3">
                            <label for="cat_name" class="form-label">Category</label>
                            <input type="text" class="form-control" name="cat_name" value="{{ old('cat_name') }}">
                        </div>
                        @error('cat_name')
                        <div style="color: red;">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Created</th>
                    <th scope="col">Owner</th>
                    <th scope="col">Users</th>

                </tr>
                </thead>
                <tbody>
                @foreach($categories as $displayData)
                    <tr>
                        <td>{{ $displayData->name }}</td>
                        <td>{{ $displayData->created_at }}</td>
                        <td>{{ $displayData->user->fullname() }}</td>
                        <td>{{ $displayData->users_count??0}}</td>

                        <td>
                            <div class="dropdown-center" style="display: flex; justify-content: end; ">
                                <button style="background-color: white ; border: none;color : black ; place-content: center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>

                                <ul class="dropdown-menu">
                                    @if($displayData->deleted_at == "")
                                        <form method= "POST" action="{{route('admin.categoryDestroy',$displayData->id)}}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item" type="Submit"> Delete</button>
                                        </form>
                                    @else
                                        <form method= "POST" action="{{route('admin.categoryRestore',$displayData->id)}}">
                                            @csrf
                                            <button class="dropdown-item" type="Submit"> Restore</button>
                                        </form>
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            {{--            {{$categories->links()}}--}}

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var myOffcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasTop'));

            // Keep offcanvas open if there are validation errors
            @if($errors->any())
                window.onload = function () {
                myOffcanvas.show();
            };
            @endif

            document.getElementById('tagForm').addEventListener('submit', function (event) {
                const errorMessage = document.querySelector('.text-danger');
                if (errorMessage) {
                    event.preventDefault();
                    myOffcanvas.show();  // Prevents closing when there are errors
                }
            });
        });
    </script>

    </body>
    </html>
</x-app-layout>
