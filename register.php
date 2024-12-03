<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register_db";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับค่าจากฟอร์ม
    $username = $_POST['username'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $status = $_POST['status'];

    // สร้างคำสั่ง SQL เพื่อตรวจสอบว่า username นี้มีอยู่ในฐานข้อมูลแล้วหรือไม่
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Username นี้ถูกใช้งานแล้ว";
        } else {
            // แฮชพาสเวิร์ดก่อนที่จะบันทึก
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // สร้างคำสั่ง SQL สำหรับการแทรกข้อมูล
            $insert_query = "INSERT INTO users (username, lastname, password, status) 
                             VALUES (?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_query);
            if ($insert_stmt) {
                // ใช้คำสั่ง SQL สำหรับแทรกข้อมูล
                $insert_stmt->bind_param("ssss", $username, $lastname, $hashed_password, $status);
                if ($insert_stmt->execute()) {
                    // ถ้าการสมัครสำเร็จให้ไปที่หน้าล็อกอิน
                    header("Location: login.php");
                    exit;
                } else {
                    $error = "เกิดข้อผิดพลาดในการสมัครสมาชิก";
                }
            } else {
                $error = "ไม่สามารถเตรียมคำสั่ง SQL สำหรับการแทรกข้อมูลได้";
            }
        }
    } else {
        $error = "ไม่สามารถตรวจสอบข้อมูลจากฐานข้อมูลได้";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

        .header {
            font-size: 20px;
            color: #004080; 
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
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
    <div class="container d-flex justify-content-center align-items-center">
        <div class="register-container col-md-6">
            <h2 class="text-center text-primary mb-4">สมัครสมาชิก</h2>
            <form method="POST" action="register.php">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">Lastname</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="employee">พนักงาน</option>
                        <option value="head">หัวหน้า</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">สมัครสมาชิก</button>
                <?php if (isset($error)) echo "<div class='alert alert-danger mt-3'>$error</div>"; ?>
            </form>
            <p class="mt-4 text-center">มีบัญชีแล้ว? <a href="login.php">เข้าสู่ระบบ</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
