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
            <div class="first_div">
                <div class="header">
                   ASSIGN PERCENTAGE FOR {{ strtoupper(\Carbon\Carbon::now()->format('F'))}}
                </div>
                <h1 style="font-weight:bold;font-size: 17px; color: #0056b3">Total percentage:- {{$totalPercentageFormonth}} %</h1>
                <form method="POST" action="{{ route('category.storeCategoryPercentage')}}">
                    @csrf
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Percentage</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($category as $displayData)
                            <tr>
                                <td>{{ $displayData->name }}</td>
                                <td>
                                    <input type="number" placeholder="%" name="categoryPercentage[{{ $displayData->id }}]">
                                    <br>
                                    @error('categoryPercentage.' . $displayData->id)
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @error('cat_error')
                       <div style="color: red">{{$message}}</div>
                    @enderror
                    <button class="submit_category" type="submit">Submit</button>
                    <br>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    </body>
    </html>
</x-app-layout>
