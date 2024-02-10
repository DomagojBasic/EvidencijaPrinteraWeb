<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objekti</title>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">


<body>

    <header class="header">
        <a href="#" class="logo">Plodine</a>
        <nav class="navbar">
            <a href="/index.php">Printeri u informatici</a>
            <a href="/printeriServis.php">Printeri na servisu</a>
            <a href="/printeriLDC.php">Printeri na LDC-u</a>
            <a href="/objekti.php">Objekti</a>
        </nav>
    </header>
    
    <section class="main-content">
        <h1>Objekti</h1>
        
        <table>
            <tr>
                <th>Ime objekta</th>
                <th>Adresa</th>
            </tr>

            <?php
            $conn = mysqli_connect("localhost", "root", "", "printeri");// Dodajte ime baze podataka
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT ImeObjekta, AdresaObjekta FROM objekti";
            $result = $conn->query($sql);

            if ($result->num_rows > 0 ) {
                while ($row = $result->fetch_assoc()) {
                   
                        echo "<tr>";
                    echo "<td>" . $row["ImeObjekta"] . "</td>";
                    echo "<td>" . $row["AdresaObjekta"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>Nema rezultata</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </section>

</body>
</html>
