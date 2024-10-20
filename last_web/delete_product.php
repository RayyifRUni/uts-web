<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

include('includes/db.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 

    // fungsi agar saat menghapus produk asset di image ikut kehapus
    $sql_get_image = "SELECT image FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql_get_image);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image_path = 'assets/images/' . $row['image'];

     
        if (file_exists($image_path)) {
            unlink($image_path);  
        }

        // Hapus data produk dari database
        $sql_delete = "DELETE FROM products WHERE id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param('i', $id);
        if ($stmt_delete->execute()) {
            header('Location: index.php');  
            exit();
        } else {
            echo "Gagal menghapus produk dari database.";
        }
    } else {
        echo "Produk tidak ditemukan.";
    }
}
?>
