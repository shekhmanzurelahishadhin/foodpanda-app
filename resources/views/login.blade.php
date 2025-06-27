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

<div class="card">
    <h2>Ecommerce Login</h2>
    <div class="error" id="error-message"></div>
    <input type="email" id="email" placeholder="Email" />
    <input type="password" id="password" placeholder="Password" />
    <button onclick="loginToBothApps()">Login</button>
</div>
<script>
    const token = localStorage.getItem('foodpanda_token');
    if (token) {
        // Optionally verify token validity via API or just redirect
        window.location.href = '/dashboard';
    }
    async function loginToBothApps() {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const errorDiv = document.getElementById('error-message');
        errorDiv.textContent = '';

        try {
            const resA = await fetch('http://localhost:8000/api/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password })
            });

            const dataA = await resA.json();
            if (!resA.ok) {
                throw new Error(dataA.message || 'Ecommerce login failed');
            }

            await storeEcommerceToken(dataA.token);

            const resB = await fetch('http://localhost:8001/api/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password })
            });

            const dataB = await resB.json();
            if (!resB.ok) {
                throw new Error(dataB.message || 'Ecommerce login failed');
            }

            localStorage.setItem('foodpanda_token', dataB.token);

            window.location.href = '/dashboard';
        } catch (err) {
            errorDiv.textContent = err.message;
        }
    }

    function sendMessageToEcommerce(message) {
        return new Promise((resolve) => {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            iframe.src = 'http://127.0.0.1:8000/token-handler';
            document.body.appendChild(iframe);

            iframe.onload = () => {
                iframe.contentWindow.postMessage(message, 'http://127.0.0.1:8000');
                resolve();
                // Optionally remove iframe after a delay to avoid race conditions:
                setTimeout(() => document.body.removeChild(iframe), 1000);
            };
        });
    }

    async function storeEcommerceToken(token) {
        await sendMessageToEcommerce({ action: 'store_token', token });
    }
</script>
</body>
</html>

