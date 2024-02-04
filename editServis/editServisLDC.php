<?php
$conn = mysqli_connect("localhost", "root", "", "printeri");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['SN'])) {
    $SN = $_GET['SN'];

    // Use prepared statement to avoid SQL injection
    $query = "UPDATE `printer` SET Kategorija = 'LDC' WHERE Kategorija = 'Servis' AND SN = ?";
    
    // Prepare the statement
    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "s", $SN);

    // Execute the statement
    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    echo "Query executed successfully!";
}
?>
