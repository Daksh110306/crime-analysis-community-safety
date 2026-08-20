<?php

session_start();

if (
    !isset($_SESSION["admin_logged_in"]) ||
    $_SESSION["admin_logged_in"] !== true
) {
    header("Location: login.php");
    exit;
}

/* DATABASE CONNECTION */

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crime_analysis";

$conn = new mysqli(
    $servername,
    $username,
    $password,
    $dbname
);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

/* GET ALL CRIME RECORDS */

$sql = "SELECT id, crime_type, location, crime_date, severity, description
        FROM crime_records
        ORDER BY crime_date DESC, id DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Dashboard - Crime Analysis</title>

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

.logout {
    background-color: #c0392b;
    color: white;
    text-decoration: none;
    padding: 10px 18px;
    border-radius: 5px;
}

.logout:hover {
    background-color: #922b21;
}

/* MAIN CONTAINER */

.container {
    width: 95%;
    margin: 40px auto;
}

.welcome {
    text-align: center;
    margin-bottom: 35px;
}

.welcome h2 {
    font-size: 32px;
    margin-bottom: 10px;
}

.welcome p {
    color: #666;
}

/* DASHBOARD CARDS */

.cards {
    display: flex;
    justify-content: center;
    gap: 25px;
    flex-wrap: wrap;
    margin-bottom: 40px;
}

.card {
    background-color: white;
    width: 260px;
    padding: 25px;
    text-align: center;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.card h3 {
    margin-bottom: 18px;
    color: #34495e;
}

.card a {
    display: block;
    background-color: #2980b9;
    color: white;
    padding: 12px;
    text-decoration: none;
    border-radius: 5px;
}

.card a:hover {
    background-color: #1f618d;
}

.green {
    background-color: #27ae60 !important;
}

.green:hover {
    background-color: #1e8449 !important;
}

/* RECORD MANAGEMENT */

.management-box {
    background-color: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.management-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.management-header h2 {
    color: #273746;
}

.add-button {
    background-color: #27ae60;
    color: white;
    padding: 11px 18px;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
}

.add-button:hover {
    background-color: #1e8449;
}

.table-container {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background-color: #273746;
    color: white;
    padding: 14px;
    white-space: nowrap;
}

td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

tr:hover {
    background-color: #f2f2f2;
}

/* SEVERITY COLOURS */

.high {
    color: #c0392b;
    font-weight: bold;
}

.medium {
    color: #d68910;
    font-weight: bold;
}

.low {
    color: #27ae60;
    font-weight: bold;
}

/* EDIT AND DELETE BUTTONS */

.actions {
    white-space: nowrap;
}

.edit-button,
.delete-button {
    display: inline-block;
    color: white;
    padding: 7px 12px;
    margin: 2px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 14px;
    font-weight: bold;
}

.edit-button {
    background-color: #2980b9;
}

.edit-button:hover {
    background-color: #1f618d;
}

.delete-button {
    background-color: #c0392b;
}

.delete-button:hover {
    background-color: #922b21;
}

.no-data {
    padding: 30px;
    color: #777;
}

/* FOOTER */

footer {
    background-color: #17202a;
    color: white;
    text-align: center;
    padding: 20px;
    margin-top: 50px;
}

/* MOBILE VIEW */

@media (max-width: 768px) {

    header {
        padding: 20px;
        flex-direction: column;
        gap: 15px;
    }

    .container {
        width: 96%;
    }

    .card {
        width: 100%;
    }

    .management-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }

    .management-box {
        padding: 15px;
    }
}

</style>

</head>

<body>

<header>

    <h1>Crime Analysis - Admin</h1>

    <a href="logout.php" class="logout">
        Logout
    </a>

</header>

<div class="container">

    <div class="welcome">

        <h2>Welcome, Admin</h2>

        <p>
            Manage crime records and monitor the Crime Analysis system.
        </p>

    </div>

    <div class="cards">

        <div class="card">

            <h3>➕ Add Crime</h3>

            <a href="add_crime.php" class="green">
                Add Crime Record
            </a>

        </div>

        <div class="card">

            <h3>📋 Public Crime Data</h3>

            <a href="crime_data.php">
                View Public Records
            </a>

        </div>

        <div class="card">

            <h3>📊 Analysis</h3>

            <a href="analysis.php">
                View Crime Analysis
            </a>

        </div>

        <div class="card">

            <h3>🛡️ Safety Awareness</h3>

            <a href="safety.php">
                View Safety Tips
            </a>

        </div>

    </div>

    <!-- ADMIN CRIME MANAGEMENT TABLE -->

    <div class="management-box">

        <div class="management-header">

            <h2>Manage Crime Records</h2>

            <a href="add_crime.php" class="add-button">
                + Add Crime Record
            </a>

        </div>

        <div class="table-container">

            <table>

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Crime Type</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th>Severity</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>

                </thead>

                <tbody>

                <?php

                if ($result && $result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {

                        $id = (int) $row["id"];

                        $severity_class =
                            strtolower($row["severity"]);

                        echo "<tr>";

                        echo "<td>" . $id . "</td>";

                        echo "<td>" .
                             htmlspecialchars($row["crime_type"]) .
                             "</td>";

                        echo "<td>" .
                             htmlspecialchars($row["location"]) .
                             "</td>";

                        echo "<td>" .
                             htmlspecialchars($row["crime_date"]) .
                             "</td>";

                        echo "<td class='" .
                             htmlspecialchars($severity_class) .
                             "'>" .
                             htmlspecialchars($row["severity"]) .
                             "</td>";

                        echo "<td>" .
                             htmlspecialchars($row["description"]) .
                             "</td>";

                        echo "<td class='actions'>";

                        echo "<a href='edit_crime.php?id=" .
                             $id .
                             "' class='edit-button'>
                             Edit
                             </a>";

                        echo "<a href='delete_crime.php?id=" .
                             $id .
                             "' class='delete-button'
                             onclick=\"return confirm(
                             'Are you sure you want to delete this record?'
                             );\">
                             Delete
                             </a>";

                        echo "</td>";

                        echo "</tr>";
                    }

                } else {

                    echo "<tr>";

                    echo "<td colspan='7' class='no-data'>
                          No crime records found.
                          </td>";

                    echo "</tr>";
                }

                ?>

                </tbody>

            </table>

        </div>

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