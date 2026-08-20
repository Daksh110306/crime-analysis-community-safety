<?php

session_start();

require_once "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user = $_POST["username"];
    $pass = $_POST["password"];

    $sql = "SELECT * FROM admin_users WHERE username = ? AND password = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $_SESSION["admin_logged_in"] = true;
        $_SESSION["admin_username"] = $user;

        header("Location: admin_dashboard.php");
        exit;

    } else {

        $error = "Invalid username or password.";

    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Login - Crime Analysis</title>

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

.login-container {
    width: 100%;
    min-height: 100vh;

    display: flex;
    justify-content: center;
    align-items: center;
}

.login-box {
    background-color: white;
    width: 400px;
    padding: 35px;

    border-radius: 10px;

    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.login-box h1 {
    text-align: center;
    color: #17202a;
    margin-bottom: 10px;
}

.login-box p {
    text-align: center;
    color: #777;
    margin-bottom: 30px;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

input {
    width: 100%;
    padding: 12px;

    border: 1px solid #ccc;
    border-radius: 5px;

    font-size: 15px;
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

.error {
    background-color: #fadbd8;
    color: #922b21;

    padding: 12px;
    margin-bottom: 20px;

    border-radius: 5px;
    text-align: center;
}

.back {
    display: block;
    text-align: center;

    margin-top: 20px;

    color: #2980b9;
    text-decoration: none;
}

</style>

</head>

<body>

<div class="login-container">

<div class="login-box">

<h1>Admin Login</h1>

<p>Crime Analysis Management System</p>


<?php if ($error != "") { ?>

<div class="error">
    <?php echo $error; ?>
</div>

<?php } ?>


<form method="POST">

<div class="form-group">

<label>Username</label>

<input
    type="text"
    name="username"
    placeholder="Enter username"
    required
>

</div>


<div class="form-group">

<label>Password</label>

<input
    type="password"
    name="password"
    placeholder="Enter password"
    required
>

</div>


<button type="submit">
    Login
</button>

</form>


<a href="index.php" class="back">
    ← Back to Dashboard
</a>

</div>

</div>

</body>

</html>

<?php

$conn->close();

?>
