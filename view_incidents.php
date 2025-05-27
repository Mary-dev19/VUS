<?php

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vanguard";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve data from the incident table
$sql = "SELECT * FROM incident WHERE Status='New' || Status='Updated'";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Incidents</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Incidents</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Location</th>
        <th>Name</th>
        <th>Description</th>
        <th>Image</th>
        <th>Date Created</th>
        <th>Status</th>
			
    </tr>
    <?php
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["IncID"] . "</td>";
            echo "<td>" . $row["Location"] . "</td>";
            echo "<td>" . $row["Name"] . "</td>";
            echo "<td>" . $row["Description"] . "</td>";
            echo '<td><img src="' . $row["incidentImage"] . '" width="100px" height="auto"></td>';
            echo "<td>" . $row["DateCreated"] . "</td>";
            echo "<td>" . $row["Status"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No incidents found</td></tr>";
    }
    ?>
</table>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>
