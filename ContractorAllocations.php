<!DOCTYPE html>
<html>
<head>
    <title>Incidents Allocated to You</title>
</head>
<body>
    <h1>Incidents Allocated to You</h1>
    <table border='1'>
        <tr>
            <th>Location</th>
            <th>Incident Name</th>
            <th>Inspector Name</th>
            <th>Inspector Surname</th>
            <th>Allocation ID</th>
        </tr>  
        <?php
        session_start();
        // Enable error reporting
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Create connection
        $conn = mysqli_connect("localhost", "root", "", "vanguard");

        // Check connection
        if ($conn === false) {
            die("Error: Connection failed. " . mysqli_connect_error());
        }   

        // Check if ConID is set in session
        if(isset($_SESSION['ConID'])) {
            $conID = $_SESSION['ConID'];

            //Retrieve data 
            $sql = "SELECT incident.Location, incident.Name AS IncidentName, users.Name AS InspectorName, users.Surname, allocation.AlloID
                    FROM allocation
                    INNER JOIN incident ON allocation.IncID = incident.IncID
                    INNER JOIN users ON allocation.UserID = users.UserID
                    WHERE allocation.ConID = $conID";
            
            // Execute SQL query
            $result = mysqli_query($conn, $sql);

            // Check for query execution success
            if (!$result) {
                die("Error in SQL query: " . mysqli_error($conn));
            }

            // Check if there are results
            if (mysqli_num_rows($result) > 0){
                //retrieve data of each Row
                while ($row = mysqli_fetch_assoc($result)){
                    echo "<tr>
                              <td>" . $row["Location"] . "</td>
                              <td>" . $row["IncidentName"] . "</td>
                              <td>" . $row["InspectorName"] . "</td>
                              <td>" . $row["Surname"] . "</td>
                              <td>" . $row["AlloID"] . "</td>
                          </tr>";
                }
            } 
            else {
                echo "<tr><td colspan ='5'> No incidents Allocated to You!!</td></tr>";
            }
        } else {
            echo "Error: Contractor ID not set in session.";
        }

        // Close connection
        mysqli_close($conn);
        ?>
    </table>
</body>
</html>
