<?php

session_start();

if (
    !isset($_SESSION["admin_logged_in"]) ||
    $_SESSION["admin_logged_in"] !== true
) {
    header("Location: login.php");
    exit;
}

/* ONLINE DATABASE CONNECTION */

require_once "db.php";

/* GET RECORD ID */

$id = $_GET["id"] ?? 0;

$id = (int) $id;

/* DELETE RECORD */

$sql = "DELETE FROM crime_records WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    header("Location: admin_dashboard.php");
    exit;

} else {

    echo "Error deleting record.";

}

$stmt->close();

$conn->close();

?>
