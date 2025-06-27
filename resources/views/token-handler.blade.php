<!DOCTYPE html>
<html>
<head>
    <title>Token Handler</title>
</head>
<body>
<script>
    window.addEventListener('message', event => {
        if (event.origin !== 'http://127.0.0.1:8000') return; // Only trust your ecommerce app

        const { action, token } = event.data;

        if (action === 'store_token') {
            localStorage.setItem('foodpanda_token', token);
            console.log('Foodpanda token stored');
        }

        if (action === 'remove_token') {
            localStorage.removeItem('foodpanda_token');
            console.log('Foodpanda token removed');
        }
    });
</script>
</body>
</html>
