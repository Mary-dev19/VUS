<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident Approvals/Rejections</title>
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
<body bgcolor="#F5F5F5">
 <a href="CityDash.html"> Back </a>
<h2>Incidents Rejections/Approvals</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Location</th>
        <th>Name</th>
        <th>Desciption</th>
        <th>incidentImage</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
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
    $sql = "SELECT * FROM incident WHERE Status='New'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["IncID"] . "</td>";
            echo "<td>" . $row["Location"] . "</td>";
            echo "<td>" . $row["Name"] . "</td>";
            echo "<td>" . $row["Description"] . "</td>";
            echo "<td><img src='" . $row["incidentImage"] . "' alt='incidentImage' style='width:50px;'></td>";
            echo "<td>" . $row["Status"] . "</td>";
            echo "<td class='action-buttons'>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='incident_approval' value='" . $row["IncID"] . "'>";
            echo "<input type='submit' name='approve_incident' value='Approve'>";
            echo "<input type='submit' name='reject_incident' value='Reject'>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No incidents awaiting action.</td></tr>";
    }
    ?>
</table>

<?php
// Approve/Reject incidents
if (isset($_POST['approve_incident']) || isset($_POST['reject_incident'])) {
    $IncID = $_POST['incident_approval'];
    $Status = isset($_POST['approve_incident']) ? 'Approved' : 'Rejected';

    // Update incident status
    $sql = "UPDATE incident SET Status='$Status' WHERE IncID='$IncID'";
    if ($conn->query($sql) === TRUE) {
        echo "Incident " . ($Status == 'Approved' ? 'approved' : 'rejected') . " successfully.";
    } else {
        echo "Error updating incident status: " . $conn->error;
    }
}

// Close database connection
$conn->close();
?>

</body>
</html>