<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $target = "assets/images/" . basename($image);

    // Simpan data produk
    $sql = "INSERT INTO products (name, description, image, price) VALUES ('$name', '$description', '$image', '$price')";

    if ($conn->query($sql) === TRUE) {
        // Pindahkan file gambar setelah data produk berhasil disimpan
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            header('Location: index.php');
            exit();
        } else {
            // Jika gagal memindahkan file
            $error = "Gagal mengupload gambar.";
        }
    } else {
        $error = "Gagal menambahkan produk: " . $conn->error;
    }
}
?>
<!-- buat tampilan dan action button -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="includes/styles.css"> <!-- Link external CSS file -->
</head>
<body>
<div class="container">
    <h2>Tambahkan Produk</h2>
    <form method="post" enctype="multipart/form-data" class="product-form">
        <input type="text" name="name" placeholder="Nama Produk" required>
        <textarea name="description" placeholder="Deskripsi Produk" required></textarea>
        <input type="file" name="image" required>
        <input type="number" name="price" placeholder="Harga" required>
        <button type="submit">Tambahkan Produk</button>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </form>
</div>

</body>
</html>
