<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['lastname'])) {
    echo "Error: User details are missing!";
    exit();
}

require 'quiz.php'; 

// ตรวจสอบว่าได้ส่ง user_id มาหรือไม่ ถ้ามีให้แสดงคะแนน
$username = isset($_GET['username']) ? $_GET['score'] : null;

// ดึงข้อมูลคะแนนจากฐานข้อมูล
if ($user_id) {
    $query = "SELECT * FROM scores WHERE user_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id]);
    $scores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $scores = [];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Score</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
        }

        .navbar {
            background-color: #004a99;
            color: white;
        }

        .navbar-brand img {
            height: 50px;
        }

        .sidebar {
            background-color: #004a99;
            height: 100vh;
            color: white;
            padding-top: 1rem;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background-color: #0059b3;
        }

        .content {
            padding: 20px;
        }

        .card {
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="pic/334576_logo_20230927155032.webp" alt="KU Logo">
                <span class="ms-2">Kobelco Millcon Steel Co., Ltd.</span>
            </a>
            <div class="ms-auto text-white d-flex align-items-center">
                <span class="me-3">
                    <?php
                    echo htmlspecialchars($_SESSION['username']) . " " . htmlspecialchars($_SESSION['lastname']);
                    ?>
                </span>
                <a href="login.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <div class="sidebar">
            <a href="home.php"><i class="fas fa-home"></i> Home</a>
            <a href="#"><i class="bi bi-person-vcard"></i> ตรวจสอบคะแนน</a>
        </div>

        <div class="content flex-grow-1">
            <h4>Check Score</h4>
            <hr>
            <div class="mb-4">
                <?php if ($scores): ?>
                    <h5>Scores for User ID: <?php echo htmlspecialchars($user_id); ?></h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Exam Date</th>
                                <th>Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($scores as $score): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($score['date']); ?></td>
                                    <td><?php echo htmlspecialchars($score['score']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No scores found for this user.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer class="text-center mt-4">
        Server date and time: <?php echo date("d-M-Y H:i:s"); ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
