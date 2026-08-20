<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crime_analysis";

/* Database Connection */

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}


/* TOTAL CRIME CASES */

$total = $conn->query(
    "SELECT COUNT(*) AS total FROM crime_records"
)->fetch_assoc()["total"];


/* SEVERITY COUNTS */

$high = $conn->query(
    "SELECT COUNT(*) AS total
     FROM crime_records
     WHERE severity = 'High'"
)->fetch_assoc()["total"];

$medium = $conn->query(
    "SELECT COUNT(*) AS total
     FROM crime_records
     WHERE severity = 'Medium'"
)->fetch_assoc()["total"];

$low = $conn->query(
    "SELECT COUNT(*) AS total
     FROM crime_records
     WHERE severity = 'Low'"
)->fetch_assoc()["total"];


/* LOCATION-WISE ANALYSIS */

$locationData = $conn->query(
    "SELECT location, COUNT(*) AS total
     FROM crime_records
     GROUP BY location
     ORDER BY total DESC, location ASC"
);


/* DATE-WISE ANALYSIS */

$dateData = $conn->query(
    "SELECT crime_date, COUNT(*) AS total
     FROM crime_records
     GROUP BY crime_date
     ORDER BY crime_date DESC"
);


/* CRIME TYPE ANALYSIS */

$crime_types = [];

$type_query = $conn->query(
    "SELECT crime_type, COUNT(*) AS total
     FROM crime_records
     GROUP BY crime_type
     ORDER BY total DESC, crime_type ASC"
);

while ($row = $type_query->fetch_assoc()) {
    $crime_types[] = $row;
}


/* FIND HIGHEST CRIME COUNT */

$max_count = 1;

foreach ($crime_types as $crime) {

    if ($crime["total"] > $max_count) {
        $max_count = $crime["total"];
    }

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Crime Pattern Analysis</title>

<style>

/* GENERAL */

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
    margin-left: 25px;
}

nav a:hover {
    color: #5dade2;
}


/* MAIN CONTAINER */

.container {
    width: 90%;
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
    margin-bottom: 35px;
}


/* SUMMARY */

.summary {
    display: flex;
    justify-content: center;
    gap: 25px;
    flex-wrap: wrap;
    margin-bottom: 40px;
}

