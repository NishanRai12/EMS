</html>

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
                height: 32rem;
            }

            button {
                width: 6rem;
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
            input{
                height: 35px;
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
            <h1>REGISTRATION</h1>
            <form action="{{route('user.store')}}" method="POST" id="validateRform">
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
                    <input type="password" style="width: 607px" class="form_input" name="password" id="password">
                </div>
                <div class="mb-1">
                    <label for="password" class="label_input">Confirm password</label><br>
                    <input type="password" style="width: 607px" class="form_input" name="password_confirmation" >
                </div>
                @error('password')
                <div style="color: red">{{ $message }}</div>
                @enderror
                <button type="reset">Reset</button>
                <button onclick="validateForm()">Next</button>
            </form>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    </body>
    </html>


