<?php
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "vanguard");

// Check connection
if ($conn === false) {
    die("Error: Connection failed. " . mysqli_connect_error());
}

// Retrieve data from 'con_request' table
$con_request_query = "SELECT *, 'con_request' as source FROM con_request";
$con_request_result = mysqli_query($conn, $con_request_query);

if (!$con_request_result) {
    die("Error fetching con_request data: " . mysqli_error($conn));
}

// Retrieve data from 'request' table
$request_query = "SELECT *, 'request' as source FROM request";
$request_result = mysqli_query($conn, $request_query);

if (!$request_result) {
    die("Error fetching request data: " . mysqli_error($conn));
}

// Display data from 'con_request' table
echo "<h2>Con Requests</h2>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Reason</th><th>Action</th></tr>";

while ($row = mysqli_fetch_assoc($con_request_result)) {
    echo "<tr>";
    echo "<td>" . $row['ConID'] . "</td>";
    echo "<td>" . $row['Name'] . "</td>";
    echo "<td>" . $row['Email'] . "</td>";
    echo "<td>" . $row['Reason'] . "</td>";
    echo "<td>
            <form method='POST' action=''>
                <input type='hidden' name='deleteCon[]' value='" . $row['ConID'] . "'>
                <button type='submit' name='deleteCon'>Delete</button>
            </form>
            <form method='POST' action='update_contractors.php'>
                <input type='hidden' name='ConID' value='" . $row['ConID'] . "'>
                <input type='hidden' name='name' value='" . $row['Name'] . "'>
                <input type='hidden' name='email' value='" . $row['Email'] . "'>
                <button type='submit' name='update_contractors'>Update</button>
            </form>
          </td>";
    echo "</tr>";
}

echo "</table>";

// Display data from 'request' table
echo "<h2>Requests</h2>";
echo "<table border='1' id='requestTable'>";
echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Reason</th><th>Action</th></tr>";

while ($row = mysqli_fetch_assoc($request_result)) {
    echo "<tr>";
    echo "<td>" . $row['UserID'] . "</td>";
    echo "<td>" . $row['Name'] . "</td>";
    echo "<td>" . $row['Email'] . "</td>";
    echo "<td>" . $row['Reason'] . "</td>";
    echo "<td>
            <form method='POST' action=''>
                <input type='hidden' name='deleteUserID[]' value='" . $row['UserID'] . "'>
                <button type='submit' name='deleteUser'>Delete</button>
            </form>
            <form method='POST' action='updateuser.php'>
                <input type='hidden' name='userID' value='" . $row['UserID'] . "'>
                <input type='hidden' name='name' value='" . $row['Name'] . "'>
                <input type='hidden' name='email' value='" . $row['Email'] . "'>
                <button type='submit' name='updateUser'>Update</button>
            </form>
          </td>";
    echo "</tr>";
}

echo "</table>";

// Check if the user has submitted the form to delete users
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteUser'])) {
    if(isset($_POST['deleteUserID'])) {
        $deleteUserIDs = $_POST['deleteUserID'];

        // Insert deleted users into deleted_accounts table and delete from users and requests tables
        foreach ($deleteUserIDs as $userID) {
            // Insert into deleted_accounts table
            $insert_deleted_query = "INSERT INTO deleted_accounts (UserID, Name, Email) SELECT UserID, Name, Email FROM request WHERE UserID='$userID'";
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
            $delete_requests_query = "DELETE FROM request WHERE UserID='$userID'";
            $delete_requests_result = mysqli_query($conn, $delete_requests_query);
            if (!$delete_requests_result) {
                die("Error deleting request from requests table: " . mysqli_error($conn));
            }
        }

        echo "<script>
                alert('Selected user deleted successfully.');
                document.getElementById('requestTable').style.display = 'none';
              </script>";
    }
}

// Close connection
mysqli_close($conn);
?>
<script>
    function handleDelete(event) {
        if (!confirm('Are you sure you want to delete this user?')) {
            event.preventDefault();
        }
    }
</script>
