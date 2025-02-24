
    <div class="user-data-container" style="border: 1px solid #333; padding: 15px; margin-top: 20px; border-radius: 5px;">
    <h3>Stored User Data</h3>
{{--    <p><strong>First Name:</strong> {{ session('user_data.first_name') }}</p>--}}
{{--    <p><strong>Last Name:</strong> {{ session('user_data.last_name') }}</p>--}}
{{--    <p><strong>Username:</strong> {{ session('user_data.username') }}</p>--}}
{{--    <p><strong>Email:</strong> {{ session('user_data.email') }}</p>--}}
{{--    <p><strong>Password:</strong> {{ session('user_data.password') }}</p>  <!-- For security, avoid showing plaintext passwords -->--}}
        <h3>Stored Income Data</h3>
        <p><strong>Amount:</strong> {{ session('income_data.amount') }}</p>
        <p><strong>Income Date:</strong> {{ session('income_data.income_date') }}</p>
        <p><strong>Month:</strong> {{ session('income_data.month') }}</p>
        <p><strong>Year:</strong> {{ session('income_data.year') }}</p>
    </div>
    <div id="allowedButtons" >
        <button id="prevBtn" >Previous</button>
        <button id="nextBtn" >Next</button>
    </div>

