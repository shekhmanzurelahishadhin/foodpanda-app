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
            background: linear-gradient(135deg, #f0fdfa, #ccfbf1);
        }

        .card {
            background-color: #ffffff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
            transition: all 0.3s ease;
        }

        .card h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #0f766e;
            font-size: 24px;
            letter-spacing: 1px;
        }

        .card input {
            width: 93%;
            padding: 14px;
            margin: 12px 0;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 16px;
            transition: border 0.3s;
        }

        .card input:focus {
            border-color: #14b8a6;
            outline: none;
            box-shadow: 0 0 0 2px rgba(20, 184, 166, 0.2);
        }

        .card button {
            width: 100%;
            padding: 14px;
            background-color: #14b8a6;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .card button:hover {
            background-color: #0f766e;
        }

        .error {
            color: #ef4444;
            margin-top: 5px;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Foodpanda Login</h2>
    <div class="error" id="error-message"></div>
    <input type="email" id="email" placeholder="Email" />
    <input type="password" id="password" placeholder="Password" />
    <button id="loginBtn" onclick="loginToBothApps()">Login</button>
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
            document.getElementById('loginBtn').textContent = 'Loading...';
            const resA = await fetch('http://localhost:8000/api/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password })
            });

            const dataA = await resA.json();
            if (!resA.ok) {
                throw new Error(dataA.message || 'Ecommerce login failed');
            }
            localStorage.setItem('ecommerce_token', dataA.token);
            ;

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
            await storeEcommerceToken(dataA.token, dataB.token)
            document.getElementById('loginBtn').textContent = 'Login';
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
                setTimeout(() => document.body.removeChild(iframe), 1000);
            };
        });
    }

    async function storeEcommerceToken(ecommerceToken,foodpandaToken) {
        await sendMessageToEcommerce({ action: 'store_token', ecommerceToken, foodpandaToken });
    }
</script>
</body>
</html>

