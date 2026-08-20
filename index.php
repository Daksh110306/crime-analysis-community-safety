<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crime_analysis";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

/* Total crimes */
$total_query = $conn->query("SELECT COUNT(*) AS total FROM crime_records");
$total = $total_query->fetch_assoc()["total"];

/* High severity */
$high_query = $conn->query("SELECT COUNT(*) AS total FROM crime_records WHERE severity = 'High'");
$high = $high_query->fetch_assoc()["total"];

/* Medium severity */
$medium_query = $conn->query("SELECT COUNT(*) AS total FROM crime_records WHERE severity = 'Medium'");
$medium = $medium_query->fetch_assoc()["total"];

/* Low severity */
$low_query = $conn->query("SELECT COUNT(*) AS total FROM crime_records WHERE severity = 'Low'");
$low = $low_query->fetch_assoc()["total"];

/* Recent crimes */
$recent_query = $conn->query(
    "SELECT * FROM crime_records ORDER BY crime_date DESC LIMIT 5"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Crime Analysis Dashboard</title>

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

/* HEADER */

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
    margin-left: 22px;
}

nav a:hover {
    color: #5dade2;
}

/* MAIN */

.container {
    width: 92%;
    margin: 40px auto;
}

.title {
    text-align: center;
    margin-bottom: 10px;
    font-size: 32px;
}

.subtitle {
    text-align: center;
    color: #666;
    margin-bottom: 35px;
}

/* STAT CARDS */

.stats {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 40px;
}

.card {
    background-color: white;
    width: 220px;
    padding: 25px;
    border-radius: 10px;

    text-align: center;

    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.card h3 {
    margin-bottom: 15px;
    color: #34495e;
}

.number {
    font-size: 36px;
    font-weight: bold;
    color: #2980b9;
}

.high {
    color: #c0392b;
}

.medium {
    color: #d68910;
}

.low {
    color: #27ae60;
}

/* QUICK ACTIONS */

.actions {
    background-color: white;
    padding: 25px;
    border-radius: 10px;
    margin-bottom: 35px;

    box-shadow: 0 3px 10px rgba(0,0,0,0.1);

    text-align: center;
}

.actions h2 {
    margin-bottom: 20px;
}

.btn {
    display: inline-block;
    padding: 12px 20px;
    margin: 7px;

    color: white;
    background-color: #2980b9;

    text-decoration: none;
    border-radius: 5px;
}

.btn:hover {
    background-color: #1f618d;
}

.green {
    background-color: #27ae60;
}

.green:hover {
    background-color: #1e8449;
}

/* RECENT DATA */

.data-box {
    background-color: white;
    padding: 25px;
    border-radius: 10px;

    box-shadow: 0 3px 10px rgba(0,0,0,0.1);

    overflow-x: auto;
}

.data-box h2 {
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background-color: #273746;
    color: white;
    padding: 13px;
}

td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

tr:hover {
    background-color: #f2f2f2;
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

<a href="index.php">Dashboard</a>

<a href="crime_data.php">Crime Data</a>

<a href="analysis.php">Analysis</a>

<a href="safety.php">Safety Tips</a>

</nav>

</header>


<div class="container">

<h1 class="title">
Crime Analysis Dashboard
</h1>

<p class="subtitle">
Community Safety Awareness & Crime Pattern Monitoring
</p>


<!-- STATISTICS -->

<div class="stats">

<div class="card">

<h3>Total Crime Cases</h3>

<div class="number">
<?php echo $total; ?>
</div>

</div>


<div class="card">

<h3>High Severity</h3>

<div class="number high">
<?php echo $high; ?>
</div>

</div>


<div class="card">

<h3>Medium Severity</h3>

<div class="number medium">
<?php echo $medium; ?>
</div>

</div>


<div class="card">

<h3>Low Severity</h3>

<div class="number low">
<?php echo $low; ?>
</div>

</div>

</div>


<!-- QUICK ACTIONS -->

<div class="actions">

<h2>Quick Actions</h2>

<a href="crime_data.php" class="btn">
View Crime Data
</a>

<a href="analysis.php" class="btn">
View Analysis
</a>

<a href="safety.php" class="btn">
Safety Awareness
</a>

</div>


<!-- RECENT RECORDS -->

<div class="data-box">

<h2>Recent Crime Records</h2>

<table>

<tr>

<th>ID</th>

<th>Crime Type</th>

<th>Location</th>

<th>Date</th>

<th>Severity</th>

</tr>


<?php

if ($recent_query && $recent_query->num_rows > 0) {

    while ($row = $recent_query->fetch_assoc()) {

        $severity_class = strtolower($row["severity"]);

        echo "<tr>";

        echo "<td>" . $row["id"] . "</td>";

        echo "<td>" .
             htmlspecialchars($row["crime_type"]) .
             "</td>";

        echo "<td>" .
             htmlspecialchars($row["location"]) .
             "</td>";

        echo "<td>" .
             $row["crime_date"] .
             "</td>";

        echo "<td class='" .
             $severity_class .
             "'>" .
             htmlspecialchars($row["severity"]) .
             "</td>";

        echo "</tr>";
    }

} else {

    echo "<tr>";

    echo "<td colspan='5'>
          No crime records available.
          </td>";

    echo "</tr>";
}

?>

</table>

</div>

</div>


<footer>

<p>
© 2026 Crime Analysis for Community Safety Awareness
</p>

</footer>


</body>

</html>

<?php

$conn->close();

?>