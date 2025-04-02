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
                height: 80vh;
            }

            .child_div_1 {
                /*height: 90vh;*/
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
        <div  style="height: fit-content" class="child_div_1" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
            <div class="header"> CREATE EXPENSES</div>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{route('expenses.pastExpensesStore')}}" method="POST">
                @csrf
                <input hidden name="category_id" value="{{ $category->id}}">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input name="title" placeholder="title" value="{{ old('title', $title ?? '') }}">
                </div>
                @error('title')
                <div style="color: red ; margin-left: 32.6%">{{$message}}</div>
                @enderror
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea style ="width:57rem" placeholder="Description"  name="description"  id= "" cols="85" rows="4"> {{ old('description', $description ?? '') }} </textarea>
                </div>
                @error('description')
                <div style="color: red ; margin-left: 32.6%">{{$message}}</div>
                @enderror
                <div class="form-group">
                    <label for="spend">Amount</label>
                    <input placeholder="Amount" type="number" name="amount" value ={{old('amount', $amount ?? '')}} >
                </div>
                @error('amount')
                <div style="color: red ; margin-left: 32.6%">{{$message}}</div>
                @enderror
                <div class="form-group">
                    <label for="spend">Date</label>
                    <input placeholder="Amount" type="date" name="date" value ={{old('amount', $amount ?? '')}} >
                </div>
                @error('date')
                <div style="color: red ; margin-left: 32.6%">{{$message}}</div>
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
