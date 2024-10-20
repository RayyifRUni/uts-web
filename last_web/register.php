<?php
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if the username already exists
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $error = "Username sudah digunakan!";
    } else {
        // Insert new user into the database
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($sql) === TRUE) {
            header('Location: index.php');
            exit();
        } else {
            $error = "Terjadi kesalahan saat registrasi.";
        }
    }
}
?>

<!-- buat tampilan dan action button -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="includes/styles.css"> 
</head>
<body>
    <div class="register-container">
       
        <form method="post">
        <h2>Register</h2>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        </form>
        <p>Sudah punya akun? <a href="index.php">Login</a></p>
    </div>
</body>
</html>
