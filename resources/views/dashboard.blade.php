<x-app-layout>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Calories Tracker</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <div class="card p-4 shadow-sm">
        <h5 class="fw-bold">EXPENSES</h5>
        <p class="text-muted">Remaining = 1200</p>
        <div class="d-flex align-items-center">
            <!-- Circular Progress -->
            <div class="progress-circle text-dark">
                <div>1200<br><span class="text-muted" style="font-size: 14px;">Remaining</span></div>
            </div>
            <!-- Data Section -->
            <div class="ms-4">
                <p><i class="fas fa-flag text-dark"></i> <strong>Base Goal</strong> <br> 1200</p>
                <p><i class="fas fa-utensils text-primary"></i> <strong>Food</strong> <br> 0</p>
                <p><i class="fas fa-fire text-warning"></i> <strong>Exercise</strong> <br> 0</p>
            </div>
        </div>
    </div>
{{--    div for contents--}}
    <div class="container mt-4 d-flex justify-content-center">
        <div class="card p-4 shadow-sm">
            <h5 class="fw-bold">TODAY EXPENSES</h5>
{{--            <p class="text-muted">Remaining = {{$budget->user->expenses->amount}}</p>--}}
            <div class="d-flex align-items-center">
                <!-- Circular Progress -->
                <div class="progress-circle text-dark">
                    <div>1200<br><span class="text-muted" style="font-size: 14px;">Remaining</span></div>
                </div>
                <!-- Data Section -->
                <div class="ms-4">
                    <p><i class="fas fa-flag text-dark"></i> <strong>Base Goal</strong> <br> 1200</p>
                    <p><i class="fas fa-utensils text-primary"></i> <strong>Food</strong> <br> 0</p>
                    <p><i class="fas fa-fire text-warning"></i> <strong>Exercise</strong> <br> 0</p>
                </div>
            </div>
        </div>
        <div style="margin-left: 20px" class="card p-4 shadow-sm">
            <h5 class="fw-bold">YESTERDAY'S EXPENSES</h5>
            <p class="text-muted">Remaining = 1200</p>
            <div class="d-flex align-items-center">
                <!-- Circular Progress -->
                <div class="progress-circle text-dark">
                    <div>1200<br><span class="text-muted" style="font-size: 14px;">Remaining</span></div>
                </div>

                <!-- Data Section -->
                <div class="ms-4">
                    <p><i class="fas fa-flag text-dark"></i> <strong>Base Goal</strong> <br> 1200</p>
                    <p><i class="fas fa-utensils text-primary"></i> <strong>Food</strong> <br> 0</p>
                    <p><i class="fas fa-fire text-warning"></i> <strong>Exercise</strong> <br> 0</p>
                </div>
            </div>
        </div>

        <div style="margin-left: 20px" class="card p-4 shadow-sm">
            <h5 class="fw-bold">LAST 7 DAY'S</h5>
            <p class="text-muted">Remaining = 1200</p>

            <div class="d-flex align-items-center">
                <!-- Circular Progress -->
                <div class="progress-circle text-dark">
                    <div>1200<br><span class="text-muted" style="font-size: 14px;">Remaining</span></div>
                </div>

                <!-- Data Section -->
                <div class="ms-4">
                    <p><i class="fas fa-flag text-dark"></i> <strong>Base Goal</strong> <br> 1200</p>
                    <p><i class="fas fa-utensils text-primary"></i> <strong>Food</strong> <br> 0</p>
                    <p><i class="fas fa-fire text-warning"></i> <strong>Exercise</strong> <br> 0</p>
                </div>
            </div>
        </div><div style="margin-left: 20px" class="card p-4 shadow-sm">
            <h5 class="fw-bold">LAST 7 DAY'S</h5>
            <p class="text-muted">Remaining = 1200</p>

            <div class="d-flex align-items-center">
                <!-- Circular Progress -->
                <div class="progress-circle text-dark">
                    <div>1200<br><span class="text-muted" style="font-size: 14px;">Remaining</span></div>
                </div>

                <!-- Data Section -->
                <div class="ms-4">
                    <p><i class="fas fa-flag text-dark"></i> <strong>Base Goal</strong> <br> 1200</p>
                    <p><i class="fas fa-utensils text-primary"></i> <strong>Food</strong> <br> 0</p>
                    <p><i class="fas fa-fire text-warning"></i> <strong>Exercise</strong> <br> 0</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
</x-app-layout>

