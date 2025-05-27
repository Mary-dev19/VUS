<?php
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "vanguard");

// Check connection
if ($conn === false) {
    die("Error: Connection failed. " . mysqli_connect_error());
}

// Retrieve approved users with Usertype 'Quality Assurance'
$approved_users_query = "SELECT * FROM users WHERE Usertype = 'Quality Assurance'";
$approved_users_result = mysqli_query($conn, $approved_users_query);

// Retrieve all approved contractors
$approved_contractors_query = "SELECT * FROM contractor WHERE status='approved'";
$approved_contractors_result = mysqli_query($conn, $approved_contractors_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User and Contractor Accounts</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            display: inline;
        }
    </style>
</head>
<body>

<h2>User and Contractor Accounts</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Reason</th>
        <th>Action</th>
    </tr>

    <?php
    // Display approved users
    while ($row = mysqli_fetch_assoc($approved_users_result)) {
        echo "<tr>";
        echo "<td>" . $row['UserID'] . "</td>";
        echo "<td>" . $row['Name'] . "</td>";
        echo "<td>" . $row['Email'] . "</td>";
        echo "<td>
                <form action='insert_request.php' method='POST'>"; // Changed action to 'insert_request.php'
        echo "<input type='hidden' name='userID' value='" . $row['UserID'] . "'>"; // Passing UserID as a hidden field
        echo "<input type='radio' name='reason' value='Update' checked> Update"; // Radio button for Update, initially checked
        echo "<input type='radio' name='reason' value='Delete'> Delete"; // Radio button for Delete
        echo "</td>";
        echo "<td><button type='submit' name='sendRequest'>Send Request</button></form></td>"; // Changed button name to 'sendRequest'
        echo "</tr>";
    }

    // Display approved contractors
    while ($row = mysqli_fetch_assoc($approved_contractors_result)) {
        echo "<tr>";
        echo "<td>" . $row['ConID'] . "</td>";
        echo "<td>" . $row['Name'] . "</td>";
        echo "<td>" . $row['Email'] . "</td>";
        echo "<td>
                <form action='con_request.php' method='POST'>"; // Changed action to 'insert_request.php'
        echo "<input type='hidden' name='conID' value='" . $row['ConID'] . "'>"; // Passing ConID as a hidden field
        echo "<input type='radio' name='reason' value='Update' checked> Update"; // Radio button for Update, initially checked
        echo "<input type='radio' name='reason' value='Delete'> Delete"; // Radio button for Delete
        echo "</td>";
        echo "<td><button type='submit' name='sendRequest'>Send Request</button></form></td>"; // Changed button name to 'sendRequest'
        echo "</tr>";
    }
    ?>

</table>

</body>
</html>

<?php
// Close connection
mysqli_close($conn);
?>
