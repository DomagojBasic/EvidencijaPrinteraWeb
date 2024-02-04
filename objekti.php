<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objekti</title>
    
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


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
                <th>RBr.</th>
                <th>Ime objekta</th>
                <th>Adresa</th>
            </tr>

            <?php
            $conn = mysqli_connect("localhost", "root", "", "printeri");// Dodajte ime baze podataka
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT Rbr, ImeObjekta, AdresaObjekta FROM objekti";
            $result = $conn->query($sql);

            if ($result->num_rows > 0 ) {
                while ($row = $result->fetch_assoc()) {
                   
                        echo "<tr>";
                    echo "<td>" . $row["Rbr"] . "</td>";
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
