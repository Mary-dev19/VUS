<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contractor Login</title>
    <style>
        /* Embedded CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: grey;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Contractor Login</h2>
    <form role="form" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" name="login" value="login">
    </form>
    
    <h4>You don't have an account? Click here to register</h4>
    <a href="Contractor.html">Sign up</a>
</div>

</body>
</html>

<?php
error_reporting(E_ALL);
session_start();
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$vanguard = "vanguard";

$conn = new mysqli($servername, $username, $password, $vanguard);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT Username, Password, ConID FROM contractor WHERE Username = ? AND Password = ?";
    $query = $conn->prepare($sql);
    $query->bind_param('ss', $username, $password);
    $query->execute();
    $result = $query->get_result()->fetch_assoc();

    if($result) {
        $_SESSION['ConID'] = $result['ConID'];
        $_SESSION['login'] = $result['Username'];
        header("Location: contractorDash.html");
        exit();
    } else {
        echo "<script>alert('Invalid username or password. Please try again.');</script>";
    }
}
?>
