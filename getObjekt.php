<?php
$conn = mysqli_connect("localhost", "root", "", "printeri");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!empty($_POST["ImeObjekta"])) {
    $query = "SELECT * FROM objekti WHERE ImeObjekta = '" . $_POST["ImeObjekta"] . "' ORDER BY name ASC";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {
        $results = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        die("Query failed: " . mysqli_error($conn));
    }
}
?>

<option value disabled selected>Odaberi Objekt</option>
<?php
if (!empty($results)) {
    foreach ($results as $objekti) {
        ?>
        <option value="<?php echo $objekti["ImeObjekta"]; ?>"><?php echo $objekti["ImeObjekta"]; ?></option>
        <?php
    }
}
?>




