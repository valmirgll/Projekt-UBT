<?php
session_start();

class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "gunshop";
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function prepareStatement($sql) {
        return $this->conn->prepare($sql);
    }

    public function query($sql) {
        return $this->conn->query($sql);
    }

    public function close() {
        $this->conn->close();
    }
}

class Cart {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function removeItem($productId) {
        $sql = "DELETE FROM cart WHERE product_id = ?";
        $stmt = $this->db->prepareStatement($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $stmt->close();
    }

    public function buyNow($productId, $userId) {
        $sql = "INSERT INTO orders (product_id, user_id, quantity) SELECT product_id, ?, quantity FROM cart WHERE product_id = ?";
        $stmt = $this->db->prepareStatement($sql);
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();

        $this->removeItem($productId);
    }

    public function getCartItems() {
        $sql = "SELECT products.id, products.name, products.description, products.price, products.image, cart.quantity 
                FROM products 
                INNER JOIN cart ON products.id = cart.product_id";
        $result = $this->db->query($sql);

        $cartItems = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cartItems[] = $row;
            }
        }

        return $cartItems;
    }
}

$db = new Database();
$cart = new Cart($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = $_POST['product_id'];
    $userId = $_SESSION['user_id']; // Assuming you store user ID in the session
    if (isset($_POST['remove'])) {
        $cart->removeItem($productId);
    } elseif (isset($_POST['buy_now'])) {
        $cart->buyNow($productId, $userId);
    }
}

$cartItems = $cart->getCartItems();
$db->close();
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
    <button class="back"><a href="dashboard.php">Home</a></button>
    
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
                            <button type="submit" name="buy_now" style="margin-top: 10px;">Buy Now</button>
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
