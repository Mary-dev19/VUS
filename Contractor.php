<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$vanguard = "vanguard";

$conn = new mysqli($servername, $username, $password, $vanguard);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['register'])) {
    // Form data
    $name = $_POST['Name'];
    $surname = $_POST['Surname'];
    $username = $_POST['Username'];
    $password = $_POST['Password'];
    $confirm = $_POST['Confirm'];
    $email = $_POST['Email'];
    $gender = $_POST['Gender'];
    $contacts = $_POST['Contacts'];
    $dob = $_POST['DOB'];
    $address = $_POST['Address'];
    $price = $_POST['price'];
    $service = $_POST['service'];

    // Insert contractor details into contractors table
    $stmt = $conn->prepare("INSERT INTO contractor (Name, Surname, Username, Password, Confirm, Email, Gender, DOB, Address, price, service, Contacts) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Error: " . $conn->error); // Check for error in preparing the statement
    }

    $stmt->bind_param("ssssssssssss", $name, $surname, $username, $password, $confirm, $email, $gender, $dob, $address, $price, $service, $contacts);
    if (!$stmt->execute()) {
        die("Error: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();

    // Display a success message
    echo "Contractor successfully registered.";
}
?>