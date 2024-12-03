<?php
session_start();

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost"; // ชื่อโฮสต์ของฐานข้อมูล (อาจเป็น localhost หรือ IP)
$username = "root"; // ชื่อผู้ใช้ฐานข้อมูล
$password = ""; // รหัสผ่านฐานข้อมูล
$dbname = "register_db"; // ชื่อฐานข้อมูล

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึงข้อมูลโปรไฟล์จากฐานข้อมูล
$user = $_SESSION['username']; // ชื่อผู้ใช้งานที่ล็อกอิน
$query = "SELECT username, score, grade, time, status FROM users WHERE username = ?";
$stmt = $conn->prepare($query);

// ตรวจสอบว่าคำสั่ง SQL เตรียมสำเร็จหรือไม่
if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
}

$stmt->bind_param("s", $user);
$stmt->execute();
$stmt->bind_result($username, $score, $grade, $time, $status);
$stmt->fetch();
$stmt->close();

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        
        body {
            background-image: url('pic/sunset-6226244.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
        }

        .container {
            z-index: 1;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.8); 
        }
        .profile-card {
            margin-top: 10%;
            padding: 2rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card profile-card text-center">
            <div class="card-body">
                <h2 class="card-title text-primary">Profile Information</h2>
                <p class="card-text mt-3"><strong>Full Name:</strong> <?php echo htmlspecialchars($username); ?></p>
                <p class="card-text"><strong>Status:</strong> <?php echo htmlspecialchars($status); ?></p>
                <p class="card-text"><strong>Score:</strong> <?php echo htmlspecialchars($score); ?></p>
                <p class="card-text"><strong>Grade:</strong> <?php echo htmlspecialchars($grade); ?></p>
                <p class="card-text"><strong>Time:</strong> <?php echo htmlspecialchars($time); ?></p>  

                <div class="mt-4">
                    <a href="home.php" class="btn btn-primary">Back to Home</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
