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
                background-color: #f3f4f6;
                display: flex;
                justify-content: center;
                align-items: center;
                margin: 0;
            }

            .child_div_1 {
                height: 90vh;
                margin-top: 30px;
                background-color: #ffffff;
                padding: 100px;
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
                background-color: #3260a8;
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
        <div class="child_div_1">
            @foreach($expensesCat as $expenses)
                <div style="margin-left: 4rem;margin-right: 20rem; width: 65rem" class="card p-4 shadow-sm">
                    <h6 class="fw-bold">
                        {{ $expenses->title }} [<span style="color: #0056b3;">{{ $expenses->category->name }}</span>]
                        <a href="{{ route('expenses.edit',$expenses->id)}}?start_date={{request('start_date')}}&end_date={{request('end_date')}}" title="Edit">
                            <i class="fas fa-edit ms-2"></i>
                        </a>
                    </h6>
                    <p class="text-muted">{{\Carbon\Carbon::parse($expenses->created_at)->format('D d M, Y')}}</p>
                    <p>{{$expenses->description}}</p>
                </div>
            @endforeach
            <div class="container mt-5 d-flex justify-content-center">
                {{ $expensesCat->appends(['category_id' => request('category_id'), 'start_date' => request('start_date'), 'end_date' => request('end_date')])->links() }}
            </div>
        </div>
    </div>

    </body>

    </html>
</x-app-layout>
