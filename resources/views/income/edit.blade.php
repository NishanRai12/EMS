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
                padding: 5rem 25px;
                border-radius: 8px;
                max-width: 800px;
                height: 32rem;
            }

            button {
                margin-top: 15px;
                padding: 8px ;
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
            input{
                height: 36px;
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
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <h1>INCOME</h1>
            <form action="{{route('income.update',$income->id)}} " method="POST">
                @csrf
                @method('PUT')
                <div class="mb-1">
                    <label for="amount" class="label_input">Amount</label> <br>
                    <input type="number" style="width: 607px" class="form_input" name="amount" value="{{ old ('amount',$income->amount)}}" id="amount">
                </div>
                @error('amount')
                <div style="color: red">{{ $message }}</div>
                @enderror
                <div class="mb-1">
                    <label for="date" class="label_input">Amount</label> <br>
                    <input type="date" style="width: 607px" class="form_input" name="date" value="{{ old ('date',$income->created_at->todateString())}}" id="amount">
                </div>
                @error('date')
                <div style="color: red">{{ $message }}</div>
                @enderror
                <button type="submit">Update</button>
            </form>
                <form action="{{route('income.destroy',$income->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    </body>
    </html>
</x-app-layout>



