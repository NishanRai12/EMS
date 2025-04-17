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
        <h1>SELECT CATEGORIES</h1>
            <form action="{{ route('registration.storePercentageRegistration') }}" method="POST">
                @csrf
                @foreach($fetchUserCat as $fetchedData)
                    <div class="form-check">
                        <div>
                            <input type="hidden" name="percentage[{{$fetchedData->id}}]" class="form-check-input">
                            <label class="form-check-label" for="category_{{ $fetchedData->id }}">
                                {{ $fetchedData->name }}
                            </label>
                        </div>
                        <div>
                            <input type="number" name="percentage[{{$fetchedData->id}}]" placeholder="%" min="0" max="100">
                            @error("percentage.{$fetchedData->id}")
                            <p class="text text-danger"> {{$message }}</p>
                            @enderror
                        </div>
                    </div>
                    <br>
                @endforeach
                <div style="width: 100%; display: flex; justify-content: flex-end; margin-top: 1rem;">
                    <button type="submit">Submit</button>
                </div>
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



