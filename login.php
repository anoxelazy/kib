<?php include('server.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #eaf3fa;
            font-family: "Arial", sans-serif;
        }

        .container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background-color: #ffffff;
            padding: 30px;
            width: 400px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .header img {
            width: 150px;
            height: auto;
            display: block;
            margin: 0 auto 20px auto;
        }

        .form-label {
            color: #555555; 
        }

        .btn-primary {
            background-color: #007bff; 
            border: none;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .register-link a {
            color: #004080;
            font-weight: bold;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="login-box">
            <div class="header">
                <img src="pic/334576_logo_20230927155032.webp" alt="KU Logo">
            </div>
            <form method="POST" action="login.php">
                <div class="mb-3">
                    <label for="username" class="form-label">ชื่อผู้ใช้:</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">รหัสผ่าน:</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">เข้าสู่ระบบ</button>
                <?php if (isset($error)) echo "<p class='text-danger mt-3 text-center'>$error</p>"; ?>
            </form>
            <div class="register-link">
                <p>ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
