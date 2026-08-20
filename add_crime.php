<?php

session_start();

if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crime_analysis";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $crime_type = $_POST["crime_type"];
    $location = $_POST["location"];
    $crime_date = $_POST["crime_date"];
    $severity = $_POST["severity"];
    $description = $_POST["description"];

    $sql = "INSERT INTO crime_records 
            (crime_type, location, crime_date, severity, description)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "sssss",
        $crime_type,
        $location,
        $crime_date,
        $severity,
        $description
    );

    if ($stmt->execute()) {
        $message = "Crime record added successfully!";
    } else {
        $message = "Error adding crime record.";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Crime Record</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f6f8;
            color: #222;
        }

        header {
            background-color: #17202a;
            color: white;
            padding: 20px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            font-size: 24px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
        }

        nav a:hover {
            color: #5dade2;
        }

        .container {
            width: 90%;
            max-width: 700px;
            margin: 50px auto;
        }

        .container h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 30px;
        }

        .form-box {
            background-color: white;
            padding: 35px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 15px;
        }

        textarea {
            height: 120px;
            resize: vertical;
        }

        button {
            width: 100%;
            padding: 13px;
            background-color: #2980b9;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #1f618d;
        }

        .message {
            background-color: #d5f5e3;
            color: #1e8449;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }

        footer {
            background-color: #17202a;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 50px;
        }

    </style>

</head>

<body>

<header>

    <h1>Crime Analysis</h1>

    <nav>

        <a href="index.php">Home</a>

        <a href="crime_data.php">Crime Data</a>

        <a href="analysis.php">Analysis</a>

        <a href="safety.php">Safety Tips</a>

    </nav>

</header>


<div class="container">

    <h2>Add Crime Record</h2>

    <div class="form-box">

        <?php if ($message != "") { ?>

            <div class="message">
                <?php echo $message; ?>
            </div>

        <?php } ?>


        <form method="POST" action="">

            <div class="form-group">

                <label>Crime Type</label>

                <select name="crime_type" required>

                    <option value="">Select Crime Type</option>

                    <option value="Theft">Theft</option>

                    <option value="Robbery">Robbery</option>

                    <option value="Cyber Crime">Cyber Crime</option>

                    <option value="Fraud">Fraud</option>

                    <option value="Vehicle Theft">Vehicle Theft</option>

                    <option value="Assault">Assault</option>

                    <option value="Other">Other</option>

                </select>

            </div>


            <div class="form-group">

                <label>Location</label>

                <input
                    type="text"
                    name="location"
                    placeholder="Enter crime location"
                    required
                >

            </div>


            <div class="form-group">

                <label>Crime Date</label>

                <input
                    type="date"
                    name="crime_date"
                    required
                >

            </div>


            <div class="form-group">

                <label>Severity</label>

                <select name="severity" required>

                    <option value="">Select Severity</option>

                    <option value="High">High</option>

                    <option value="Medium">Medium</option>

                    <option value="Low">Low</option>

                </select>

            </div>


            <div class="form-group">

                <label>Description</label>

                <textarea
                    name="description"
                    placeholder="Enter crime description"
                    required
                ></textarea>

            </div>


            <button type="submit">
                Add Crime Record
            </button>

        </form>

    </div>

</div>


<footer>

    <p>© 2026 Crime Analysis for Community Safety Awareness</p>

</footer>

</body>

</html>