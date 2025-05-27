<?php
session_start();

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

$imageid = isset($_GET['IncID']) ? intval($_GET['IncID']) : 0;

if (isset($_POST['submit'])) {
    $location = $_POST['location'];
    $incident = $_POST['incident'];
    $description = $_POST['description'];
    $image = $_FILES['image'];

    $imagefilename = $image['name'];
    $imagefileerror = $image['error'];
    $imagefiletemp = $image['tmp_name'];

    $filename_separate = explode('.', $imagefilename);
    $file_extension = strtolower(end($filename_separate));

    $extension = array('jpeg', 'jpg', 'png','gif');
    if (in_array($file_extension, $extension)) {
        $upload_image = 'incidentImages/' . $imagefilename;
        move_uploaded_file($imagefiletemp, $upload_image);
        $sql = "UPDATE incident SET Location='$location', Name='$incident', Description='$description', incidentImage='$upload_image' WHERE IncID=$imageid";
        
        $result = $conn->query($sql);
        if ($result === TRUE) {
            echo '<script>alert("Updated.");</script>';
            exit;
        } else {
            die("Error: " . $conn->error);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Incident</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />   
   
</head>
<body bgcolor = "#F5F5F5" font="bold">
<div class="layer1">
    <div class="a">
        <a href="viewIncidentsByLocation.php"> HOME </a>
    </div>
</div>
<br/>
<div class="row"> 
    <div class="center">        
        <div class="col-md-9 col-md-offset-1 mx-auto">
            <div class="panel-body">
                <form id="incident" method="post" enctype="multipart/form-data">
                    <?php
                    $sql = "SELECT * FROM incident WHERE IncID=$imageid";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $location = $row['Location'];
                        $incident = $row['Name'];
                        $description = $row['Description'];
                        $incidentImage = $row['incidentImage'];
                        ?>
                        <div class="form-group">
                            <label for="location">Select Location</label>
                            <select id="location" name="location">
                                <option value="" disabled>location</option>
                                <?php
                                $locationOptions = array("Abia", "Hafoso", "Lesia", "Hathetsane", "Masowe", "Sea point", "Naledi", "Katlehong",  "Lower Thamae", "Qoaling",  "Khubetsoana");
                                foreach ($locationOptions as $option) {
                                    $selected = ($option == $location) ? 'selected' : '';
                                    echo "<option value='$option' $selected>$option</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="incident">Select Incident</label>
                            <select name="incident" required>
                                <option value="" disabled>incidents</option>
                                <?php
                                $incidentOptions = array("Streetlights malfunctioning", "Water pipe leakage", "Rainwater drainage", "Road reconstruction", "Garbage collection");
                                foreach ($incidentOptions as $option) {
                                    $selected = ($option == $incident) ? 'selected' : '';
                                    echo "<option value='$option' $selected>$option</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label><br>
                            <textarea id="description" name="description" rows="4"><?php echo isset($description) ? $description : ''; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="incidentImage">Current image</label><br/>
                            <?php echo "<img src='$incidentImage' alt='Incident Image' style='width: 80px;' >"; ?>
                        </div>
                        <div class="form-group">
                            <label for="image">Upload New Image</label><br>
                            <input type="file" name="image" id="image" required>
                        </div>
                        <button type="submit" name="submit" id="submit">UPDATE</button>
                        <?php
                    } else {
                        echo "No incident found.";
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
