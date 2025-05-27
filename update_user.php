<?php
// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'vanguard');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if action is set
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = '';
}

// Check if ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = '';
}

// Update contractor
if ($action == 'update') {
    // Get the updated user ID from the form or request parameters
    $updatedUserId = $_POST['user_id']; // Assuming the form field or request parameter is named 'user_id'

    // Update the user in the 'users' table
    $update_user_query = "UPDATE users SET UserID = $updatedUserId WHERE UserID = $id";
    $update_user_result = mysqli_query($conn, $update_user_query);

    if (!$update_user_result) {
        die("Error updating user: " . mysqli_error($conn));
    }

    echo "User updated successfully.";
    // Hide the table after updating
    $showTable = false;
}

// Close database connection
mysqli_close($conn);
?>