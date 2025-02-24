


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
        .form_input {
            width: 300px;
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
<div class="container">
    <div id="contentWrapper" class="content-wrapper">
        <div class="content">
            @if(session('completed_income_credential'))
                <button onclick="nextPage()" style="border: none; background: none ;color: #3260a8; font-size: 30px; margin-right: 307rem" > <i class="fa-solid fa-arrow-right"></i></button>
            @endif
            <h1>Income</h1>
            <form action="{{route('validate.income')}} " method = "POST" id="validateIform">
                @csrf
                <input type="hidden" name="user_logged" value="{{ Auth::id() }}">
                <div class="mb-1">
                    <label for="amount" class="label_input">Amount</label> <br>
                    <input type="number" style="width: 607px" class="form_input" name="amount" id="amount" value="{{ old('amount') }}">
                </div>
                @error('amount')
                <div style="color: red">{{ $message }}</div>
                @enderror

                <div class="mb-1">
                    <label for="income_date" class="label_input">Income Date</label> <br>
                    <input  style="width: 607px" class="form_input" name="income_date" id="income_date" value="{{ old('income_date') }}">
                </div>
                @error('income_date')
                <div style="color: red">{{ $message }}</div>
                @enderror
                <div class="mb-1">
                    <label for="month" class="label_input">Month</label> <br>
                    <input type="text" style="width: 607px" class="form_input" name="month" id="month" value="{{ old('month') }}">
                </div>
                @error('month')
                <div style="color: red">{{ $message }}</div>
                @enderror
                <div class="mb-1">
                    <label for="year" class="label_input">Year</label> <br>
                    <input type="text" style="width: 607px" class="form_input" name="year" id="year" value="{{ old('year') }}">
                </div>
                @error('year')
                <div style="color: red">{{ $message }}</div>
                @enderror
                @if(session('completed_income_credential'))
                    <button onclick="prevPage()">Previous</button>
                @endif
                    <button type="reset">Reset</button>
                    <button onclick="validateIform()">Submit</button>
                <script>
                    function validateIncome(){
                        document.getElementById('validateIncome').submit();
                    }
                </script>
            </form>
        </div>
    </div>
</div>
</body>
</html>

<script>
    function validateIform(){
        document.getElementById('validateIform').submit();
    }
    function nextPage(){
        window.location.href = '{{route('category.showFormCat')}}';
    }
</script>
