<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Auth | Login & Register</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .auth-container {
            background: #fff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        label {
            font-weight: 600;
            display: block;
            margin-top: 12px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .error {
            color: red;
            margin-bottom: 10px;
            text-align: center;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .toggle-link {
            text-align: center;
            margin-top: 15px;
        }

        .toggle-link a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }

        .toggle-link a:hover {
            text-decoration: underline;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>

<div class="auth-container">
    <!-- Login Form -->
    <div id="login-form">
        <h2>Login</h2>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf
            <label for="email">Email</label>
            <input type="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" required>

            <button type="submit">Log In</button>
        </form>

        <div class="toggle-link">
            <p>Don't have an account? <a onclick="toggleForms()">Register here</a></p>
        </div>
    </div>

    <!-- Register Form -->
    <div id="register-form" class="hidden">
        <h2>Register</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <label for="name">Name</label>
            <input type="text" name="name" required>

            <label for="email">Email</label>
            <input type="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" required>

            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" required>

            <button type="submit">Register</button>
        </form>

        <div class="toggle-link">
            <p>Already have an account? <a onclick="toggleForms()">Back to login</a></p>
        </div>
    </div>
</div>

<script>
    function toggleForms() {
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');
        loginForm.classList.toggle('hidden');
        registerForm.classList.toggle('hidden');
    }
</script>

</body>
</html>
