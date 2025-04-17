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
            width: 44rem;
            height: 32rem;
        }
        button {
            padding: 6px;
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
            width: 500px;
        }

        h1 {
            font-family: 'Arial', sans-serif;
            color: #3260a8;
            font-size: 25px;
            margin-bottom: 20px;
            margin-left: 15px;
            font-weight: bold;
        }

    </style>
</head>
<body>
<div class="main_div">
    <div class="child_div_1" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
        <h1>CHOOSE CATEGORIES FOR YOUR EXPENSES</h1>
        @error('categories')
        <div class="alert alert-danger" role="alert">
            {{$message}}
        </div>
        @enderror
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @error('cat_name')
        <div class="alert alert-danger" role="alert">{{$message}}</div>
        @enderror
        <form action="{{ route('register.storeNewCategory') }}" method="POST">
            @csrf
            <div style="display: flex; flex-direction: row; gap: 4px;">
                <input name="cat_name" placeholder="Enter New category" required>
                <button type="submit" class="button">Add</button>
            </div>
        </form>
        <div class="form-check" style="display: flex; justify-content: center;">
            <form action="{{ route('registration.storeCategoryRegistration') }}" method="POST"
                  style="display: flex; flex-wrap: wrap; gap: 1rem; width: 100%;">
                @csrf
                @foreach($category as $categoriesData)
                    <div style="flex: 1 1 calc(25% - 1rem); display: flex; align-items: center; gap: 0.5rem;">
                        <input type="checkbox" name="categories[]" value="{{ $categoriesData->id }}" id="category_{{ $categoriesData->id }}" class="form-check-input">
                        <label class="form-check-label" for="category_{{ $categoriesData->id }}">
                            {{ $categoriesData->name }}
                        </label>
                    </div>
                @endforeach
                <div style="width: 100%; display: flex; justify-content: flex-end; margin-top: 1rem;">
                    <button type="submit">Submit</button>
                </div>
            </form>
        </div>
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



