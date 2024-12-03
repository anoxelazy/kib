<?php
session_start();  // เริ่ม session เพื่อเข้าถึงข้อมูล session

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
if (!isset($_SESSION['username'])) {
    header("Location: login.php");  // ถ้ายังไม่ได้ล็อกอินจะถูกเปลี่ยนเส้นทางไปที่หน้า login
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiz_db";  // ชื่อฐานข้อมูลที่คุณสร้างไว้

// สร้างการเชื่อมต่อกับฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับคะแนนที่ได้จากฟอร์ม
$score = $_POST['score']; 
$user = $_SESSION['username'];  // รับชื่อผู้ใช้จาก session

// บันทึกคะแนนลงในฐานข้อมูล
$query = "INSERT INTO scores (username, score) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $user, $score);  // 's' คือ string และ 'i' คือ integer
$stmt->execute();

// แสดงคะแนนที่ได้
echo "<h2>ผลคะแนนของคุณ</h2>";
echo "<p>คุณทำคะแนนได้: $score คะแนน</p>";

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>

<p><a href="home.php">กลับไปที่หน้าหลัก</a></p>  <!-- ลิงก์กลับไปที่หน้าหลัก -->
