<?php
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "vanguard");

// Check connection
if ($conn === false) {
    die("Error: Connection failed. " . mysqli_connect_error());
}

// Retrieve data from the allocation table where status is 'Surveyed'
$allocation_query = "SELECT * FROM allocation WHERE Status = 'Surveyed'";
$allocation_result = mysqli_query($conn, $allocation_query);

// Display allocation table with confirmed payment column
echo "<h2>Allocation Table</h2>";
echo "<table border='1'>";
echo "<tr><th>AlloID</th><th>IncID</th><th>UserID</th><th>ConID</th><th>Status</th><th>Confirmed Payment</th></tr>";
while ($row = mysqli_fetch_assoc($allocation_result)) {
    echo "<tr>";
    echo "<td>" . $row['AlloID'] . "</td>";
    echo "<td>" . $row['IncID'] . "</td>";
    echo "<td>" . $row['UserID'] . "</td>";
    echo "<td>" . $row['ConID'] . "</td>";
    echo "<td>" . $row['Status'] . "</td>";
    echo "<td><a href='con_pay.php?alloID=" . $row['AlloID'] . "'>Confirm</a></td>"; // Link to confirm payment
    echo "</tr>";
}
echo "</table>";

// Close connection
mysqli_close($conn);
?>
