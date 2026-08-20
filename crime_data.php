<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crime_analysis";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

/* Recent crime records first */

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

<title>Crime Data - Crime Analysis</title>

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
    width: 95%;
    margin: 40px auto;
}

.container h2 {
    text-align: center;
    margin-bottom: 10px;
    font-size: 30px;
}

.subtitle {
    text-align: center;
    color: #666;
    margin-bottom: 30px;
}

.table-box {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
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

.no-data {
    text-align: center;
    padding: 30px;
    color: #777;
}

footer {
    background-color: #17202a;
    color: white;
    text-align: center;
    padding: 20px;
    margin-top: 50px;
}

@media (max-width: 768px) {

    header {
        padding: 20px;
        flex-direction: column;
        gap: 15px;
    }

    nav {
        text-align: center;
    }

    nav a {
        display: inline-block;
        margin: 5px 8px;
    }

    .container {
        width: 96%;
        margin: 30px auto;
    }

    .table-box {
        padding: 10px;
    }
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

    <h2>Crime Data</h2>

    <p class="subtitle">
        View reported crime records for community awareness
    </p>

    <div class="table-box">

        <table>

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Crime Type</th>
                    <th>Location</th>
                    <th>Date</th>
                    <th>Severity</th>
                    <th>Description</th>
                </tr>

            </thead>

            <tbody>

            <?php

            if ($result && $result->num_rows > 0) {

                /*
                Start display number from total records.
                Example:
                6, 5, 4, 3, 2, 1
                */

                $display_id = $result->num_rows;

                while ($row = $result->fetch_assoc()) {

                    $severity_class = strtolower($row["severity"]);

                    echo "<tr>";

                    /* Descending display ID */

                    echo "<td>" . $display_id . "</td>";

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

                    echo "</tr>";

                    /* Decrease display ID */

                    $display_id--;
                }

            } else {

                echo "<tr>";

                echo "<td colspan='6' class='no-data'>
                      No crime records found.
                      </td>";

                echo "</tr>";
            }

            ?>

            </tbody>

        </table>

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