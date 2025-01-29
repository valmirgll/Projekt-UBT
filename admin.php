<?php
session_start();


include_once "db.php";
$db = new Database();
$conn = $db->conn;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_product'])) {
        
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $image = $_POST['image'];

        $sql = "INSERT INTO products (name, description, price, category, image) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiss", $name, $description, $price, $category, $image);
        $stmt->execute();
    } elseif (isset($_POST['delete_product'])) {
        
        $id = $_POST['id'];
        $sql = "DELETE FROM products WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    } elseif (isset($_POST['edit_product'])) {
        
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $image = $_POST['image'];

        $sql = "UPDATE products SET name=?, description=?, price=?, category=?, image=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssissi", $name, $description, $price, $category, $image, $id);
        $stmt->execute();
    }
}


$sql = "SELECT * FROM products";
$result = $conn->query($sql);
$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="projekti.css">
</head>
<body>
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
            <div>
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
</body>
</html>
