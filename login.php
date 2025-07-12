    <?php
    // ==================== DB CONFIG ====================
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "owner"; // Pastikan nama database sesuai

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Cek koneksi dan existensi database
    if ($conn->connect_error) {
        die("<div style='color: red; padding: 20px; border: 2px solid red; margin: 10px;'>
            Database connection failed: " . $conn->connect_error . "
            <br>Pastikan:
            <ol>
                <li>Database '{$dbname}' sudah dibuat</li>
                <li>User MySQL memiliki akses ke database</li>
            </ol>
            </div>");
    }

    // ==================== TABLE VALIDATION ====================
    $table_check = $conn->query("SHOW TABLES LIKE 'user'");
    if ($table_check->num_rows == 0) {
        die("<div style='color: red; padding: 20px; border: 2px solid red; margin: 10px;'>
            Table 'user' tidak ditemukan di database '{$dbname}'
            <br>Buat tabel dengan SQL berikut:
            <pre>
            CREATE TABLE user (
                id INT PRIMARY KEY AUTO_INCREMENT,
                username VARCHAR(50) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                email VARCHAR(100) UNIQUE NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
            </pre>
            </div>");
    }

    // ==================== LOGIN LOGIC ====================
    session_start();
    $error = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $input_username = $_POST['username'];
        $input_password = $_POST['password'];

        try {
            $query = "SELECT id, username, password FROM user WHERE username = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $input_username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                throw new Exception("Username tidak ditemukan!");
            }

            $user = $result->fetch_assoc();
            if (!password_verify($input_password, $user['password'])) {
                throw new Exception("Password salah!");
            }

            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
            exit();

        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Modern Login</title>
        <style>
            :root {
                --primary-color: #6366f1;
                --secondary-color: #4f46e5;
                --error-bg: #fee2e2;
                --error-text: #dc2626;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Inter', sans-serif;
            }

            body {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                background: #ffffff;
            }

            .login-container {
                background: #ffffff;
                padding: 2.5rem;
                border-radius: 1.5rem;
                box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
                width: 100%;
                max-width: 440px;
                border: 1px solid #e2e8f0;
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .login-container:hover {
                transform: translateY(-2px);
            }

            .login-header {
                text-align: center;
                margin-bottom: 2.5rem;
            }

            .login-header h1 {
                color: #1a73e8;
                font-size: 2.25rem;
                margin-bottom: 0.75rem;
                font-weight: 700;
            }

            .login-header p {
                color: #64748b;
                font-size: 1rem;
            }

            .form-group {
                margin-bottom: 1.75rem;
                position: relative;
            }

            .form-label {
                display: block;
                margin-bottom: 0.75rem;
                color: #334155;
                font-weight: 500;
                font-size: 0.875rem;
            }

            .form-input {
                width: 100%;
                padding: 1rem;
                border: 2px solid #e2e8f0;
                border-radius: 0.75rem;
                font-size: 1rem;
                transition: all 0.3s ease;
                background: #f8fafc;
            }

            .form-input:focus {
                outline: none;
                border-color: var(--primary-color);
                background: white;
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            }

            button {
                width: 100%;
                padding: 0.9rem;
                background: #1a73e8;
                color: white;
                border: none;
                border-radius: 6px;
                font-size: 1rem;
                font-weight: 600;
                cursor: pointer;
                transition: background 0.3s ease;
            }

            button:hover {
                background: #1557b0;
            }

            .error-message {
                background: var(--error-bg);
                color: var(--error-text);
                padding: 1rem;
                border-radius: 0.75rem;
                margin-bottom: 1.75rem;
                border: 1px solid #fca5a5;
                font-size: 0.875rem;
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            @media (max-width: 480px) {
                .login-container {
                    margin: 1.25rem;
                    padding: 1.75rem;
                    border-radius: 1rem;
                }
                
                .login-header h1 {
                    font-size: 1.875rem;
                }
            }

            .login-link {
                text-align: center;
                margin-top: 1.5rem;
                font-size: 0.9rem;
                color: #666;
            }

            .login-link a {
                color: #1a73e8;
                text-decoration: none;
                font-weight: 500;
            }

            .login-link a:hover {
                text-decoration: underline;
            }

        </style>
    </head>
    <body>
        <div class="login-container">
            <div class="login-header">
                <h1>Welcome Back</h1>
                <p>Sign in to continue to your account</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="form-group">
                    <label class="form-label" for="username">Username</label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        class="form-input"
                        placeholder="Enter your username"
                        value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input"
                        placeholder="Enter your password"
                        required
                    >
                </div>

                <button type="submit">Sign In</button>
            </form>

            <div class="login-link">
                <p>Don't have an account? <a href="register.php">Create account</a></p>
                <p>Forgot password? <a href="reset.php">Reset password</a></p>
            </div>
        </div>
    </body>
    </html>