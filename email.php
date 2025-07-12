<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "owner";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$error = "";
$success = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_email = htmlspecialchars($_POST['old_email']);
    $new_email = htmlspecialchars($_POST['new_email']);

    if (empty($old_email) || empty($new_email)) {
        $error = "Email lama dan baru wajib diisi!";
    } else {
        $sql = "UPDATE user SET email = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $new_email, $old_email);
        
        if ($stmt->execute()) {
            $success = "Email berhasil diubah: $old_email → $new_email";
            $success .= "<br>Baris terpengaruh: " . $stmt->affected_rows;
        } else {
            $error = "Error: " . $stmt->error;
        }
        
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Update Email Pengguna</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
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

        .sidebar h2 {
            margin-top: 0;
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
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
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
            font-weight: bold;
        }

        input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background: #1a73e8;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background 0.3s;
        }

        button:hover {
            background: #1557b0;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
        <h2>Update Email Pengguna</h2>
        
        <?php if ($error): ?>
            <div class="alert error"><?= $error ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert success"><?= $success ?></div>
        <?php endif; ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
                <label>Email Lama:</label>
                <input type="email" name="old_email" required>
            </div>
            
            <div class="form-group">
                <label>Email Baru:</label>
                <input type="email" name="new_email" required>
             </div>
            
            <button type="submit">Update Email</button>
        </form>
    </div>
</body>
</html>