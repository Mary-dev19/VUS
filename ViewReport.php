<?php
session_start();

// Debugging output
echo "UserID: " . $_SESSION['UserID'] . "<br>";


// Check if the user is logged in and is a Quality Assurance
if (!isset($_SESSION['UserID'])) {
    echo "Error: User ID not set in session.";
} else {
    // Display the reports
    // Create connection
    $conn = mysqli_connect("localhost", "root", "", "vanguard");

    // Check connection
    if ($conn === false) {
        die("Error: Connection failed. " . mysqli_connect_error());
    }

    // Retrieve reports for Quality Assurance
    $userID = $_SESSION['UserID'];
    $sql = "SELECT IncID, Description, Comment, Hours FROM conr WHERE UserID = '$userID'";

    // Execute SQL query
    $result = mysqli_query($conn, $sql);

    // Check for query execution success
    if (!$result) {
        die("Error in SQL query: " . mysqli_error($conn));
    }

    // Check if there are results
    if (mysqli_num_rows($result) > 0) {
        // Display the reports in a table
        echo "<table border='1'>
                <tr>
                    <th>Incident ID</th>
                    <th>Description</th>
                    <th>Comment</th>
                    <th>Hours</th>
                </tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . $row["IncID"] . "</td>
                    <td>" . $row["Description"] . "</td>
                    <td>" . $row["Comment"] . "</td>
                    <td>" . $row["Hours"] . "</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No reports for You!.";
    }

    // Close connection
    mysqli_close($conn);
}
?>
