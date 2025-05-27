<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "vanguard";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute SQL query
    $sql = "SELECT UserID, Username, Usertype FROM users WHERE username = ? AND Password = ?";
    $query = $conn->prepare($sql);
    
    if (!$query) {
        die("Error in preparing SQL query: " . $conn->error);
    }
    
    $query->bind_param('ss', $username, $password);
    $query->execute();
    $result = $query->get_result();

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Store user details in session
        $_SESSION['UserID'] = $row['UserID'];
        $_SESSION['login'] = $row['Username'];

        // Redirect based on user type
        switch ($row['Usertype']) {
            case "Quality Assurance":
                header("Location: QualityDash.html");
                exit();
            case "Admin":
                header("Location: AdminDash.html");
                exit();
            case "city_administrator":
                header("Location: CityDash.html");
                exit();
            default:
                echo "<script>alert('Unknown user type.');</script>";
                break;
        }
    } else {
        echo "<script>alert('Invalid username or password. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
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
    background-color: grey; /* Changed from #4CAF50 to grey */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
    }
    input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <form action="login.php" method="post" id="loginForm">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" name="login" value="Login">
    </form>
</div>
</body>
</html>
