<?php
$conn = mysqli_connect("localhost", "root", "", "printeri");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['SN']) && isset($_GET['ImeObjekta'])) {
    $SN = $_GET['SN'];
    $ImeObjekta = $_GET['ImeObjekta'];
    $informatika = 'Informatika';

    // Prepare the statement
    $query = "UPDATE printer p 
              JOIN objekti o ON p.ObjekatID = o.ImeObjekta
              SET p.Kategorija = 'LDC', p.ObjekatID = ?, p.Datum = CURRENT_DATE()
              WHERE p.Kategorija = ? AND p.ObjekatID = ? AND p.SN = ?";

    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        die("Preparation failed: " . mysqli_error($conn));
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ssss", $ImeObjekta, $informatika, $informatika, $SN);

    // Execute the statement
    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        die("Query execution failed: " . mysqli_error($conn));
    }

    echo "Query executed successfully!";
}
?>
