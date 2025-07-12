<?php
session_start();

define('DB_HOST', 'localhost');
define('DB_NAME', 'owner');
define('DB_USER', 'root');
define('DB_PASS', '');

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($old_password) || empty($new_password) || empty($confirm_password)) {
        $error = 'Semua field harus diisi!';
    } elseif ($new_password !== $confirm_password) {
        $error = 'Password baru dan konfirmasi password tidak cocok!';
    } else {
        try {
            $pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASS
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("SELECT password FROM user WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                $error = 'Username tidak ditemukan!';
            } elseif (!password_verify($old_password, $user['password'])) {
                $error = 'Password lama salah!';
            } else {
                $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("UPDATE user SET password = ? WHERE username = ?");
                $stmt->execute([$new_password_hash, $username]);
                $success = 'Password berhasil diubah!';
            }
        } catch (PDOException $e) {
            $error = 'Terjadi kesalahan database: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        h1 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        .sidebar {
            background-color: #2196F3;
            color: #fff;
            padding: 1em;
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            transition: all 0.3s ease;
            z-index: 100;
        }

        .sidebar ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .sidebar li {
            margin-bottom: 10px;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 8px 0;
        }

        .sidebar a:hover {
            text-decoration: underline;
        }

        .sidebar-toggle {
            font-size: 1.5em;
            color: #fff;
            cursor: pointer;
            display: none;
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 999;
            background: #2196F3;
            padding: 5px 10px;
            border-radius: 4px;    
        }
        
        @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.open {
            transform: translateX(0);
        }
         
        .content {
            margin-left: 0;
        }

        .sidebar-toggle {
            display: block;
        }
        }

        .container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
        }

        input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 0.75rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            margin-top: 1rem;
            padding: 0.5rem;
            border-radius: 4px;
            text-align: center;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>
<div class="sidebar-toggle" onclick="toggleSidebar()">&#9776;</div>

<div class="sidebar" id="sidebar">
    <h1>Menu</h1>
    <ul>
        <li><a href="dashboard.php">Beranda</a></li>
        <li><a href="settings.php">Pengaturan</a></li>
        <li><a href="login.php">Logout</a></li>
    </ul>
</div>

    <div class="container">
        <h2>Ganti Password</h2>
        
        <?php if ($error): ?>
            <div class="message error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="message success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="old_password">Password Lama</label>
                <input type="password" id="old_password" name="old_password" required>
            </div>
            
            <div class="form-group">
                <label for="new_password">Password Baru</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password Baru</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit">Ganti Password</button>
        </form>
    </div>
</body>
</html>