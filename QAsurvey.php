<?php
session_start();
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $allo_id = $_POST["alloid"];
    $task_description = isset($_POST["task_description"]) ? $_POST["task_description"] : '';
    $decision = isset($_POST["decision"]) ? $_POST["decision"] : '';
    $comments = isset($_POST["comments"]) ? $_POST["comments"] : '';
    $rating = isset($_POST["rating"]) ? $_POST["rating"] : '';

    // Perform database operations
    $conn = mysqli_connect("localhost", "root", "", "vanguard");

    // Check connection
    if ($conn === false) {
        die("Error: Connection failed. " . mysqli_connect_error());
    }

    // Check if a survey form for the same allocation ID already exists
    $check_sql = "SELECT AlloID FROM qat WHERE AlloID = '$allo_id'";
    $check_result = mysqli_query($conn, $check_sql);

    // Check for query execution success
    if ($check_result === false) {
        echo "Error checking for existing survey form: " . mysqli_error($conn);
        exit;
    }

    // Check if a survey form already exists for this allocation ID
    if (mysqli_num_rows($check_result) > 0) {
        echo "A survey form for this allocation ID already exists. You cannot submit another one.";
        exit;
    }

    // Insert data into 'QAsurvey' table
    $insert_sql = "INSERT INTO qat (Ratings, Description, Decision, Comments, AlloID) 
                    VALUES ('$rating', '$task_description', '$decision', '$comments', '$allo_id')";

    if (mysqli_query($conn, $insert_sql)) {
        echo "Form submitted successfully.";

        // Update allocation status to "Surveyed"
        $update_sql = "UPDATE allocation SET Status = 'Surveyed' WHERE AlloID = '$allo_id'";
        if (mysqli_query($conn, $update_sql)) {
            echo "Allocation status updated to Surveyed successfully.";
        } else {
            echo "Error updating allocation status: " . mysqli_error($conn);
        }
    } else {
        echo "Error inserting form data: " . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
}
?>
