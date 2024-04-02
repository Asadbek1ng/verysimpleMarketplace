<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Marketplace</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px;
        }

        .item {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px;
            padding: 20px;
            width: 300px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .item:hover {
            transform: translateY(-5px);
        }

        .item img {
            border-radius: 5px;
            max-width: 100%;
        }

        .item h2 {
            color: #333;
            margin-top: 20px;
        }

        .item p {
            color: #666;
        }

        .cart {
            position: fixed;
            top: 10px;
            right: 20px;
            background-color: #fffdff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }

        .cart h2 {
            margin-top: 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>Simple Marketplace</h1>
    </header>
    <div class="container">
        <?php
        $db_host = 'localhost';
        $db_user = 'root';
        $db_password = 'root';
        $db_name = 'market';
        $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM productList";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="item">';
                echo '<img src="data:image/jpeg;base64,'.base64_encode($row['productImage']).'" alt="'.$row['productName'].'">';
                echo '<h2>'.$row['productName'].'</h2>';
                echo '<p>'.$row['productDescription'].'</p>';
                echo '<button onclick="addToCart(\''.$row['productName'].'\')">Add to Cart</button>';
                echo '</div>';
            }
        } else {
            echo "No products found";
        }

        mysqli_close($conn);
        ?>
    </div>
    <div class="cart" id="cart">
        <h2>Shopping Cart</h2>
        <ul id="cart-items"></ul>
    </div>

    <script>
        let cart = [];

        function addToCart(productName) {
            cart.push(productName);
            updateCart();
        }

        function updateCart() {
            const cartElement = document.getElementById('cart-items');
            cartElement.innerHTML = ''; 

            cart.forEach(item => {
                const li = document.createElement('li');
                li.textContent = item;
                cartElement.appendChild(li);
            });
        }
    </script>

</body>
</html>
