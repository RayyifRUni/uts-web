<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Web Application</title>
    <link rel="stylesheet" href="includes/styles.css">
</head>
<body>
<?php
session_start();
include('includes/db.php');

// Login process
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header('Location: index.php');
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}

// Logout process
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
}

//  tampilkan daftar produk
if (isset($_SESSION['username'])) {
    echo "<h2>Selamat datang, " . $_SESSION['username'] . "</h2>";
    
    echo '<a href="add_product.php">Tambah Produk</a>';
    
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    echo '<div class="products-container">';
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div>";
            echo "<img src='assets/images/" . $row['image'] . "' alt='" . $row['name'] . "'>";
            echo "<h3>" . $row['name'] . "</h3>";
            echo "<a href='product.php?id=" . $row['id'] . "'>Lihat detail</a>";
            echo "</div>";
        }
    } else {
        echo "Tidak ada produk.";
    }
    echo '</div>';
    echo '<a href="index.php?logout">Logout</a>';
} else {
  
    ?>

    
<!-- tampilan form login -->
    <form method="post">
    <h2>LOGIN</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
    </form>
    <p>Belum punya akun? <a href="register.php">Daftar</a></p>
    <?php
}
?>
</body>
</html>