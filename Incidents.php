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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from form
    $Location = $_POST['Address'];
    $Name = $_POST['name']; // Changed from 'Name' to 'name'
    $Description = $_POST['Description'];
    $incidentImage = $_FILES['incidentImage']; // Corrected index name
    $DateCreated = date("Y-m-d");

    // File handling
    $imagefilename = $incidentImage['name'];
    $imagerfileerror = $incidentImage['error'];
    $imagefiletemp = $incidentImage['tmp_name'];

    // Check file extension
    $filename_separate = explode('.', $imagefilename);
    $file_extension = strtolower(end($filename_separate));

    // Allowed extensions
    $extension = array('jpeg', 'jpg', 'png');

    // Check if file extension is allowed
    if (in_array($file_extension, $extension)) {
        // File upload
        $upload_image = 'incidentImages/' . $imagefilename;
        move_uploaded_file($imagefiletemp, $upload_image);

        // SQL query to insert data into the database
        $sql = "INSERT INTO incident (Location, Name, Description, incidentImage, DateCreated) VALUES ('$Location', '$Name', '$Description', '$upload_image', '$DateCreated')";

        // Execute SQL query
        if ($conn->query($sql) === TRUE) {
            // Retrieve inserted incident ID
            $IncID = $conn->insert_id;
            // Show success message and redirect
            echo '<script>alert("Submitted successfully. Incident ID is: ' . $IncID . '. Use it to modify your incident.");</script>';
            echo "<script>window.location.href = 'Incidents.html';</script>";
            exit;
        } else {
            // Show error message if query fails
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        // Show error message if file extension is not allowed
        echo "Invalid file format. Allowed formats: JPG, JPEG, PNG.";
    }
}

// Close database connection
$conn->close();
?>
