<?php
session_start();

// Check if contractor is logged in
if(isset($_SESSION['ConID'])) {
    // DB credentials.
    define('DB_HOST','localhost');
    define('DB_USER','root');
    define('DB_PASS','');
    define('DB_NAME','vanguard');

    try {
        // Establish database connection
        $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Get contractor ID from session
        $ConID = $_SESSION['ConID'];

        // Query to retrieve QAID and Ratings for the logged-in contractor
        $query = "SELECT QAID, Ratings
                  FROM qat qr
                  INNER JOIN allocation a ON qr.AlloID = a.AlloID
                  WHERE a.ConID = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$ConID]);
        $ratings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display ratings in a table
        echo "<h2>Your Ratings:</h2>";
        echo "<table border='1'>";
        echo "<tr><th>QAID</th><th>Ratings</th></tr>";
        foreach ($ratings as $rating) {
            echo "<tr>";
            echo "<td>" . $rating['QAID'] . "</td>";
            echo "<td>" . $rating['Ratings'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        // Link to contractor's dashboard
        echo "<p><a href='contractorDash.html'>Go Back</a></p>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redirect to login page if contractor is not logged in
    header("Location: login.php");
    exit();
}
?>
