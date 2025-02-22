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
            }

            .child_div_1 {
                height: 90vh;
                margin-top: 30px;
                background-color: #ffffff;
                padding: 25px;
                border-radius: 8px;
                width: 100%;
                max-width: 90%;
            }
            .header {
                font-size: 18px;
                font-weight: bold;
                margin-bottom: 10px;
                background: #e8eaf6;
                padding: 10px;
                border-radius: 4px;
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
    <body>
    <div class="main_div">
        <div class="child_div_1" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
            <div class="header">New Budget Allocation</div>
            <form action="{{route('monthlyBudget.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="Budget">Amount</label>
                    <input name="amount" placeholder="Amount">
                </div>
                @error('amount')
                <div style="color: red; margin-left: 32.6% " >{{$message}}</div>
                @enderror
                <div class="form-group">
                    <label for="Month">Month</label>
                    <select name="month" id="month">
                        <option selected disabled>Months</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
                @error('month')
                <div style="color: red; margin-left: 32.6% " >{{$message}}</div>
                @enderror

                <div class="button-group">
                    <button type="submit" class="add">Add</button>
                    <button type="reset" class="reset">Reset</button>
                </div>
            </form>
        </div>
    </div>

    </body>

    </html>
</x-app-layout>
