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

    <?php
    require_once("DBController.php");
    $db_handle = new DBController();
    $query = "SELECT * FROM objekti";
    $results = $db_handle->runQuery($query);
    ?>
</head>

<body>
    <header class="header">
        <a href="#" class="logo">Plodine d.d.</a>
        <nav class="navbar">
            <a href="/index.php">Printeri u informatici</a>
            <a href="/printeriServis.php">Printeri na servisu</a>
            <a href="/printeriLDC.php">Printeri na LDC-u</a>
        </nav>
    </header>
    <section class="main-content">
        <h1>Zamjenski printeri u informatici</h1>
        <table class="table ">
            <thead class = "thead-bar">
                <tr>
                    <th scope="col">RBr.</th>
                    <th scope="col">Model</th>
                    <th scope="col">SN</th>
                    <th scope="col">Akcija</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Spajanje na bazu podataka
                $conn = mysqli_connect("localhost", "root", "", "printeri");

                // Provjera uspostavljanja veze
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                // SQL upit za dohvaćanje podataka o printerima
                $sql = "SELECT p.Rbr, p.Model, p.SN, p.Kategorija, o.ImeObjekta, o.AdresaObjekta
                        FROM printer p
                        JOIN objekti o ON p.ObjekatID = o.ImeObjekta
                        WHERE p.Kategorija = 'Informatika'";

                $result = $conn->query($sql);
                // Provjera rezultata upita
                if ($result->num_rows > 0) {
                    // Iteriranje kroz rezultate i ispisivanje redova tablice
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["Rbr"] . "</td>";
                        echo "<td>" . $row["Model"] . "</td>";
                        echo "<td>" . $row["SN"] . "</td>";
                        echo '<td>

                        <button type="button" class="btn btn-danger ldc-button" data-toggle="modal" data-target="#myModal_LDC" data-sn="' . $row["SN"] . '" data-kategorija="LDC" data-imeobjekta="' . $row["ImeObjekta"] . '">LDC</button>
                        <button type="button" class="btn btn-danger servis-button" data-toggle="modal" data-target="#myModal_Servis" data-sn="' . $row["SN"] . '" data-kategorija="Servis">Servis</button>
                        </td>';
                        echo "</tr>";
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

    <!----------------------------------------- Definiranje Modal-a za btnLDC ------------------------------------------------------------->
    <div class="modal fade" id="myModal_LDC" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="row">
            <h2 style="display: block; margin: 0 auto; width: 50%;">Odaberi objekt</h2>
        </div>
        <div class="row">
            <select name="objekt" id="objekt_list" class="InputBox" style="display: block; margin: 0 auto; width: 50%;">
                <option value="" disabled selected>Odaberi objekt</option>
                <?php
                foreach ($results as $objekt) {
                ?>
                    <option value="<?php echo $objekt["ImeObjekta"]; ?>">
                        <?php echo $objekt["ImeObjekta"]; ?>
                    </option>
                <?php
                }
                ?>
            </select>
            <button type="button" class="btn btn-danger spremi-button">Spremi</button>
            <button type="button" id="btnOdustani" class="btn btn-danger" onclick="window.location.href = 'index.php';">Odustani</button>
        </div>
    </div>
    <!----------------------------------------- Definiranje Modal-a za btnLDC ---------------------------------------------------------------->

    <!------------------------------------------ Pritiskom na btnLDC -------------------------------------------------------------------------->
    <script>

       // Otvaranje moda za LDC pritiskom na gumb "LDC"
$(".ldc-button").click(function() {
    $("#myModal_LDC").modal("show");
    // Pohrana vrijednosti SN i kategorije u varijable kada se klikne gumb "LDC"
    snValue = $(this).data('sn');
    kategorijaValue = $(this).data('kategorija');
});

// Postavljanje ImeObjekta prilikom odabira iz input polja
$("#objekt_list").change(function() {
    ImeObjekta = $(this).val();
});

// Postavljanje event handlera za gumb "Spremi"
$('.spremi-button').on('click', function(e) {
    e.preventDefault();
    // Izvrši AJAX s ažuriranom vrijednosti ImeObjekta
    console.log("imeobjekta", ImeObjekta);
    $.ajax({
        type: 'GET',
        url: 'editInformatika/editLDC.php',
        data: {
            SN: snValue,
            Kategorija: kategorijaValue,
            ImeObjekta: ImeObjekta
        },
        success: function(response) {
            console.log(response);
            location.reload();
            
        },
        error: function(error) {
            console.error('AJAX error:', error);
        }
    });
});
    </script>
    <!------------------------------------------ Pritiskom na btnLDC -------------------------------------------------------------------------->

    <!------------------------------------------ Pritiskom na btnServis -------------------------------------------------------------------------->
    <script>
        $('.servis-button').on('click', function(e) {
            e.preventDefault();

            // Dobavi SN i Kategorija vrijednost iz data-atributa
            var snValue = $(this).data('sn');
            var kategorijaValue = $(this).data('kategorija');
            console.log("Trenutna vrijednost SN-a:", snValue);
            console.log("kategorija:", kategorijaValue);

            // Izvrši AJAX
            $.ajax({
                type: 'GET',
                url: 'editInformatika/editServis.php',
                data: {
                    SN: snValue,
                    Kategorija: kategorijaValue
                },
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
    </script>
    <!------------------------------------------ Pritiskom na btnServis -------------------------------------------------------------------------->
</body>

</html>
