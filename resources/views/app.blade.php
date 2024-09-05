<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Styles CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 400px;
            max-width: 90%;
        }
        
        .logo {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 150px;
        }
        
        .form-input {
            margin-top: 10px;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        
        .btn {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            width: 100%;
            text-align: center;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        
        .btn:hover {
            background-color: #45a049;
        }
        
        .links {
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
        }
        
        .links a {
            color: #4caf50;
            text-decoration: none;
            font-size: 14px;
        }
        
        .links a:hover {
            text-decoration: underline;
        }
        
        .google-btn {
            margin-top: 10px;
            background: green;
            color: #ffffff;
            padding: 10px;
            border-radius: 7px;
            text-align: center;
            text-decoration: none;
            display: block;
        }
        
        .google-btn:hover {
            background: #006400;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">
            <!-- Remplacez cet espace par le logo -->
        </div>
        <!-- Messages de validation ou d'erreur -->
        <div class="validation-errors">
            <!-- Message de statut -->
        </div>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required autofocus>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-input" required>
            </div>
            <div>
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me</label>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <div class="links">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Forgot your password?</a>
            @endif
            <a href="{{ url('auth/google') }}" class="google-btn">Google Login</a>
        </div>
    </div>
</body>
</html>
