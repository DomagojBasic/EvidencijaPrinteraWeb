<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Printeri</title>
    
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    
    <!--Procedura za click INformatika -->
    <script>
$(document).ready(function() {
    // Korisnik klikne na btnInformatika
    $('.informatika-button').on('click', function(e) {
        e.preventDefault();

        // Dobavi SN i Kategorija vrijednost iz data-atributa
        var snValue = $(this).data('sn');
        var kategorijaValue = $(this).data('kategorija');

        // Izvrši AJAX poziv na editLDC.php
        $.ajax({
            type: 'GET',
            url: 'editLDC/editInformatika.php',
            data: { SN: snValue, Kategorija: kategorijaValue },
            success: function(response) {
                // Ovdje možete obraditi odgovor ako želite nešto prikazati korisniku
                console.log(response);
            },
            error: function(error) {
                // Ovdje možete obraditi pogreške ako dođe do problema s AJAX pozivom
                console.error('AJAX error:', error);
            }
        });
    });
});
</script>
 <!--Procedura za click Informatika -->

   <!--Procedura za click Servis -->
   <script>
$(document).ready(function() {
    // Korisnik klikne na btnInformatika
    $('.servis-button').on('click', function(e) {
        e.preventDefault();

        // Dobavi SN i Kategorija vrijednost iz data-atributa
        var snValue = $(this).data('sn');
        var kategorijaValue = $(this).data('kategorija');

        // Izvrši AJAX poziv na editLDC.php
        $.ajax({
            type: 'GET',
            url: 'editLDC/editLDCServis.php',
            data: { SN: snValue, Kategorija: kategorijaValue },
            success: function(response) {
                // Ovdje možete obraditi odgovor ako želite nešto prikazati korisniku
                console.log(response);
            },
            error: function(error) {
                // Ovdje možete obraditi pogreške ako dođe do problema s AJAX pozivom
                console.error('AJAX error:', error);
            }
        });
    });
});
</script>
 <!--Procedura za click Informatika -->


<body>

    <header class="header">
        <a href="#" class="logo">Plodine</a>
        <nav class="navbar">
            <a href="/index.php">Printeri u informatici</a>
            <a href="/printeriServis.php">Printeri na servisu</a>
            <a href="/printeriLDC.php">Printeri na LDC-u</a>
        </nav>
    </header>
    
    <section class="main-content">
        <h1>Printeri na LDC-u</h1>
        
        <table>
            <tr>
                <th>RBr.</th>
                <th>Model</th>
                <th>SN</th>
            </tr>

            <?php
            $conn = mysqli_connect("localhost", "root", "", "printeri");// Dodajte ime baze podataka
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT Rbr, Model, SN, Kategorija  FROM printer";
            $result = $conn->query($sql);

            if ($result->num_rows > 0 ) {
                while ($row = $result->fetch_assoc()) {
                    if ($row["Kategorija"] == "LDC") {
                        echo "<tr>";
                    echo "<td>" . $row["Rbr"] . "</td>";
                    echo "<td>" . $row["Model"] . "</td>";
                    echo "<td>" . $row["SN"] . "</td>";
                    echo '<td><a id="btnInformatika' . $row['Rbr'] . '" href="#" data-kategorija="' . $row['Kategorija'] . '" data-sn="' . $row['SN'] .'" class="btn btn-danger informatika-button">Informatika</a></td>';
                    echo '<td><a id="btnServis' . $row['Rbr'] . '" href="#" data-kategorija="' . $row['Kategorija'] . '" data-sn="' . $row['SN'] .'" class="btn btn-danger servis-button">Servis</a></td>';
                    echo "</tr>";
                    } else {
                       
                    }

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
