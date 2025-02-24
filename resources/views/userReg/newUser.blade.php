<h1>Registration</h1>
<form action="{{route('validate.user')}}" method="POST" id="validateForm">
    @csrf
    <input type="hidden" name="user_logged" value="{{ Auth::id() }}">
    <div style="display: flex ; flex-direction: row ; gap:5px">
        <div class="mb-1">
            <label for="first_name" class="label_input">First Name</label> <br>
            <input type="text" class="form_input" name="first_name" id="first_name" value="{{old('first_name',$firstName??'')}}">
        </div>
        <div class="mb-1">
            <label for="last_name" class="label_input">Last Name</label> <br>
            <input type="text" class="form_input" name="last_name" value="{{old('last_name',$lastName??'')}}" id="last_name">
        </div>
    </div>
    <div style="display: flex; gap: 20px;">
        @error('first_name')
        <div style="color: red">{{ $message }}</div>
        @enderror
        @error('last_name')
        <div style="color: red">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-1">
        <label for="username" class="label_input">User Name</label> <br>
        <input type="text" style="width: 607px" class="form_input" name="username" id="username" value="{{old('username',$username ?? '')}}">
    </div>
    @error('username')
    <div style="color: red">{{ $message }}</div>
    @enderror
    <div class="mb-1">
        <label for="email" class="label_input">Email</label> <br>
        <input type="email" style="width: 607px" class="form_input" name="email" value="{{ old('email', $email ?? '') }} "id="email">
    </div>
    @error('email')
    <div style="color: red">{{ $message }}</div>
    @enderror
    <div class="mb-1">
        <label for="password" class="label_input">Password</label> <br>
        <input type="password" style="width: 607px" class="form_input" value="{{old('password',$password??'')}}" name= "password" id="password">
    </div>
    @error('password')
    <div style="color: red">{{ $message }}</div>
    @enderror

    @if(session('completed_user_credential'))
        <div id="allowedButtons">
            <button id="prevBtn" >Previous</button>
            <button id="nextBtn" type="button">Next</button>
        </div>
    @else
        <button type="reset">Reset</button>
        <button type="submit" onclick="validateForm()">Submit</button>
    @endif
</form>
