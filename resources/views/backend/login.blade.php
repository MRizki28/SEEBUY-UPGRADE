<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Page</title>
</head>

<body>
    <h1>Login</h1>

    <form id="login-form">
        @csrf
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit">Login</button>
    </form>
    <a href="{{ route('register.bazar') }}" class="">register</a>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            $('#login-form').submit(function(event) {
                event.preventDefault();
    
                var formData = {
                    email: $('#email').val(),
                    password: $('#password').val(),
                };
    
                $.ajax({
                    url: '{{ route('loginAdmin.bazar') }}',
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response);
                        localStorage.setItem('access_token', response.access_token);
                        if (response.data.email_verified_at) {
                            window.location.href = '/dashboard';
                        } else {
                            alert('Email not verified');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseJSON);
                        alert(xhr.responseJSON.message);
                    },
                });
    
            });
        });
    </script>
    

</body>

</html>
