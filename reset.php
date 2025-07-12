<?php
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "owner";

    $email = trim($_POST['email']);
    $new_password = trim($_POST['new-password']);
    $confirm_password = trim($_POST['confirm-password']);

    if (empty($email) || empty($new_password) || empty($confirm_password)) {
        $error = "Semua field harus diisi!";
    } elseif ($new_password !== $confirm_password) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        try {
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                throw new Exception("Koneksi database gagal: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                $error = "Email tidak terdaftar!";
            } else {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                $update_stmt = $conn->prepare("UPDATE user SET password = ? WHERE email = ?");
                $update_stmt->bind_param("ss", $hashed_password, $email);

                if ($update_stmt->execute()) {
                    $success = "Password berhasil direset!";
                } else {
                    $error = "Gagal memperbarui password: " . $conn->error;
                }
                
                $update_stmt->close();
            }
            
            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
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
    <title>Reset Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f2f5;
        }

        .form-container {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            color: #1a73e8;
            margin-bottom: 1.5rem;
        }

        .alert {
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            border-radius: 4px;
        }

        .alert-error {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #4a5568;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }

        input:focus {
            outline: none;
            border-color: #1a73e8;
            box-shadow: 0 0 0 2px rgba(26,115,232,0.2);
        }

        button {
            width: 100%;
            padding: 0.75rem;
            background-color: #1a73e8;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        button:hover {
            background-color: #1557b0;
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .login-link a {
            color: #1a73e8;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .login-link a:hover {
            text-decoration: underline;
            color: #134b9a;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Reset Password</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php else: ?>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                        placeholder="Masukan Email"
                    >
                </div>

                <div class="input-group">
                    <label for="new-password">Password Baru</label>
                    <input 
                        type="password" 
                        id="new-password" 
                        name="new-password" 
                        required
                        minlength="8"
                        placeholder="Minimal 8 karakter"
                    >
                </div>

                <div class="input-group">
                    <label for="confirm-password">Konfirmasi Password Baru</label>
                    <input 
                        type="password" 
                        id="confirm-password" 
                        name="confirm-password" 
                        required
                        minlength="8"
                        placeholder="Harus sama dengan password baru"
                    >
                </div>

                <button type="submit">Reset Password</button>

                <div class="login-link">
                    <a href="login.php">Kembali ke Log In</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>