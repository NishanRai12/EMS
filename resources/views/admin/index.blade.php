<x-app-layout>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Dashboard</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

        <style>
            .dashboard-box {
                background-color: #ffffff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
                text-align: center;
                font-weight: bold;
                font-size: 20px;

            }
            .icon {
                font-size: 40px;
                margin-bottom: 10px;
                color: #4CAF50;

            }
            .details{
                font-size: 19px;
                color: black;
            }
            .category-table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
                font-family: Arial, sans-serif;
            }

            .category-table th,
            .category-table td {
                padding: 12px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }

            .category-table th {
                background-color: #f4f4f4;
                font-size: 1.1em;
                color: #333;
            }

            .category-table td {
                font-size: 1em;
                color: #555;
            }
            .category-table tr:hover {
                background-color: #f9f9f9;
            }

            .category-table .total-expenses {
                font-weight: bold;
                color: #333;
            }
        </style>
    </head>

    <div class="container mt-5">
        <div class="row">
            <!-- Total Users -->
            <a href="{{ route('admin.users') }}" class="col-md-4 text-decoration-none">
                <div class="dashboard-box">
                    <i style="color: #007BFF" class="fas fa-users icon"></i>
                    <p style="font-size: 15px ; color: black">Total Users</p>
                    <h1 class="details">{{ $userCount }}</h1>
                </div>
            </a>
            <!-- Total Categories -->
            <a href="{{ route('category.index') }}" class="col-md-4 text-decoration-none">
                <div class="dashboard-box">
                    <i style="color: #007BFF"  class="fas fa-th-list icon"></i>
                    <p style="font-size: 15px ; color: black">Total Categories</p>
                    <h1 class ="details">{{ $categoryCount }}</h1>
                </div>
            </a>
            <div class="col-md-4 text-decoration-none">
                <div class="dashboard-box">
                    <i style="color: #007BFF"  class="fas fa-chart-bar icon"></i>
                    <p style="font-size: 15px; color: black">Top Category Usage</p>
                    <h1 class ="details">{{ $categoryUsage->name }}</h1>
                </div>
            </div>
        </div>
        <table class="category-table">
            <thead>
            <tr>
                <th>Category</th>
                <th>Total Expenses</th>
            </tr>
            </thead>
            <tbody>
            @foreach($topCategoryUsage as $category)
                <tr class="category-row">
                    <td class="category-name">{{ $category->name }}</td>
                    <td class="total-expenses"> Rs.{{$category->expenses_sum_amount??0}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
