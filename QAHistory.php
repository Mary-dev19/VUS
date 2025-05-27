<?php
session_start();

// Check if UserID is set in session
if(isset($_SESSION['UserID'])) {
    // DB credentials.
    define('DB_HOST','localhost');
    define('DB_USER','root');
    define('DB_PASS','');
    define('DB_NAME','vanguard');

    try {
        // Establish database connection
        $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Get UserID from session
        $userID = $_SESSION['UserID'];

        // Retrieve contractor information based on UserID
        $query = "SELECT a.*, c.Name AS ContractorName, c.Surname AS ContractorSurname
                  FROM allocation a
                  INNER JOIN contractor c ON a.ConID = c.ConID
                  WHERE a.UserID = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$userID]);
        $allocations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display allocation history
        // Adjust the table structure and display logic according to your needs
        if($allocations) {
            echo "<h2>Allocation History:</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Allocation ID</th><th>Incident ID</th><th>Contractor Name</th><th>Contractor Surname</th><th>Status</th></tr>";
            foreach ($allocations as $allocation) {
                echo "<tr>";
                echo "<td>" . $allocation['AlloID'] . "</td>";
                echo "<td>" . $allocation['IncID'] . "</td>";
                echo "<td>" . $allocation['ContractorName'] . "</td>";
                echo "<td>" . $allocation['ContractorSurname'] . "</td>";
                echo "<td>" . $allocation['Status'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
			echo "<p><a href='QualityDash.html'>Go Back</a></p>";
        } else {
            echo "No allocations found for this user.";
            // Handle the case where no allocations are found
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redirect to login page if UserID is not set in session
    header("Location: login.php");
    exit();
}
?>
