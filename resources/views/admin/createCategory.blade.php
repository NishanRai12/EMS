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
                min-height: 100vh;
            }
            .child_div_1 {
                background-color: #ffffff;
                padding: 30px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                width: 100%;
                max-width: 900px;
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
            .form-group {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                margin-bottom: 10px;
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
            .button-group {
                display: flex;
                justify-content: flex-start;
                gap: 10px;
            }
            .button-group button {
                padding: 10px 15px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }
            .add {
                background: #007bff;
                color: #fff;
            }
            .reset {
                background: #dc3545;
                color: #fff;
            }
        </style>
    </head>

    <div class="main_div">
        <div class="child_div_1">
            <div class="header">Add New Categories</div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form action="{{route('admin.storeCategory')}}" method="POST">
                @csrf
                <input type="hidden" name="user_logged" value="{{Auth::user()->id}}">
                <div class="form-group">
                    <label for="cat_name">Name</label> <br>
                    <input name="cat_name" placeholder="Name" value="{{old('cat_name', $cat_name ?? '') }}">
                </div>
                @error('cat_name')
                <div style="color: red ; margin-left: 32.6%">{{$message}}</div>
                @enderror
                <div class="button-group">
                    <button type="submit" class="add">Add</button>
                    <button type="reset" class="reset">Reset</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
