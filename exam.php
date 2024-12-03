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

$servername = "localhost";
$username = "root";
$password = "";  
$dbname = "quiz_db";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $score = 0;

    if (isset($_POST['q1']) && $_POST['q1'] == 'Bangkok') {
        $score++;
    }
    if (isset($_POST['q2']) && $_POST['q2'] == 'Russia') {
        $score++;
    }

    $username = $_SESSION['username'];
    $lastname = $_SESSION['lastname'];

    $sql = "INSERT INTO quiz_scores (username, program, score) VALUES ('$username', '$program', '$score')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['score'] = $score;
        $_SESSION['start_time'] = time(); 
        header("Location: result.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

$examDuration = 30 * 60; 
if (!isset($_SESSION['exam_start_time'])) {
    $_SESSION['exam_start_time'] = time(); 
}
$startTime = $_SESSION['exam_start_time'];
$endTime = $startTime + $examDuration;
?>
<script>
    const serverEndTime = <?php echo $endTime * 1000; ?>; 
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam</title>
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
        .question-box {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .timer {
            font-size: 1.5rem;
            font-weight: bold;
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
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <div class="sidebar">
            <a href="home.php"><i class="fas fa-home"></i> Home</a>
            <a href=".php"><i class="bi bi-person-vcard"></i> ตรวจสอบคะแนน</a>
        </div>

        <div class="content flex-grow-1">
            <div class="d-flex align-items-center mb-4">
                <h4>Exam - Program: <?php echo htmlspecialchars($program); ?></h4>
            </div>
            <hr>

            <div class="timer mb-3">
                <span>Time Remaining: <span id="timeRemaining">30:00</span></span>
            </div>

            <form action="exam.php" method="POST">
                <div class="question-box mb-4">
                    <h5>Question 1:</h5>
                    <p>What is the capital of Thailand?</p>
                    <div>
                        <input type="radio" id="option1" name="q1" value="Bangkok">
                        <label for="option1">Bangkok</label>
                    </div>
                    <div>
                        <input type="radio" id="option2" name="q1" value="Chiang Mai">
                        <label for="option2">Chiang Mai</label>
                    </div>
                    <div>
                        <input type="radio" id="option3" name="q1" value="Phuket">
                        <label for="option3">Phuket</label>
                    </div>
                    <div>
                        <input type="radio" id="option4" name="q1" value="Ayutthaya">
                        <label for="option4">Ayutthaya</label>
                    </div>
                </div>

                <div class="question-box mb-4">
                    <h5>Question 2:</h5>
                    <p>Which is the largest country by area?</p>
                    <div>
                        <input type="radio" id="option1" name="q2" value="Russia">
                        <label for="option1">Russia</label>
                    </div>
                    <div>
                        <input type="radio" id="option2" name="q2" value="Canada">
                        <label for="option2">Canada</label>
                    </div>
                    <div>
                        <input type="radio" id="option3" name="q2" value="United States">
                        <label for="option3">United States</label>
                    </div>
                    <div>
                        <input type="radio" id="option4" name="q2" value="China">
                        <label for="option4">China</label>
                    </div>
                </div>

                <div class="d-flex justify-content-start">
                    <button type="submit" class="btn btn-primary">Submit Exam</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="text-center mt-4">
        Server date and time: <?php echo date("d-M-Y H:i:s"); ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const timeDisplay = document.getElementById('timeRemaining');

        function updateTime() {
            const currentTime = Date.now();
            const timeLeft = Math.max(0, serverEndTime - currentTime);

            if (timeLeft === 0) {
                alert('Time is up! Submitting the exam.');
                document.forms[0].submit();
            } else {
                const minutes = Math.floor(timeLeft / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
                timeDisplay.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            }
        }

        setInterval(updateTime, 1000);
        updateTime();
    </script>
</body>
</html>
