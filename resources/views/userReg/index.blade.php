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
            padding: 8px ;
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
            <h1>Registration</h1>
            <form action="{{route('validate.user')}}" method="POST" id="validateRform">
                @csrf
                <input type="hidden" name="user_logged" value="{{ Auth::id() }}">
                <div style="display: flex; flex-direction: row; gap:5px">
                    <div class="mb-1">
                        <label for="first_name" class="label_input">First Name</label><br>
                        <input type="text" class="form_input" name="first_name" id="first_name" value="{{ old('first_name', $firstName ?? '') }}">
                    </div>
                    <div class="mb-1">
                        <label for="last_name" class="label_input">Last Name</label><br>
                        <input type="text" class="form_input" name="last_name" value="{{ old('last_name', $lastName ?? '') }}" id="last_name">
                    </div>
                </div>
                <div style="display: flex; gap: 20px;">
                    @error('first_name')
                    <div style="color: red">{{ $message }}</div>
                    @enderror
                    @error('last_name')
                    <div style="color: red">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-1">
                    <label for="username" class="label_input">User Name</label><br>
                    <input type="text" style="width: 607px" class="form_input" name="username" id="username" value="{{ old('username', $username ?? '') }}">
                </div>

                @error('username')
                <div style="color: red">{{ $message }}</div>
                @enderror

                <div class="mb-1">
                    <label for="email" class="label_input">Email</label><br>
                    <input type="email" style="width: 607px" class="form_input" name="email" value="{{ old('email', $email ?? '') }}" id="email">
                </div>
                @error('email')
                <div style="color: red">{{ $message }}</div>
                @enderror


                <div class="mb-1">
                    <label for="password" class="label_input">Password</label><br>
                    <input type="password" style="width: 607px" class="form_input" value="{{ old('password', $password ?? '') }}" name="password" id="password">
                </div>
                <button type="reset">Reset</button>
                <button onclick="validateForm()">Next</button>
            </form>
        </div>
    </div>
</div>
<script>
    function validateRForm(){
                document.getElementById('validateRform').submit();
    }
</script>





</body>
</html>
