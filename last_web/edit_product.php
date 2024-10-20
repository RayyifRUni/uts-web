<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

include('includes/db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $product = $result->fetch_assoc();
    } else {
        header('Location: index.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];

    if ($image) {
        $target = "assets/images/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $sql = "UPDATE products SET name='$name', description='$description', image='$image', price='$price' WHERE id = $id";
    } else {
        $sql = "UPDATE products SET name='$name', description='$description', price='$price' WHERE id = $id";
    }

    if ($conn->query($sql) === TRUE) {
        header('Location: index.php');
    } else {
        $error = "Gagal memperbarui produk.";
    }
}
?>
<!-- buat tampilan dan action button -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="includes/styles.css"> 
</head>
<body>
<div class="container">
    <h2>Edit Produk</h2>
    <form method="post" enctype="multipart/form-data" class="product-form">
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" placeholder="Nama Produk" required>
        <textarea name="description" placeholder="Deskripsi Produk" required><?php echo htmlspecialchars($product['description']); ?></textarea>
        <input type="file" name="image">
        <input type="number" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" placeholder="Harga" required>
        <button type="submit">Perbarui Produk</button>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </form>
</div>
</body>
</html>
