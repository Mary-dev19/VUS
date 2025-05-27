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
    <script>
        function deleteIncident(incidentId) {
            // Add your delete incident logic here
        }
    </script>
</head>
<body>
<a href="Home.html">Go Back</a><br>
<h2>Incidents</h2>
<label for="location"><b>View Incidents:</b></label>
<form method="GET" action="viewIncidentsByLocation.php">
    <select name="location">
        <option value="select">Select</option>
        <option value="Abia">Abia</option>
        <option value="Hafoso">Hafoso</option>
        <option value="Lesia">Lesia</option>
        <option value="Hathetsne">Hathetsane</option>
        <option value="Katlehong">Katlehong</option>
        <option value="Qoaling">Qoaling</option>
        <option value="Masowe">Masowe</option>
        <option value="Sea point">Sea point</option>
        <option value="Naledi">Naledi</option>
        <option value="Khubetsoana">Khubetsoana</option>
    </select>
    <button type="submit">View</button>
</form>

<table>
    <tr>
        <th>Location</th>
        <th>Name</th>
        <th>Description</th>
        <th>Image</th>
        <th>Date Created</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
<?php
if (isset($_GET['location']) && $_GET['location'] !== 'select') {
    $location = $_GET['location'];
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
    $sql = "SELECT * FROM incident WHERE Status ='New' and location='$location'"; // Fixed SQL query

    $result = $conn->query($sql);

    // Check if there are any rows returned
    if ($result && $result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["Location"] . "</td>";
            echo "<td>" . $row["Name"] . "</td>";
            echo "<td>" . $row["Description"] . "</td>";
            echo '<td><img src="' . $row["incidentImage"] . '" width="100px" height="auto"></td>';
            echo "<td>" . $row["DateCreated"] . "</td>";
            echo "<td>" . $row["Status"] . "</td>";
              echo "<td class='button-container'>
                        <button onclick='deleteIncident(".$row["IncID"].")'>Delete</button>
                        <button onclick='updateIncident(".$row["IncID"].")'> Update</button>
                       </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No incidents found for the selected location</td></tr>";
    }

    // Close database connection
    $conn->close();
} elseif (isset($_GET['location']) && $_GET['location'] === 'select') {
    echo "<tr><td colspan='7'>Please select a location</td></tr>";
}
?>
</table>

<script>
    function deleteIncident(IncID) {
        if (confirm("Are you sure you want to delete this incident?")) {
            // AJAX request to delete the incident
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        // Handle response from the server
                        var response = xhr.responseText;
                        if (response == "success") {
                            // Display success message
                            alert("Incident deleted successfully.");
                            // Redirect to Home.html
                            window.location.href = "Home.html";
                        } else {
                            // Display error message
                            alert("Failed to delete incident.");
                        }
                    } else {
                        // Display error message for non-200 status
                        alert("Failed to delete incident. Server returned status: " + xhr.status);
                    }
                }
            };
            xhr.open("POST", "delete_incident.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("IncID=" + IncID);
        }
    }

    function updateIncident(IncID) {
        window.location.href = "update_incidents.php?IncID=" + IncID;
    }
</script>
</body>
</html>