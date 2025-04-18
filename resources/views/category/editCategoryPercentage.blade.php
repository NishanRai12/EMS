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
            .submit_percentage {
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
                <form action="{{route('category.storeModifiedCategoryPercentage')}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-1">
                        <input type="hidden" name="old_cat" value="{{$editCat->name}}">
                        <input type="text" style="width: 607px" class="form_input" name="category_name" value="{{ old('category_name', $editCat->name) }}"><br>
                        @error('category_name')
                        <div style="color: red">{{$message}} </div>
                        @enderror
                        <input type="number" style="width: 607px" class="form_input" name="category_percentage" value="{{ old('category_percentage', $editCat->percentages->first()->percentage) }}"><br>
                        @error('category_percentage')
                        <div style="color: red">{{$message}} </div>
                        @enderror
                    </div>
                    <button type="submit" class="submit_percentage">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    </body>
    </html>
</x-app-layout>
