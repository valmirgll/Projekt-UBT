<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gunshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove'])) {
    $productId = $_POST['product_id'];
    $sql = "DELETE FROM cart WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $stmt->close();
}

$sql = "SELECT products.id, products.name, products.description, products.price, products.image, cart.quantity 
        FROM products 
        INNER JOIN cart ON products.id = cart.product_id";
$result = $conn->query($sql);

$cartItems = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="projekti.css">
</head>
<body style="background-image: url(backgroundp.jpg);">
    <button class="back"><a href="Drenica-GunShop.html">Home</a></button>
    
    <section class="cart">
        <h2 style="color: aliceblue;">Your Cart</h2>
        <div class="cart-grid">
            <?php if (!empty($cartItems)): ?>
                <?php foreach ($cartItems as $item): ?>
                    <div class="cart-card">
                        <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="height: 150px;">
                        <h3><?= htmlspecialchars($item['name']) ?></h3>
                        <p><?= htmlspecialchars($item['description']) ?></p>
                        <span>$<?= htmlspecialchars($item['price']) ?></span>
                        <p>Quantity: <?= htmlspecialchars($item['quantity']) ?></p>
                        <form method="post" action="cart.php">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($item['id']) ?>">
                            <button type="submit" name="remove" style="margin-top: 10px;">Remove</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: aliceblue;">Your cart is empty!</p>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>