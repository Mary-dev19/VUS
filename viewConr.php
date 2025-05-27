<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "vanguard");

// Check connection
if ($conn === false) {
    die("Error: Connection failed. " . mysqli_connect_error());
}

// Fetch all data from the "conr" table
$query = "SELECT * FROM conr";
$result = mysqli_query($conn, $query);

// Check if any rows were returned
if (mysqli_num_rows($result) > 0) {
    // Display table header
    echo "<table style='border: 1px solid black;'>";
    echo "<tr>
            <th style='border: 1px solid black;'>RepID</th>
            <th style='border: 1px solid black;'>IncID</th>
            <th style='border: 1px solid black;'>Hours</th>
            <th style='border: 1px solid black;'>Description</th>
            <th style='border: 1px solid black;'>FixingDate</th>
            <th style='border: 1px solid black;'>UserID</th>
            <th style='border: 1px solid black;'>Comment</th>
          </tr>";
          
    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td style='border: 1px solid black;'>" . $row["RepID"] . "</td>";
        echo "<td style='border: 1px solid black;'>" . $row["IncID"] . "</td>";
        echo "<td style='border: 1px solid black;'>" . $row["Hours"] . "</td>";
        echo "<td style='border: 1px solid black;'>" . $row["Description"] . "</td>";
        echo "<td style='border: 1px solid black;'>" . $row["FixingDate"] . "</td>";
        echo "<td style='border: 1px solid black;'>" . $row["UserID"] . "</td>";
        echo "<td style='border: 1px solid black;'>" . $row["Comment"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No data found in the 'conr' table.";
}

// Close connection
mysqli_close($conn);
?>