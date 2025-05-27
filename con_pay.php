<?php
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "vanguard");

// Check connection
if ($conn === false) {
    die("Error: Connection failed. " . mysqli_connect_error());
}

// Check if the AlloID is set in the URL
if (isset($_GET['alloID'])) {
    // Sanitize AlloID input to prevent SQL injection
    $alloID = mysqli_real_escape_string($conn, $_GET['alloID']);
    
    // Update the Payment column to 'Paid' for the specified AlloID
    $update_query = "UPDATE allocation SET Payment = 'Paid' WHERE AlloID = '$alloID'";
    if (mysqli_query($conn, $update_query)) {
        echo "Payment confirmed successfully.";
    } else {
        echo "Error updating payment: " . mysqli_error($conn);
    }
} else {
    echo "AlloID parameter is missing.";
}

// Close connection
mysqli_close($conn);
?>
