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

$id = $_GET["id"] ?? 0;

$sql = "SELECT * FROM crime_records WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$crime = $result->fetch_assoc();

$stmt->close();

if (!$crime) {
    die("Crime record not found.");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $crime_type = $_POST["crime_type"];
    $location = $_POST["location"];
    $crime_date = $_POST["crime_date"];
    $severity = $_POST["severity"];
    $description = $_POST["description"];

    $update_sql = "UPDATE crime_records
                   SET crime_type = ?,
                       location = ?,
                       crime_date = ?,
                       severity = ?,
                       description = ?
                   WHERE id = ?";

    $update_stmt = $conn->prepare($update_sql);

    $update_stmt->bind_param(
        "sssssi",
        $crime_type,
        $location,
        $crime_date,
        $severity,
        $description,
        $id
    );

    if ($update_stmt->execute()) {
        header("Location: crime_data.php");
        exit;
    }

    $update_stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Crime Record</title>

<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background-color: #f4f6f8;
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

.container {
    width: 90%;
    max-width: 700px;
    margin: 50px auto;
}

.container h2 {
    text-align: center;
    margin-bottom: 30px;
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

.cancel {
    display: block;
    text-align: center;
    margin-top: 15px;
    color: #555;
    text-decoration: none;
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

<h2>Edit Crime Record</h2>

<div class="form-box">

<form method="POST">

<div class="form-group">

<label>Crime Type</label>

<select name="crime_type" required>

<option value="Theft"
<?php if ($crime["crime_type"] == "Theft") echo "selected"; ?>>
Theft
</option>

<option value="Robbery"
<?php if ($crime["crime_type"] == "Robbery") echo "selected"; ?>>
Robbery
</option>

<option value="Cyber Crime"
<?php if ($crime["crime_type"] == "Cyber Crime") echo "selected"; ?>>
Cyber Crime
</option>

<option value="Fraud"
<?php if ($crime["crime_type"] == "Fraud") echo "selected"; ?>>
Fraud
</option>

<option value="Vehicle Theft"
<?php if ($crime["crime_type"] == "Vehicle Theft") echo "selected"; ?>>
Vehicle Theft
</option>

<option value="Assault"
<?php if ($crime["crime_type"] == "Assault") echo "selected"; ?>>
Assault
</option>

<option value="Other"
<?php if ($crime["crime_type"] == "Other") echo "selected"; ?>>
Other
</option>

</select>

</div>


<div class="form-group">

<label>Location</label>

<input
type="text"
name="location"
value="<?php echo htmlspecialchars($crime["location"]); ?>"
required
>

</div>


<div class="form-group">

<label>Crime Date</label>

<input
type="date"
name="crime_date"
value="<?php echo $crime["crime_date"]; ?>"
required
>

</div>


<div class="form-group">

<label>Severity</label>

<select name="severity" required>

<option value="High"
<?php if ($crime["severity"] == "High") echo "selected"; ?>>
High
</option>

<option value="Medium"
<?php if ($crime["severity"] == "Medium") echo "selected"; ?>>
Medium
</option>

<option value="Low"
<?php if ($crime["severity"] == "Low") echo "selected"; ?>>
Low
</option>

</select>

</div>


<div class="form-group">

<label>Description</label>

<textarea
name="description"
required
><?php echo htmlspecialchars($crime["description"]); ?></textarea>

</div>


<button type="submit">
Update Crime Record
</button>

<a href="crime_data.php" class="cancel">
Cancel
</a>

</form>

</div>

</div>


<footer>

<p>© 2026 Crime Analysis for Community Safety Awareness</p>

</footer>

</body>

</html>

<?php

$conn->close();

?>