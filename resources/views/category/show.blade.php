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
            .submit_category {
                font-size: 16px;
                margin-bottom: 10px;
                margin-top: 10px;
                background: #3260a8;
                padding: 6px 25px;
                border-radius: 4px;
                text-align: center;
                color: white;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
    <div class="main_div">
        <div  style="height: fit-content" class="child_div_1" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
            <a class="submit_category" href="{{route('category.create')}}">Add Categories</a>
            <div class="first_div">
                <div class="header">
                    CHOOSE CATEGORY FOR {{ strtoupper(\Carbon\Carbon::now()->format('F'))}}
                </div>
                <form method="POST" action={{route('category_user.store')}}>
                    @csrf
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($fetch_adminCat as $displayData)
                            <tr>
                                <td>{{ $displayData->name }}</td>
                                @if($displayData->deleted_at == "")
                                    <td style=" color:green">Enabled</td>
                                @else
                                    <td style="color:red;">Disabled</td>
                                @endif
                                <td><input name ="selectData[]" value="{{$displayData->id}}" type="checkbox"></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <button class="submit_category" type="submit">Submit</button>
                    <br>
                    @error('selectData')
                    <div style="color: red ">{{$message}}</div>
                    @enderror
                </form>
                {{$fetch_adminCat->links()}}
            </div>
            <div class="second_div">
                <div class="header">
                    CHOOSED CATEGORY FOR {{ strtoupper(\Carbon\Carbon::now()->format('F'))}}
                </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user_cat as $displayData)
                            <tr>
                                <td>{{ $displayData->name ??''}}</td>
                                @if($displayData->deleted_at == "")
                                    <td style=" color:green">Enabled</td>
                                @else
                                    <td style="color:red;">Disabled</td>
                                @endif
                                <td><a href="{{ route('category.removeUse',$displayData->id) }}" >Remove</a> </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                {{$user_cat->links()}}
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    </body>
    </html>
</x-app-layout>
