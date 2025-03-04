<x-app-layout>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Calories Tracker</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        <style>
            .progress-circle {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                border: 8px solid #eee;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 20px;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
    <div style="background-color: #3260a8 ; color: white" class="card p-4 shadow-sm">
        <a  style="text-decoration: none; color: white" href="{{route('expenses.index')}}"> <h5 class="fw-bold">EXPENSES</h5> </a>
        <div class="d-flex align-items-center">
            <!-- Circular Progress -->
            <div class="progress-circle text-dark">
                @if($remaining <= -1)
{{--                    <p style="color: red">{{$budget->expenses_sum_amount}}</p>--}}
                <div style="color: #e47777">{{$remaining}}<br><span class="text-muted" style="font-size: 14px;">Remaining</span></div>
                @else
                <div style="color: green">{{$remaining}}<br><span class="text-muted" style="font-size: 14px;">Remaining</span></div>
{{--                    <p style="color: green">{{$budget->expenses_sum_amount}}</p>--}}
                @endif
            </div>
                <!-- Data Section -->
            <div class="ms-4">
                <p><i class="fas fa-flag text-dark"></i> <strong>Base Goal</strong> <br> {{$forecast??0 }}</p>
                <p><i class="fas fa-wallet text-warning"></i> <strong>Expenses</strong> <br> {{$monthExpenses??0}}</p>
                <p><i class="fas fa-bag-shopping text-primary"></i> <strong>Total</strong> <br> {{$monthTotal}}</p>
            </div>
        </div>
    </div>
{{--    div for contents--}}
    <div class="container mt-4 d-flex justify-content-center">
        <div class="card p-4 shadow-sm" onclick=" window.location.href='{{route('expenses.today')}}'">
            <h6 class="fw-bold">TODAY EXPENSES</h6>
            <p class="text-muted">Remaining = 1200</p>
            <div class="d-flex align-items-center" >
                <!-- Circular Progress -->
                <div class="progress-circle text-dark">
                    <div>{{$todayExpenses}}<br><span class="text-muted" style="font-size: 14px;">Remaining</span></div>
                </div>
                <!-- Data Section -->
                <div class="ms-4">
                    <p><i class="fas fa-flag text-dark"></i> <strong>Base Goal</strong> <br> {{$budget->limit??0 }}</p>
                    <p><i class="fas fa-wallet text-warning"></i> <strong>Expenses</strong> <br> {{$budget->expenses_sum_amount ??0}}</p>
                    <p><i class="fas fa-bag-shopping text-primary"></i> <strong>Total</strong> <br> {{$todayTotal??0}}</p>
                </div>
            </div>
        </div>
        <div style="margin-left: 20px" class="card p-4 shadow-sm" onclick=" window.location.href='{{route('expenses.yesterday')}}'">
            <h6 class="fw-bold">YESTERDAY'S EXPENSES</h6>
            <p class="text-muted">Remaining = 1200</p>
            <div class="d-flex align-items-center">
                <!-- Circular Progress -->
                <div class="progress-circle text-dark">
                    <div>{{$yesterdayExpenses??0}}<br><span class="text-muted" style="font-size: 14px;">Remaining</span></div>
                </div>
                <div class="ms-4">
                    <p><i class="fas fa-flag text-dark"></i> <strong>Base Goal</strong> <br> {{$budget->limit??0 }}</p>
                    <p><i class="fas fa-wallet text-warning"></i> <strong>Expenses</strong> <br> {{$budget->expenses_sum_amount ??0}}</p>
                    <p><i class="fas fa-bag-shopping text-primary"></i> <strong>Total</strong> <br> {{ $yesterdayTotal??0}}</p>
                </div>
            </div>
        </div>

        <div style="margin-left: 20px" class="card p-4 shadow-sm" onclick=" window.location.href='{{route('expenses.index')}}'">
        <h6 class="fw-bold"> EXPENSES FOR {{strtoupper(\Carbon\Carbon::now()->format('F'))}}</h6>
            <p class="text-muted">Remaining = 1200</p>

            <div class="d-flex align-items-center">
                <!-- Circular Progress -->
                <div class="progress-circle text-dark">
                    <div>{{$monthExpenses}}<br><span class="text-muted" style="font-size: 14px;">Remaining</span></div>
                </div>

                <!-- Data Section -->
                <div class="ms-4">
                    <p><i class="fas fa-flag text-dark"></i> <strong>Base Goal</strong> <br> {{$budget->limit??0 }}</p>
                    <p><i class="fas fa-wallet text-warning"></i> <strong>Expenses</strong> <br> {{$budget->expenses_sum_amount ?? 0}}</p>
                    <p><i class="fas fa-bag-shopping text-primary"></i> <strong>Total</strong> <br> {{$monthTotal??0}}</p>
                </div>
            </div>
        </div><div style="margin-left: 20px" class="card p-4 shadow-sm">
            <h6 class="fw-bold">LAST 7 DAY'S</h6>
            <p class="text-muted">Remaining = 1200</p>

            <div class="d-flex align-items-center">
                <!-- Circular Progress -->
                <div class="progress-circle text-dark">
                    <div>1200<br><span class="text-muted" style="font-size: 14px;">Remaining</span></div>
                </div>

                <!-- Data Section -->
                <div class="ms-4">
                    <p><i class="fas fa-flag text-dark"></i> <strong>Base Goal</strong> <br> {{$budget->limit??0 }}</p>
                    <p><i class="fas fa-wallet text-warning"></i> <strong>Expenses</strong> <br> {{$budget->expenses_sum_amount ??0}}</p>
                    <p><i class="fas fa-bag-shopping text-primary"></i> <strong>Total</strong> <br> 0</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
</x-app-layout>

