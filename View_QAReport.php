<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "vanguard");

// Check connection
if ($conn === false) {
    die("Error: Connection failed. " . mysqli_connect_error());
}

// Retrieve data from 'qat' table
$qat_query = "SELECT * FROM qat ORDER BY QAID ASC";
$qat_result = mysqli_query($conn, $qat_query);

if (!$qat_result) {
    die("Error fetching data from qat table: " . mysqli_error($conn));
}

// Display data in tabular format
echo "<table border='1'>";
echo "<tr><th>QAID</th><th>Ratings</th><th>Description</th><th>Decision</th><th>Comments</th></tr>";
while ($row = mysqli_fetch_assoc($qat_result)) {
    echo "<tr>";
    echo "<td>" . $row['QAID'] . "</td>";
    echo "<td>" . $row['Ratings'] . "</td>";
    echo "<td>" . $row['Description'] . "</td>";
    echo "<td>" . $row['Decision'] . "</td>";
    echo "<td>" . $row['Comments'] . "</td>";
    echo "</tr>";
}
echo "</table>";

// Close connection
mysqli_close($conn);
?>
