<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Initialize the message variable
$message = "";

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Get selected values
    $IncID = $_POST['incident'];
    $ConID = $_POST['contractor'];
    $UserID = $_POST['inspector'];

    // Insert allocation into the database
    $sql_allocation = "INSERT INTO allocation (IncID, ConID, UserID) VALUES ('$IncID', '$ConID', '$UserID')";

    if ($conn->query($sql_allocation) === TRUE) {
        // Update incident status to 'Allocated'
        $sql_update_incident = "UPDATE incident SET Status = 'Allocated' WHERE IncID = '$IncID'";

        if ($conn->query($sql_update_incident) === TRUE) {
            // Set the message if allocation is successful
            $message = "Incident allocated successfully.";
        } else {
            $message = "Error updating incident status: " . $conn->error;
        }
    } else {
        $message = "Error allocating incident: " . $conn->error;
    }
}

// Retrieve incidents with status 'Approved'
$sql_incident = "SELECT * FROM incident WHERE Status = 'Approved'";
$result_incident = $conn->query($sql_incident);

if (!$result_incident) {
    die("Error fetching incidents: " . $conn->error);
}

// Start the form
echo "<form method='POST' action='".$_SERVER['PHP_SELF']."'>";
echo "<label for='incident'>Incident:</label>";
echo "<select id='incident' name='incident'>";
echo "<option value=''>Select Incident</option>";

// Populate the incident dropdown
while ($row_incident = $result_incident->fetch_assoc()) {
    echo "<option value='".$row_incident['IncID']."'>".$row_incident['Name']."</option>";
}

echo "</select>";

// Retrieve contractors with status 'Approved'
$sql_contractor = "SELECT * FROM contractor WHERE Status = 'Approved'";
$result_contractor = $conn->query($sql_contractor);

if (!$result_contractor) {
    die("Error fetching contractors: " . $conn->error);
}

echo "<br><br>";
echo "<label for='contractor'>Contractor:</label>";
echo "<select id='contractor' name='contractor'>";
echo "<option value=''>Select Contractor</option>";

// Populate the contractor dropdown
while ($row_contractor = $result_contractor->fetch_assoc()) {
    echo "<option value='".$row_contractor['ConID']."'>".$row_contractor['Name']."</option>";
}

echo "</select>";

// Retrieve inspectors with usertype 'Quality Assurance'
$sql_inspector = "SELECT * FROM users WHERE usertype = 'Quality Assurance'";
$result_inspector = $conn->query($sql_inspector);

if (!$result_inspector) {
    die("Error fetching inspectors: " . $conn->error);
}

echo "<br><br>";
echo "<label for='inspector'>Inspector:</label>";
echo "<select id='inspector' name='inspector'>";
echo "<option value=''>Select Inspector</option>";

// Populate the inspector dropdown
while ($row_inspector = $result_inspector->fetch_assoc()) {
    echo "<option value='".$row_inspector['UserID']."'>".$row_inspector['Name']."</option>";
}

echo "</select>";

echo "<br><br>";
echo "<input type='submit' name='submit' value='Allocate'>";
echo "</form>";

// Display the message if it's set
if (!empty($message)) {
    echo "<br>";
    echo "<p>".$message."</p>";
}

// Close the database connection
$conn->close();
?>