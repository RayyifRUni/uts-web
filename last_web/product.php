<?php
session_start();
include('includes/db.php');

// Mengecek apakah ada ID produk yang diterima dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Mengambil data produk dari database berdasarkan ID
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $product = $result->fetch_assoc();
    } else {
        echo "Produk tidak ditemukan.";
        exit();
    }
} else {
    echo "ID produk tidak diberikan.";
    exit();
}
?>

<!-- buat tampilan dan action button -->
<!DOCTYPE html>

<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link rel="stylesheet" href="includes/styles.css">  
</head>
<body>
    <div class="product-details">
        <h1>Detail Produk</h1>
        <?php if (isset($_SESSION['username'])): ?>
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <img src="assets/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            <p><strong>Deskripsi:</strong> <?php echo htmlspecialchars($product['description']); ?></p>
            <p><strong>Harga:</strong> <?php echo number_format($product['price'], 2, ',', '.'); ?> IDR</p>
            
            <a href="edit_product.php?id=<?php echo htmlspecialchars($product['id']); ?>">Edit Produk</a>
            <a href="delete_product.php?id=<?php echo htmlspecialchars($product['id']); ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">Hapus Produk</a>
        <?php else: ?>
            <p>Anda harus <a href="index.php">login</a> untuk melihat detail produk.</p>
        <?php endif; ?>
    </div>
</body>
</html>
