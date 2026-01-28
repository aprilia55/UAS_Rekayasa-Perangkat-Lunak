<?php
session_start();
include "../config/koneksi.php";

$error = null;

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // QUERY LOGIN
    $sql = "SELECT * FROM users WHERE username='$user' AND password='$pass'";
    $login = mysqli_query($koneksi, $sql);

    if ($login && mysqli_num_rows($login) > 0) {
        $_SESSION['login'] = true;
        header("Location: ../dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login | Rental Kendaraan</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
        }

        .login-box {
            background: white;
            width: 360px;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            text-align: center;
        }

        .login-box h2 {
            margin-bottom: 10px;
            color: #1e3a8a;
        }

        .login-box p {
            margin-bottom: 25px;
            color: #666;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #2563eb;
            border: none;
            color: white;
            font-size: 15px;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background: #1e40af;
        }

        .error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Login</h2>
    <p>Sistem Informasi Sewa Kendaraan</p>

    <?php if (isset($error)) { ?>
        <div class="error"><?= $error ?></div>
    <?php } ?>

    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
</div>

</body>
</html>
