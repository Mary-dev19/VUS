<?php
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "vanguard");

// Check connection
if ($conn === false) {
    die("Error: Connection failed. " . mysqli_connect_error());
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sendRequest'])) {
    // Check if the request is for a user
    if (isset($_POST['userID'])) {
        $id = $_POST['userID'];
        // Retrieve user information
        $user_query = "SELECT * FROM users WHERE UserID = $id";
        $user_result = mysqli_query($conn, $user_query);
        if (!$user_result) {
            echo "Error fetching user information: " . mysqli_error($conn);
            exit;
        }
        $user_row = mysqli_fetch_assoc($user_result);
        $type = 'user';
        $name = $user_row['Name'];
        $email = $user_row['Email'];
    }

    // Set the Reason based on the selected option
    $reason = $_POST['reason'] == 'Update' ? 'Update user' : 'Delete user';

    // Insert the request into the 'requests' table
    $insert_query = "INSERT INTO request (UserID, Name, Email, Reason) VALUES ('$id', '$name', '$email', '$reason')";
    if (mysqli_query($conn, $insert_query)) {
        echo "Request sent successfully.";
    } 
	else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}

// Close connection
mysqli_close($conn);
?>
