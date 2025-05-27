<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contractor Approvals</title>
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
<h2> contactor Rejections/Approvals</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Surname</th>
        <th>Service</th>
        <th>Price</th>
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

    // Handle form submission
    if (isset($_POST['contractor_approval'])) {
        $conID = $_POST['contractor_approval'];
        if (isset($_POST['approve_contractor'])) {
            // Update contractor status to Approved
            $updateSql = "UPDATE contractor SET Status='Approved' WHERE ConID='$conID'";
            if ($conn->query($updateSql) === TRUE) {
                echo "Contractor approved successfully.";
            } else {
                echo "Error updating contractor: " . $conn->error;
            }
        } elseif (isset($_POST['reject_contractor'])) {
            // Update contractor status to Rejected
            $updateSql = "UPDATE contractor SET Status='Rejected' WHERE ConID='$conID'";
            if ($conn->query($updateSql) === TRUE) {
                echo "Contractor rejected successfully.";
            } else {
                echo "Error updating contractor: " . $conn->error;
            }
        }
    }

    // SQL query to retrieve data from contractor table
    $sql = "SELECT * FROM contractor WHERE Status='Applied'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["ConID"] . "</td>";
            echo "<td>" . $row["Name"] . "</td>";
            echo "<td>" . $row["Surname"] . "</td>";
            echo "<td>" . $row["Service"] . "</td>";
            echo "<td>" . $row["Price"] . "</td>";
            echo "<td>" . $row["Status"] . "</td>";
            echo "<td class='action-buttons'>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='contractor_approval' value='" . $row["ConID"] . "'>";
            echo "<input type='submit' name='approve_contractor' value='Approve'>";
            echo "<input type='submit' name='reject_contractor' value='Reject'>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No contractors awaiting action.</td></tr>";
    }
    ?>
</table>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>