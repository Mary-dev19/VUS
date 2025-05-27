<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['UserID'])) {
    // Retrieve the user's ID from the session
    $userID = $_SESSION['UserID'];

    // Connect to the database
    $conn = mysqli_connect("localhost", "root", "", "vanguard");

    // Check the database connection
    if ($conn === false) {
        die("Error: Connection failed. " . mysqli_connect_error());
    }

    // Query to retrieve QA allocations linked to the user
    $sql = "SELECT * FROM allocation WHERE UserID = '$userID'";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check for query execution success
    if (!$result) {
        die("Error in SQL query: " . mysqli_error($conn));
    }

    // Display QA allocations
    if (mysqli_num_rows($result) > 0) {
        echo "<h2>QA Allocations Linked to You</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Allocation ID</th><th>Incident ID</th><th>Contractor ID</th><th>Status</th><th>Action</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['AlloID'] . "</td>";
            echo "<td>" . $row['IncID'] . "</td>";
            echo "<td>" . $row['ConID'] . "</td>";
            echo "<td>" . $row['Status'] . "</td>";
            echo "<td><a href='QAsurvey.html?alloID=" . $row['AlloID'] . "'><button>Survey</button></a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No QA allocations linked to you.";
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "Error: User ID not set in session.";
}
?>
