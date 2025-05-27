<?php
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "vanguard");

// Check connection
if ($conn === false) {
    die("Error: Connection failed. " . mysqli_connect_error());
}

// Initialize variables to store error messages and success message
$updateError = "";
$successMessage = "";

// Check if the user has submitted the update form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateContractor'])) {
    // Check if all fields are filled
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['ConID'])) {
        $updateError = "All fields are required.";
    } else {
        // If all fields are filled, proceed with updating the contractor
        $ConID = $_POST['ConID'];
        $name = $_POST['name'];
        $email = $_POST['email'];

        // Update contractor in contractors table
        $update_query = "UPDATE contractor SET Name='$name', Email='$email' WHERE ConID='$ConID'";
        $update_result = mysqli_query($conn, $update_query);
        if (!$update_result) {
            die("Error updating contractor: " . mysqli_error($conn));
        }

        // Delete the record from the con_request table
        $delete_request_query = "DELETE FROM con_request WHERE ConID='$ConID'";
        $delete_request_result = mysqli_query($conn, $delete_request_query);
        if (!$delete_request_result) {
            die("Error deleting record from con_request table: " . mysqli_error($conn));
        }

        // Set success message
        $successMessage = "Contractor updated successfully.";
    }
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Contractor</title>
</head>
<body>

<h2>Update Contractor</h2>
<form method='POST' action='' id='updateForm'>
    <span style="color: red;"><?php echo $updateError; ?></span><br>
    ContractorID: <input type='text' name='ConID' readonly value='<?php echo isset($_POST['ConID']) ? $_POST['ConID'] : ''; ?>'><br>
    Name: <input type='text' name='name' value='<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>' required><br>
    Email: <input type='text' name='email' value='<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>' required><br>
    <input type='submit' name='updateContractor' value='Update'>
</form>

<?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateContractor'])): ?>
    <?php if ($successMessage !== ""): ?>
        <script>
            // Display success message using JavaScript
            alert("<?php echo $successMessage; ?>");
            // Redirect to Home page
            window.location.href = 'AdminDash.html';
        </script>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>
