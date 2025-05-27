<?php
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "vanguard");

// Check connection
if ($conn === false) {
    die("Error: Connection failed. " . mysqli_connect_error());
}

// Initialize variables to store error messages and success message
$updateError = "";
$successMessage = "";

// Check if the user has submitted the update form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateUser'])) {
    // Check if all fields are filled
    if (empty($_POST['name']) || empty($_POST['email'])) {
        $updateError = "All fields are required.";
    } else {
        // If all fields are filled, proceed with updating the user
        $userID = $_POST['userID'];
        $name = $_POST['name'];
        $email = $_POST['email'];

        // Update user in users table
        $update_query = "UPDATE users SET Name='$name', Email='$email' WHERE UserID='$userID'";
        $update_result = mysqli_query($conn, $update_query);
        if (!$update_result) {
            die("Error updating user: " . mysqli_error($conn));
        }

        // Delete the record from the request table
        $delete_request_query = "DELETE FROM request WHERE UserID='$userID'";
        $delete_request_result = mysqli_query($conn, $delete_request_query);
        if (!$delete_request_result) {
            die("Error deleting record from request table: " . mysqli_error($conn));
        }

        // Set success message
        $successMessage = "User updated successfully.";
    }
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Users</title>
</head>
<body>

<h2>Update Users</h2>
<form method='POST' action='' id='updateForm'>
    <span style="color: red;"><?php echo $updateError; ?></span><br>
    UserID: <input type='text' name='userID' readonly value='<?php echo isset($_POST['userID']) ? $_POST['userID'] : ''; ?>'><br>
    Name: <input type='text' name='name' required><br>
    Email: <input type='text' name='email' required><br>
    <input type='submit' name='updateUser' value='Update'>
</form>

<?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateUser']) && $successMessage !== ""): ?>
    <script>
        // Display success message using JavaScript
        alert("<?php echo $successMessage; ?>");
    </script>
<?php endif; ?>

<p><a href="AdminDash.html">Go to Home</a></p>

</body>
</html>
