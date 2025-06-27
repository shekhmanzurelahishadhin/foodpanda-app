<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Foodpanda Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-form {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .login-form h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .login-form input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        .login-form button {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 15px;
            transition: background-color 0.3s ease;
        }

        .login-form button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<form method="POST" action="/login" class="login-form">
    @csrf
    <h2>Login to Foodpanda</h2>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>

</body>
</html>
