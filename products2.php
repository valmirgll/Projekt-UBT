<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gunshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $productId = intval($_POST['product_id']);
    $stmt = $conn->prepare("INSERT INTO cart (product_id) VALUES (?)");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $stmt->close();
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
    <button class="back"><a href="dashboard.php">Home</a></button>
    
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
                        <form method="POST" action="">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                            <button type="submit" name="add_to_cart" style = "width: 100px; background-color: orange; border: none; height: 40px">Add to Cart</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endforeach; ?>

    <abbr title="Go to top button">
        <div class = "gotopbtn"><a href="#top">Top</a></div>
    </abbr>

    <style>
        .gotopbtn {
            width: 60px;
            height: 60px;
            border: none;
            position: fixed;
            bottom: 50px;
            right: 30px;
            display: none;
            background-color: orange;
            border-radius: 5px;
            align-items: center;
            justify-content: center;         
        }

        .gotopbtn a {
            color: white;
            text-decoration: none;
        }

        .gotopbtn-special {
            display: flex;
        }

        html {
            scroll-behavior: smooth;
        }
    </style>
    <script>
        const gotopbtn = document.querySelector('.gotopbtn');
        window.onscroll = function () {
            if(document.body.scroll > 200 || document.documentElement.scrollTop > 200){
                gotopbtn.classList.add('gotopbtn-special');
            }else{
                gotopbtn.classList.remove('gotopbtn-special');
                
            }
        }
    </script>
</body>
</html>
