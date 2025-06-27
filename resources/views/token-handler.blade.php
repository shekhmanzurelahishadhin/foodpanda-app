<!DOCTYPE html>
<html>
<head>
    <title>Token Handler</title>
</head>
<body>
<script>
    window.addEventListener('message', event => {
        if (event.origin !== 'http://127.0.0.1:8000') return;

        const { action, ecommerceToken,foodpandaToken } = event.data;

        if (action === 'store_token') {
            localStorage.setItem('foodpanda_token', foodpandaToken);
            localStorage.setItem('ecommerce_token', ecommerceToken);
            console.log('Foodpanda token stored');
        }

        if (action === 'remove_token') {
            localStorage.removeItem('foodpanda_token');
            localStorage.removeItem('ecommerce_token');
            console.log('Foodpanda token removed');
        }
    });
</script>
</body>
</html>
