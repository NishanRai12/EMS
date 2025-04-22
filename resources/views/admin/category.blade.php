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
            .button{
                padding: 10px 15px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                text-decoration: none;
                color:white;
                background-color: #0056b3 ;
            }

            .form-inline {
                display: flex;
                flex-direction: row;
                align-items: center;
                column-gap: 9px;
            }
            .input_search{
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
    <body>

    <div class="main_div">
        <div class="child_div_1" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
            <div class="header">
                CHOOSE CATEGORY FOR {{ strtoupper(\Carbon\Carbon::now()->format('F'))}}
            </div>
            <div style="display: flex; justify-self: center; margin-bottom: 34px">
                <form class="form-inline" action="{{route('admin.displayALLCategories')}}" method="GET">
                    <input  name= "search_data" class="input_search" type="search" placeholder="Search Categories" aria-label="Search">
                    <button class="search_button" type="submit">Search</button>
                </form>
            </div>
            <div style="display: flex; flex-direction: row; align-items: center;">
                <div>
                    <a class="button" href="{{ route('admin.createCategory') }}">
                        Add Category
                    </a>
                </div>
                <div style="margin-left: auto;">
                    <form action="{{route('admin.displayALLCategories') }}" method="GET">
                        <div class="input-group">
                            <input type="date" name="start_date" class="form-control me-2">
                            <input type="date" name="end_date" class="form-control me-2">
                            <button class="btn btn-primary" type="submit">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
            @if($categories->isEmpty())
                <div style="display: flex;font-size: 22px;justify-self: center; margin-top: 10rem;color: #6b7280">Category Not Found</div>
            @else
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
                        <td>{{ $displayData ->name }}</td>
                        <td>{{ $displayData->created_at }}</td>
                        <td>{{ $displayData->user->fullname() }}</td>
                        <td>{{ $displayData->users_count??0}}</td>

                        <td>
                            <div class="dropdown-center" style="display: flex; justify-content: end; ">
                                <button style="background-color: white ; border: none;color : black ; place-content: center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>

                                <ul class="dropdown-menu">
                                    <button class="dropdown-item" >
                                        <a  style="text-decoration: none " href="{{route('admin.editAdminCategory',$displayData->id)}}">Edit</a>
                                    </button>
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
            @endif

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
