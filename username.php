<?php
session_start();
$error = '';
$success = '';

// Koneksi database
$host = 'localhost';
$dbname = 'owner';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    $error = "Koneksi database gagal: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_username = $_POST['current_username'] ?? '';
    $new_username = $_POST['new_username'] ?? '';
    $confirm_username = $_POST['confirm_username'] ?? '';
    $user_password = $_POST['password'] ?? '';

    // Validasi input
    if (empty($current_username) || empty($new_username) || empty($confirm_username) || empty($user_password)) {
        $error = 'Semua field harus diisi!';
    } elseif ($new_username !== $confirm_username) {
        $error = 'Username baru dan konfirmasi username tidak cocok!';
    } else {
        try {
            // Cek user dan password
            $stmt = $conn->prepare("SELECT * FROM user WHERE username = :current_username");
            $stmt->bindParam(':current_username', $current_username);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (password_verify($user_password, $user['password'])) {
                    // Update username
                    $updateStmt = $conn->prepare("UPDATE user SET username = :new_username WHERE username = :current_username");
                    $updateStmt->bindParam(':new_username', $new_username);
                    $updateStmt->bindParam(':current_username', $current_username);
                    
                    if ($updateStmt->execute()) {
                        $success = 'Username berhasil diubah!';
                    }
                } else {
                    $error = 'Password salah!';
                }
            } else {
                $error = 'Username tidak ditemukan!';
            }
        } catch(PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Username</title>
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

        .reset-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 350px;
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

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            margin-top: 15px;
            padding: 10px;
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

    <div class="reset-container">
        <h2>Reset Username</h2>
        
        <?php if ($error): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="message success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST" action="Username.php">
            <div class="form-group">
                <label>Username Saat Ini</label>
                <input type="text" name="current_username" required>
            </div>
            
            <div class="form-group">
                <label>Username Baru</label>
                <input type="text" name="new_username" required>
            </div>
            
            <div class="form-group">
                <label>Konfirmasi Username Baru</label>
                <input type="text" name="confirm_username" required>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            
            <button type="submit">Reset Username</button>
        </form>
    </div>
</body>
</html>