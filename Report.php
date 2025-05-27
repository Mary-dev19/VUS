<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $incident_id = $_POST["incident_id"];
    $hours = $_POST["hours"];
    $description = $_POST["description"];
    $fixing_date = date('dmY', strtotime($_POST["fixing_date"]));
    $user_id = $_POST["user_id"];
    $comment = $_POST["comment"];
    $alloID = $_POST["alloid"]; // Assuming this is the ID for allocation

    // Perform database operations
    $mysqli = new mysqli("localhost", "root", "", "vanguard");

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Sanitize incident_id
    $incident_id = $mysqli->real_escape_string($incident_id);

    // Check if a report for this incident already exists
    $existing_report_query = "SELECT * FROM conr WHERE IncID = '$incident_id'";
    $existing_report_result = $mysqli->query($existing_report_query);

    if ($existing_report_result && $existing_report_result->num_rows > 0) {
        // Report already exists for this incident
        echo "Error: Report for this incident already exists.";
    } else {
        // Fetch Date Created from the incident table based on incident_id
        $incident_date_query = "SELECT DateCreated FROM incident WHERE IncID = '$incident_id'";
        $incident_date_result = $mysqli->query($incident_date_query);
        if ($incident_date_result) {
            if ($incident_date_result->num_rows > 0) {
                $row = $incident_date_result->fetch_assoc();
                $created_date = $row["DateCreated"]; // Keep the date format as it is
            } else {
                die("Error: Incident not found.");
            }
        } else {
            die("Error executing incident date query: " . $mysqli->error);
        }

        // Insert data into 'conr' table
        $insert_sql = "INSERT INTO conr (IncID, Description, FixingDate, `Date Created`, UserID, Comment, Hours) 
                        VALUES ('$incident_id', '$description', '$fixing_date', '$created_date', '$user_id', '$comment', '$hours')";

        if ($mysqli->query($insert_sql) === TRUE) {
            echo "New record created successfully.";
        } else {
            echo "Error: " . $insert_sql . "<br>" . $mysqli->error;
        }

        // Update allocation status in 'allocations' table
        $update_alloc_sql = "UPDATE allocation SET Status = 'Done' WHERE AlloID = '$alloID'";

        if ($mysqli->query($update_alloc_sql) === TRUE) {
            echo "Allocation status updated successfully.";
        } else {
            echo "Error updating allocation status: " . $mysqli->error;
        }

        // Update status in 'incident' table to 'Done'
        $update_incident_sql = "UPDATE incident SET Status = 'Done' WHERE IncID = '$incident_id'";

        if ($mysqli->query($update_incident_sql) === TRUE) {
            echo "Incident status updated successfully.";
        } else {
            echo "Error updating incident status: " . $mysqli->error;
        }
    }

    // Close connection
    $mysqli->close();
}
?>
