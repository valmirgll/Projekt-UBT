<?php
session_start();
include_once "db.php";

class ProductManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addProduct($name, $description, $price, $category, $image) {
        $sql = "INSERT INTO products (name, description, price, category, image) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssiss", $name, $description, $price, $category, $image);
        $stmt->execute();
    }

    public function deleteProduct($id) {
        $sql = "DELETE FROM products WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    public function editProduct($id, $name, $description, $price, $category, $image) {
        $sql = "UPDATE products SET name=?, description=?, price=?, category=?, image=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssissi", $name, $description, $price, $category, $image, $id);
        $stmt->execute();
    }

    public function getAllProducts() {
        $sql = "SELECT * FROM products";
        $result = $this->conn->query($sql);
        $products = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }

    public function getAllOrders() {
        $sql = "SELECT orders.id, orders.quantity, products.name, products.price, users.name 
                FROM orders 
                INNER JOIN products ON orders.product_id = products.id 
                INNER JOIN users ON orders.user_id = users.id";
        $result = $this->conn->query($sql);
        $orders = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
        }
        return $orders;
    }
}

class MessageManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllMessages() {
        $sql = "SELECT * FROM messages";
        $result = $this->conn->query($sql);
        $messages = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $messages[] = $row;
            }
        }
        return $messages;
    }
}

$db = new Database();
$conn = $db->conn;
$productManager = new ProductManager($conn);
$messageManager = new MessageManager($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_product'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $image = $_POST['image'];
        $productManager->addProduct($name, $description, $price, $category, $image);
    } elseif (isset($_POST['delete_product'])) {
        $id = $_POST['id'];
        $productManager->deleteProduct($id);
    } elseif (isset($_POST['edit_product'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $image = $_POST['image'];
        $productManager->editProduct($id, $name, $description, $price, $category, $image);
    }
}

$products = $productManager->getAllProducts();
$messages = $messageManager->getAllMessages();
$orders = $productManager->getAllOrders();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>

        <section>
            <h2>Add Product</h2>
            <form method="POST" action="admin.php">
                <input type="hidden" name="add_product">
                <input type="text" name="name" placeholder="Product Name" required>
                <textarea name="description" placeholder="Product Description" required></textarea>
                <input type="number" name="price" placeholder="Product Price" required>
                <input type="text" name="category" placeholder="Product Category" required>
                <input type="text" name="image" placeholder="Image URL" required>
                <button type="submit">Add Product</button>
            </form>
        </section>

        <section>
            <h2>Manage Products</h2>
            <?php foreach ($products as $product): ?>
                <div class="message">
                    <form method="POST" action="admin.php" style="display: inline;">
                        <input type="hidden" name="delete_product">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">
                        <button type="submit">Delete</button>
                    </form>
                    <form method="POST" action="admin.php" style="display: inline;">
                        <input type="hidden" name="edit_product">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">
                        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
                        <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea>
                        <input type="number" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>
                        <input type="text" name="category" value="<?= htmlspecialchars($product['category']) ?>" required>
                        <input type="text" name="image" value="<?= htmlspecialchars($product['image']) ?>" required>
                        <button type="submit">Edit</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </section>

        <section>
            <h2>View Messages</h2>
            <?php if (count($messages) > 0): ?>
                <?php foreach ($messages as $message): ?>
                    <div class="message">
                        <h3><?= htmlspecialchars($message['name']) ?> (<?= htmlspecialchars($message['email']) ?>)</h3>
                        <p><?= htmlspecialchars($message['message']) ?></p>
                        <?php if ($message['photo']): ?>
                            <img src="uploads/<?= htmlspecialchars($message['photo']) ?>" alt="Attached Photo">
                        <?php endif; ?>
                        <small>Submitted at: <?= htmlspecialchars($message['submitted_at']) ?></small>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No messages found.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2>View Orders</h2>
            <?php if (count($orders) > 0): ?>
                <?php foreach ($orders as $order): ?>
                    <div class="order">
                        <h3>Order ID: <?= htmlspecialchars($order['id']) ?></h3>
                        <p>Purchased by: <?= htmlspecialchars($order['name']) ?></p>
                        <p>Quantity: <?= htmlspecialchars($order['quantity']) ?></p>
                        <p>Price: $<?= htmlspecialchars($order['price']) ?></p>
                        
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No orders found.</p>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>
