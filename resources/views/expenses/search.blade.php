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
            .form-group label {
                flex: 1 1 30%;
                margin-bottom: 5px;
                font-size: 14px;
            }
            .table th {
                background-color: #f1f3f5;
                text-align: center;
            }
            .table td {
                text-align: center;
            }
            .button-group button {
                padding: 10px 15px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }
            .btn-container {
                display: flex;
                flex-direction: row;
                gap: 10px; /* Adjust spacing between buttons */
                justify-content: center;

            }
            .btn {
                background-color: #007BFF;
                color: white;
                border: none;
                padding: 8px 15px;
                border-radius: 5px;
                cursor: pointer;
                text-decoration: none;
                transition: background 0.3s;
            }
            .btn a {
                color: white;
                text-decoration: none;
                display: block;
            }
            .btn:hover {
                background-color: #0056b3;
            }
            /* Delete button specific styling */
            .btn.delete {
                background-color: #dc3545;
            }
            .btn.delete:hover {
                background-color: #c82333;
            }

        </style>
    </head>
    <body>
    <div class="main_div">
        <div class="child_div_1" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
            {{--            <div class="header">Budget Allocation List [ <a style="color: #2a7ca6; text-decoration: none" href="{{route('monthlyBudget.create')}}">Add</a> ]</div>--}}

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Categories</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($expensesCat as $expenses)
                    <tr>
                        <td>{{$expenses->title??""}}</td>
                        <td>{{$expenses->description??""}}</td>
                        <td>{{$expenses->created_at??""}}</td>
                        <td>{{$expenses->amount??""}}</td>
                        <td>{{ $expenses->category_name }}</td>
                        {{--                        <td>{{\Carbon\Carbon::parse($expenses->created_at)->format('j')}}</td>--}}
                        <td>
                            <div class="btn-container">
                                <a href="{{ route('expenses.edit', $expenses->id) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('expenses.destroy', $expenses->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn delete" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>
    </div>

    </body>

    </html>
</x-app-layout>
