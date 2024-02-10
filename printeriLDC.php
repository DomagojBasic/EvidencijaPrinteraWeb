<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Printeri</title>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    
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
            <thead class = "thead-bar">
                <tr>
                    <th scope="col">RBr.</th>
                    <th scope="col">Model</th>
                    <th scope="col">SN</th>
                    <th scope="col">Ime objekta</th>
                    <th scope="col">Adresa Objekta</th>
                    <th scope="col">Datum slanja</th>
                    <th scope="col">Akcija</th>
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
