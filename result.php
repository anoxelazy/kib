<?php
session_start();

// เช็คว่า session มีข้อมูลคะแนนหรือไม่
if (!isset($_SESSION['score']) || !isset($_SESSION['start_time'])) {
    echo "Error: Score or start time not found!";
    exit();
}

$score = $_SESSION['score'];
$start_time = $_SESSION['start_time'];
$end_time = time(); // เวลาที่ทำข้อสอบเสร็จสิ้น

// คำนวณเวลาที่ใช้ในการทำข้อสอบ (ในหน่วยวินาที)
$time_taken = $end_time - $start_time;
$minutes = floor($time_taken / 60);
$seconds = $time_taken % 60;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
        }
        .navbar {
            background-color: #004a99;
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Kobelco Millcon Steel Co., Ltd.</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h4>Exam Result</h4>
        <p>Congratulations, <?php echo htmlspecialchars($_SESSION['username']) . " " . htmlspecialchars($_SESSION['lastname']); ?>!</p>
        <p>Your score: <?php echo $score; ?>/2</p>
        <p>Time taken: <?php echo $minutes . " minutes " . $seconds . " seconds"; ?></p>
        <a href="home.php" class="btn btn-primary">Back to Home</a>
    </div>
</body>
</html>
