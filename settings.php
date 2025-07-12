<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Perhitungan Lahan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
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

        .content {
            margin-left: 250px;
            padding: 1em;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2em;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 1em;
            text-align: center;
            width: 1000%;
        }

        h1 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
        }


        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 400px;
            gap: 15px;
        }

        .form-group {
            width: 100%;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], 
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            max-width: 150px;
            font-size: 1em;
            margin-top : 10px;
            margin-bottom : 10px;
        }

        button:hover {
            background-color: #45a049;
        }

        #result {
            margin-top: 20px;
            font-weight: bold;
            font-size: 1.1em;
            text-align: center;
        }

        .success {
            color: #4CAF50;
            font-weight: bold;
            padding: 10px;
            background-color: #e8f5e9;
            border-radius: 4px;
            margin: 10px 0;
        }

        .error {
            color: #f44336;
            font-weight: bold;
            padding: 10px;
            background-color: #ffebee;
            border-radius: 4px;
            margin: 10px 0;
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
        select.form-control {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
                background-color: white;
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
        }
        select.form-control:focus {
                outline: none;
                border-color: #2196F3;
                box-shadow: 0 0 0 2px rgba(33,150,243,0.2);
        }

        input[type="file"] {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
                background-color: white;
        }
        
        /* Tambahan untuk membuat link di dalam tombol berwarna putih */
        .btn a {
            color: white !important;
            text-decoration: none;
            display: block;
            width: 100%;
            height: 100%;
        }
        
        .button-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
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
    
    <div class="content" id="content">
        <main>
            <div class="button-container">
            <div>
            <button class="btn"><a href="username.php">Reset Username</a></button>
            </div>
            <div>
                <button class="btn"><a href="email.php">Reset Email</a></button>
            </div>
            <div>
                <button class="btn"><a href="password.php">Reset Password</a></button>
            </div>
            </div>
                <footer>
                <div class="footer-bottom">
                    <p>&copy;PT. Graha Estetika Indonesia</p>
                </div>
            </footer>
        </main>
    </div>
        </main>
    </div>
    
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            sidebar.classList.toggle('open');
            
            if (sidebar.classList.contains('open')) {
                content.style.marginLeft = '250px';
            } else {
                content.style.marginLeft = '0';
            }
        }
    </script>
</body>
</html>