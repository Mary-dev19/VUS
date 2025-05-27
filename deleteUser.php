<?php
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "vanguard");

// Check connection
if ($conn === false) {
    die("Error: Connection failed. " . mysqli_connect_error());
}

// Check if the user has submitted the form to delete users
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteUser'])) {
    if(isset($_POST['deleteUserID'])) {
        $deleteUserIDs = $_POST['deleteUserID'];

        // Insert deleted users into deleted_accounts table and delete from users and requests tables
        foreach ($deleteUserIDs as $userID) {
            // Insert into deleted_accounts table
            $insert_deleted_query = "INSERT INTO deleted_accounts SELECT * FROM requests WHERE UserID='$userID'";
            $insert_deleted_result = mysqli_query($conn, $insert_deleted_query);
            if (!$insert_deleted_result) {
                die("Error inserting user into deleted_accounts table: " . mysqli_error($conn));
            }
            
            // Delete from users table
            $delete_users_query = "DELETE FROM users WHERE UserID='$userID'";
            $delete_users_result = mysqli_query($conn, $delete_users_query);
            if (!$delete_users_result) {
                die("Error deleting user from users table: " . mysqli_error($conn));
            }

            // Delete from requests table
            $delete_requests_query = "DELETE FROM requests WHERE UserID='$userID'";
            $delete_requests_result = mysqli_query($conn, $delete_requests_query);
            if (!$delete_requests_result) {
                die("Error deleting request from requests table: " . mysqli_error($conn));
            }
        }

        echo "Selected users deleted successfully.";
    }
}

// Close connection
mysqli_close($conn);
?>
