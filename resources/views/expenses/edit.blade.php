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
                min-height: 100vh;
            }
            .child_div_1 {
                background-color: #ffffff;
                padding: 30px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                width: 100%;
                max-width: 600px;
            }
            .header {
                font-size: 18px;
                font-weight: bold;
                margin-bottom: 10px;
                background: #e8eaf6;
                padding: 10px;
                border-radius: 4px;
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
                justify-content: flex-start;
                gap: 10px;
            }
            .button-group button {
                padding: 10px 15px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }
            .form-group label {
                font-size: 14px;
                margin-bottom: 8px;
                color: #333;
            }
            .add {
                background: #007bff;
                color: #fff;
            }
            .delete {
                background: red;
                color: #fff;
            }
        </style>
    </head>
    <body>
    <div class="main_div">
        <div style="height: fit-content" class="child_div_1" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{route('expenses.update',$expenses->id)}}" method="POST" onsubmit="return confirmSubmit()">
                @csrf
                @method('PUT')
                <input type="hidden" name ="start_date" value="{{request('start_date')}}">
                <input type="hidden" name ="category_id" value="{{request('category_id')}}">
                <input type="hidden" name="end_date" value="{{request('end_date')}}">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input name="title" value="{{ old('title', $expenses->title) }}">
                </div>
                @error('title')
                <div class="error-message">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description">{{ old('description', $expenses->description) }}</textarea>
                </div>
                @error('description')
                <div class="error-message">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="spend">Amount</label>
                    <input placeholder="Amount" value="{{ old('amount', $expenses->amount) }}" type="number" name="amount">
                </div>
                @error('amount')
                <div class="error-message">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select name="category_id" id="category_id">
                        @foreach($getUserChhosedCategory as $getCat)
                            <option value="{{ $getCat->id }}"
                                    @if($getCat->id == $expenses->category_id) selected @endif>
                                {{ $getCat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="spend">Date</label>
                    <input id="date" type="date" value="{{ old('created_at', \Carbon\Carbon::parse($expenses->expenses_date)->toDateString()) }}" name="date">
                </div>
                @error('date')
                <div class="error-message">{{ $message }}</div>
                @enderror
                <div class="button-group">
                    <button type="submit" class="add">Update</button>
                </div>
            </form>
            <form action="{{ route('expenses.destroy', $expenses->id)}}?category_id={{$expenses->category_id}}&start_date={{request('start_date')}}&end_date={{request('end_date') }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn delete" type="submit">Delete</button>
            </form>
        </div>
    </div>
    <script>
        function confirmSubmit() {
            var date = document.getElementById('date').value;
            if (!date) {
                alert("Please select a date.");
                return false;
            }
            return confirm("Are you sure the date is " + date + "?");
        }
    </script>
    </body>
    </html>
</x-app-layout>
