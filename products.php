<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gunshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[$row['category']][] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="projekti.css">
</head>
<body style="background-image: url(backgroundp.jpg);">
    <button class="back"><a href="Drenica-GunShop.html">Home</a></button>
    
    <?php foreach ($products as $category => $items): ?>
        <section class="products">
            <h2 style="color: aliceblue;"> <?= htmlspecialchars($category) ?> </h2>
            <div class="product-grid">
                <?php foreach ($items as $product): ?>
                    <div class="product-card">
                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="height: 150px;">
                        <h3><?= htmlspecialchars($product['name']) ?></h3>
                        <p><?= htmlspecialchars($product['description']) ?></p>
                        <span>$<?= htmlspecialchars($product['price']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endforeach; ?>
</body>
</html>
