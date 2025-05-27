<?php
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "vanguard");

// Check connection
if ($conn === false) {
    die("Error: Connection failed. " . mysqli_connect_error());
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sendRequest'])) {
    // Check if the request is for a contractor
    if (isset($_POST['conID'])) {
        $conID = $_POST['conID'];
        
        // Retrieve contractor information
        $contractor_query = "SELECT * FROM contractor WHERE ConID = $conID";
        $contractor_result = mysqli_query($conn, $contractor_query);
        
        if (!$contractor_result) {
            echo "Error fetching contractor information: " . mysqli_error($conn);
            exit;
        }
        
        $contractor_row = mysqli_fetch_assoc($contractor_result);
        
        // Extract relevant information
        $name = $contractor_row['Name'];
        $surname = $contractor_row['Surname'];
        $email = $contractor_row['Email'];
        
        // Set the Reason based on the selected option
        $reason = $_POST['reason'] == 'Update' ? 'Update User' : 'Delete User';
        
        // Insert the request into the 'con_request' table
        $insert_query = "INSERT INTO con_request (ConID, Name, Surname, Email, Reason) 
                         VALUES ('$conID', '$name', '$surname', '$email', '$reason')";
        
        if (mysqli_query($conn, $insert_query)) {
            echo "Request sent successfully.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
    echo "Invalid request.";
}

// Close connection
mysqli_close($conn);
?>