.box {
    background-color: white;
    width: 220px;
    padding: 25px;

    text-align: center;

    border-radius: 10px;

    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.box h3 {
    margin-bottom: 12px;
    color: #34495e;
}

.number {
    font-size: 32px;
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


/* ANALYSIS BOX */

.analysis-box {
    background-color: white;

    padding: 30px;

    border-radius: 10px;

    box-shadow: 0 3px 10px rgba(0,0,0,0.1);

    margin-bottom: 30px;
}

.analysis-box h3 {
    margin-bottom: 25px;
    color: #273746;
}


/* TABLE */

.table-container {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background-color: #2980b9;
    color: white;

    padding: 14px;

    text-align: left;
}

td {
    padding: 13px 14px;

    border-bottom: 1px solid #ddd;
}

tr:nth-child(even) {
    background-color: #f4f6f7;
}

tr:hover {
    background-color: #eaf2f8;
}


/* ===================================== */
/* VERTICAL CRIME TYPE GRAPH */
/* ===================================== */

.chart-scroll {
    width: 100%;
    overflow-x: auto;
    padding-bottom: 10px;
}

.vertical-chart {
    height: 380px;

    min-width: 600px;

    display: flex;

    align-items: flex-end;

    justify-content: space-around;

    gap: 25px;

    padding: 40px 30px 0 55px;

    border-left: 2px solid #34495e;

    border-bottom: 2px solid #34495e;

    position: relative;

    background-image:
        repeating-linear-gradient(
            to top,
            transparent,
            transparent 59px,
            #e5e7e9 60px
        );
}


/* Y AXIS TITLE */

.y-axis-title {
    position: absolute;

    left: -45px;

    top: 145px;

    transform: rotate(-90deg);

    font-size: 14px;

    font-weight: bold;

    color: #566573;
}


/* GRAPH COLUMN */

.chart-column {
    height: 100%;

    min-width: 75px;

    display: flex;

    flex-direction: column;

    justify-content: flex-end;

    align-items: center;
}


/* NUMBER ABOVE BAR */

.bar-value {
    margin-bottom: 7px;

    font-weight: bold;

    color: #273746;

    font-size: 16px;
}


/* STANDING BAR */

.vertical-bar {

    width: 55px;

    background-color: #2980b9;

    border-radius: 7px 7px 0 0;

    min-height: 15px;

    transition: 0.3s;
}

.vertical-bar:hover {
    background-color: #1f618d;

    transform: scaleX(1.08);
}


/* CRIME TYPE NAME */

.chart-label {

    margin-top: 10px;

    text-align: center;

    font-size: 13px;

    font-weight: bold;

    color: #34495e;

    max-width: 100px;

    word-wrap: break-word;
}


/* GRAPH NOTE */

.graph-note {

    text-align: center;

    margin-top: 20px;

    color: #777;

    font-size: 13px;
}


/* SAFETY OBSERVATION */

.message {

    background-color: #eaf2f8;

    padding: 20px;

    border-left: 5px solid #2980b9;

    line-height: 1.6;
}


/* FOOTER */

footer {

    background-color: #17202a;

    color: white;

    text-align: center;

    padding: 20px;

    margin-top: 50px;
}


/* MOBILE */

@media screen and (max-width: 768px) {

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

        width: 94%;

        margin: 30px auto;
    }

    .container h2 {
        font-size: 25px;
    }

    .box {
        width: 100%;
    }

    .analysis-box {
        padding: 20px;
    }

    .vertical-chart {

        height: 330px;

        padding-left: 45px;

        gap: 18px;
    }

    .vertical-bar {
        width: 45px;
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


<h2>Crime Pattern Analysis</h2>

<p class="subtitle">

Live analysis based on crime records stored in the database

</p>


<!-- ===================================== -->
<!-- SUMMARY -->
<!-- ===================================== -->

<div class="summary">


<div class="box">

<h3>Total Cases</h3>

<div class="number">

<?php echo $total; ?>

</div>

</div>


<div class="box">

<h3>High Severity</h3>

<div class="number high">

<?php echo $high; ?>

</div>

</div>


<div class="box">

<h3>Medium Severity</h3>

<div class="number medium">

<?php echo $medium; ?>

</div>

</div>


<div class="box">

<h3>Low Severity</h3>

<div class="number low">

<?php echo $low; ?>

</div>

</div>


</div>


<!-- ===================================== -->
<!-- LOCATION-WISE ANALYSIS -->
<!-- ===================================== -->

<div class="analysis-box">

<h3>Location-wise Crime Analysis</h3>

<div class="table-container">

<table>

<tr>

<th>Location</th>

<th>Total Cases</th>

</tr>


<?php if ($locationData->num_rows > 0) { ?>


<?php while ($row = $locationData->fetch_assoc()) { ?>

<tr>

<td>

<?php echo htmlspecialchars($row["location"]); ?>

</td>

<td>

<?php echo $row["total"]; ?>

</td>

</tr>

<?php } ?>


<?php } else { ?>


<tr>

<td colspan="2">

No location data available.

</td>

</tr>


<?php } ?>


</table>

</div>

</div>


<!-- ===================================== -->
<!-- DATE-WISE ANALYSIS -->
<!-- ===================================== -->

<div class="analysis-box">

<h3>Date-wise Crime Analysis</h3>

<div class="table-container">

<table>

<tr>

<th>Crime Date</th>

<th>Total Cases</th>

</tr>


<?php if ($dateData->num_rows > 0) { ?>


<?php while ($row = $dateData->fetch_assoc()) { ?>


<tr>

<td>

<?php

echo date(
    "d-m-Y",
    strtotime($row["crime_date"])
);

?>

</td>


<td>

<?php echo $row["total"]; ?>

</td>

</tr>


<?php } ?>


<?php } else { ?>


<tr>

<td colspan="2">

No date-wise data available.

</td>

</tr>


<?php } ?>


</table>

</div>

</div>


<!-- ===================================== -->
<!-- CRIME TYPE VERTICAL GRAPH -->
<!-- ===================================== -->

<div class="analysis-box">

<h3>Crime Type Analysis</h3>


<?php if (count($crime_types) > 0) { ?>


<div class="chart-scroll">

<div class="vertical-chart">


<div class="y-axis-title">

Number of Cases

</div>


<?php foreach ($crime_types as $crime) { ?>


<?php

/*
Calculate bar height.

Maximum crime type receives approximately
280px height and other bars are calculated
relative to the maximum value.
*/

$bar_height =
    ($crime["total"] / $max_count) * 280;

?>


<div class="chart-column">


<div class="bar-value">

<?php echo $crime["total"]; ?>

</div>


<div
class="vertical-bar"
style="height: <?php echo $bar_height; ?>px;"
title="<?php
echo htmlspecialchars($crime["crime_type"])
     . ': '
     . $crime["total"]
     . ' case(s)';
?>">
</div>


<div class="chart-label">

<?php

echo htmlspecialchars(
    $crime["crime_type"]
);

?>

</div>


</div>


<?php } ?>


</div>

</div>


<p class="graph-note">

Crime types are compared according to the number of recorded cases.

</p>


<?php } else { ?>


<p>No crime type data available.</p>


<?php } ?>


</div>


<!-- ===================================== -->
<!-- SAFETY OBSERVATION -->
<!-- ===================================== -->

<div class="analysis-box">

<h3>Safety Observation</h3>

<div class="message">


<?php


if ($total == 0 || count($crime_types) == 0) {


echo "No crime records are currently available for analysis.";


} else {


$highest = $crime_types[0]["crime_type"];

$highest_count = $crime_types[0]["total"];


echo

"Based on the current database records, "

. "<strong>"

. htmlspecialchars($highest)

. "</strong> has the highest number of recorded cases "

. "with <strong>"

. $highest_count

. "</strong> case(s). "

. "Citizens should remain alert and follow appropriate safety practices.";


}


?>


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