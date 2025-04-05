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
            max-width: 800px;
            height: 32rem;
        }

        button {
            margin-top: 15px;
            padding: 8px;
            width: 6rem;
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

        .form_input {
            width: 300px;
        }

        input {
            height: 36px;
            width: 607px;
        }

        h1 {
            font-family: 'Arial', sans-serif;
            color: #3260a8;
            font-size: 3rem;
            font-weight: bold;
        }

    </style>
</head>
<body>
<div class="main_div">
    <div class="child_div_1" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
        <h1>ESTIMATE PERCENTAGE</h1>
        {{--        @if(session('error'))--}}
        {{--            <script>alert('Percentage cannot be greater than 100%')</script>--}}
        {{--        @endif--}}
        {{--        @if(session('null'))--}}
        {{--            <script>alert('Percentage cannot be null')</script>--}}
        {{--        @endif--}}
        {{--        @if(session('catNull'))--}}
        {{--            <script>alert('Category cannot be null')</script>--}}
        {{--        @endif--}}
        <form action="{{route('category.storeFormSession')}}" method="POST">
            @csrf
            @foreach($category as $categoriesData)
                <div class="form-check">
                    <div>
                        <input type="hidden" name="categories[]" value="{{ $categoriesData->id }}"
                               id="category_{{ $categoriesData->id }}" class="form-check-input">
                        <label class="form-check-label" for="category_{{ $categoriesData->id }}">
                            {{ $categoriesData->name }}
                        </label>
                    </div>
                    <div>
                        <input type="number" name="percentages[{{ $categoriesData->id }}]" placeholder="%" min="0"
                               max="100">
                        {{--                        @dd($errors)--}}

                        @error("percentages.{$categoriesData->id}")
                        <p class="text text-danger"> {{$message }}</p>
                        @enderror
                    </div>
                </div>


                <br>
            @endforeach
            @error('percentages')
            <div class="alert alert-danger"> {{$message }}</div>
            @enderror
            <div style="display: flex; justify-content: end;">
                {{ $category->links() }}
            </div>
            <button type="submit">Submit</button>
        </form>

    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<script>
    function validateIform() {
        document.getElementById('validateIform').submit();
    }
</script>



