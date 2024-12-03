<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['lastname'])) {
    echo "Error: User details are missing!";
    exit();
}

if (isset($_GET['program'])) {
    $program = $_GET['program'];
} else {
    $program = "No program selected.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <a href="training.php"><i class="bi bi-person-circle"></i> Profile</a>
        </div>

        <div class="content flex-grow-1">
            <h4>Training - Program: <?php echo htmlspecialchars($program); ?></h4>
            <hr>

            <div class="card p-4 mt-4" style="max-width: 500px;">
                <h5>Start the Training</h5>
                <div class="mb-3">
                    <strong>Subject:</strong> <?php echo htmlspecialchars($program); ?>
                </div>
                <div class="mb-3">
                    <strong>Training Description:</strong> ฝึกฝนเพื่อเตรียมตัวให้พร้อมสำหรับข้อสอบ
                </div>

                <div class="mb-3">
                    <strong>Training Content:</strong>
                    <p>เนื้อหาการฝึกซ้อมเพื่อเตรียมตัวสำหรับข้อสอบ</p>
                    <p>ฝึกฝนให้มั่นใจว่าคุณพร้อมที่จะทำข้อสอบ</p>
                </div>

                <div class="d-flex justify-content-start mb-3">
                    <a href="exam.php?program=<?php echo urlencode($program); ?>" class="btn btn-primary">Start Quiz</a>
                </div>

            </div>
        </div>
    </div>

    <footer class="text-center mt-4">
        Server date and time: <?php echo date("d-M-Y H:i:s"); ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
