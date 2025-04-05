<x-app-layout>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        .container {
            margin-top: 2%;
            height: 500px;
            overflow: hidden;
            border: 1px solid #333;
            position: relative;
            background-color: #ffffff;
            padding: 25px;
            border-radius: 8px;
            width: 70%;
        }

        .content-wrapper {
            display: flex;
            transition: transform 0.5s ease-in-out;
            width: 100%;
        }

        .content {
            margin-top: 30px;
            min-width: 100%;
            height: 200px;
            display: flex;
            flex-direction: column;
            margin-left: 130px;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        button {
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            background-color: #3260a8;
            color: white;
            border-radius: 5px;
        }

        button:disabled {
            background-color: gray;
            cursor: not-allowed;
        }
        h1 {
            font-family: 'Arial', sans-serif;
            color: #3260a8;
            font-size: 40px;
            font-weight: bold;
        }

        .form-check-label {
            font-size: 16px;
            font-weight: 500;
            color: #333;
            cursor: pointer;
            flex-grow: 1; /* Allows label to take available space */
        }

    </style>
</head>
<body>
<div class="container">
    <div id="contentWrapper" class="content-wrapper">
        <div class="content">
            <h1>SELECT EXPENSES PERCENTAGE</h1>
            @if(session('error'))
                <script>alert('Percentage cannot be greater than 100%')</script>
            @endif
            @if(session('null'))
                <script>alert('Percentage cannot be null')</script>
            @endif
            @if(session('catNull'))
                <script>alert('Category cannot be null')</script>
            @endif
            <form action="{{route('percentage.store')}}" method="POST">
                @csrf
                @foreach($category as $categoriesData)
                    <div class="form-check">
                        <input type="checkbox" name="categories[]" value="{{ $categoriesData->id }}" id="category_{{ $categoriesData->id }}" class="form-check-input">
                        <label class="form-check-label" for="category_{{ $categoriesData->id }}">
                            {{ $categoriesData->name }}
                        </label>
                        <input type="number" name="percentages[{{ $categoriesData->id }}]" placeholder="%" min="0" max="100">
                    </div>
                    <br>
                @endforeach
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
</x-app-layout>
