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
                location.reload();
                
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
                 location.reload();
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
        <table class="table">
            <thead>
                <tr>
                    <th>RBr.</th>
                    <th>Model</th>
                    <th>SN</th>
                    <th>Ime objekta</th>
                    <th>Adresa Objekta</th>
                    <th>Datum slanja</th>
                    <th>Akcija</th>
                </tr>
            </thead>
            <tbody>
            <?php
$conn = mysqli_connect("localhost", "root", "", "printeri"); // Dodajte ime baze podataka
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT p.Rbr, p.Model, p.SN, p.Kategorija, p.Datum, o.ImeObjekta, o.AdresaObjekta
        FROM printer p
        JOIN objekti o ON p.ObjekatID = o.ImeObjekta
        WHERE p.Kategorija = 'LDC'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row["Kategorija"] == "LDC") {
            $datumstari = $row["Datum"];
            $datumNovo = \DateTime::createFromFormat("Y-m-d", $datumstari)->format("d.m.Y");

            echo "<tr>";
            echo "<td>" . $row["Rbr"] . "</td>";
            echo "<td>" . $row["Model"] . "</td>";
            echo "<td>" . $row["SN"] . "</td>";
            echo "<td>" . $row["ImeObjekta"] . "</td>";
            echo "<td>" . $row["AdresaObjekta"] . "</td>";
            echo "<td>" . $datumNovo . "</td>"; // Prikazujemo formatirani datum
            echo '<td>
                    <button type="button" class="btn btn-danger informatika-button" data-toggle="modal" data-target="#myModal_Servis" data-sn="' . $row["SN"] . '" data-kategorija="Informatika">Informatika</button>
                    <button type="button" class="btn btn-danger servis-button" data-toggle="modal" data-target="#myModal_Servis" data-sn="' . $row["SN"] . '" data-kategorija="Servis">Servis</button>
                  </td>';
            echo "</tr>";
        }
    }
} else {
    echo "<tr><td colspan='4'>Nema rezultata</td></tr>";
}


// Zatvaranje konekcije s bazom podataka
$conn->close();
?>

        </tbody>
        </table>
    </section>

</body>
</html>
