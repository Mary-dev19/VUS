<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "vanguard");

// Check connection
if ($conn === false) {
    die("Error: Connection failed. " . mysqli_connect_error());
}

// Check if the form was submitted
$showTable = true;
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['source']) && isset($_GET['id']) && isset($_GET['action'])) {
    $source = $_GET['source'];
    $id = $_GET['id'];
    $action = $_GET['action'];

    if ($action == 'delete') {
        // Delete contractor from 'con_request' table
        $delete_contractor_query = "DELETE FROM con_request WHERE ConID = $id";
        $delete_contractor_result = mysqli_query($conn, $delete_contractor_query);
        
        if (!$delete_contractor_result) {
            die("Error deleting contractor from con_request table: " . mysqli_error($conn));
        }

        echo "Contractor deleted successfully.";
        // Hide the table after deleting
        $showTable = false;
    } elseif ($action == 'update') {
        // Redirect to update page with contractor ID
        header("Location: update_contractor.php?id=$id");
        exit();
    }
}

// Retrieve data from 'con_request' table
$con_request_query = "SELECT *, 'con_request' as source FROM con_request";
$con_request_result = mysqli_query($conn, $con_request_query);

if (!$con_request_result) {
    die("Error fetching con_request data: " . mysqli_error($conn));
}

// Check if there are any rows fetched before displaying the table
if (mysqli_num_rows($con_request_result) > 0) {
    // Display data from 'con_request' table
    echo "<h2>Contractors</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Action</th></tr>";

    while ($row = mysqli_fetch_assoc($con_request_result)) {
        echo "<tr>";
        echo "<td>" . $row['ConID'] . "</td>";
        echo "<td>" . $row['Name'] . "</td>";
        echo "<td>" . $row['Email'] . "</td>";
        echo "<td><a href='?source=" . $row['source'] . "&id=" . $row['ConID'] . "&action=delete'>Delete</a> | <a href='update_contractor.php?source=" . $row['source'] . "&id=" . $row['ConID'] . "&action=update'>Update</a></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    // Display message when there are no contractors
    echo "<p>No contractors available.</p>";
}

// Close connection
mysqli_close($conn);
?>
