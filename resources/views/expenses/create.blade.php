<x-app-layout>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Expense Form</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <style>
            .main-div {
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }
            .form-container {
                background-color: #ffffff;
                padding: 30px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                width: 100%;
                max-width: 600px;
            }

            .header {
                font-size: 24px;
                font-weight: bold;
                margin-bottom: 20px;
                text-align: center;
                color: #007bff;
            }

            .form-group label {
                font-size: 14px;
                margin-bottom: 8px;
                color: #333;
            }

            .form-group input,
            .form-group textarea,
            .form-group select {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                margin-bottom: 15px;
                font-size: 14px;
                color: #333;
            }

            .form-group textarea {
                resize: vertical;
                min-height: 100px;
            }

            .form-group input[type="date"] {
                cursor: pointer;
            }

            .error-message {
                color: red;
                font-size: 12px;
                margin-top: -10px;
                margin-bottom: 10px;
                margin-left: 10px;
            }

            .button-group {
                display: flex;
                justify-content: center;
                gap: 15px;
            }

            .button-group button {
                padding: 12px 25px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 16px;
                transition: background-color 0.3s;
            }

            .add {
                background-color: #007bff;
                color: white;
            }
            .add:hover {
                background-color: #0056b3;
            }
            .reset {
                background-color: #dc3545;
                color: white;
            }
            .reset:hover {
                background-color: #c82333;
            }
            .alert {
                margin-bottom: 15px;
            }
        </style>
    </head>
    <body>
    <div class="main-div">
        <div class="form-container">
            <div class="header">{{ $category->name }}</div>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('expenses.store') }}" method="POST" onsubmit="return confirmSubmit()">
                @csrf
                <input type="hidden" name="category_id" value="{{ $category->id }}">

                <div class="form-group">
                    <label for="title">Title</label>
                    <input id="title" name="title" placeholder="Title" value="{{ old('title', $title ?? '') }}">
                    @error('title')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Description" cols="30" rows="4">{{ old('description', $description ?? '') }}</textarea>
                    @error('description')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input id="amount" type="number" name="amount" placeholder="Amount" value="{{ old('amount', $amount ?? '') }}">
                    @error('amount')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="date">Date</label>
                    <input id="date" type="date" name="date" value="{{ old('date', $store_date) }}">
                    @error('date')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="button-group">
                    <button type="submit" class="add">Add</button>
                    <button type="reset" class="reset">Reset</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function confirmSubmit() {
            var date = document.getElementById('date').value; // Get the value of the date input field
            if (!date) {
                alert("Please select a date.");
                return false; // Prevent form submission if no date is selected
            }
            return confirm("Are you sure the date is " + date + "?"); // Confirmation message with date
        }
    </script>
    </body>
    </html>
</x-app-layout>
