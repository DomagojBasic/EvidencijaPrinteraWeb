<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Printeri</title>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="style.css">

</head>

<body>
    <header class="header">
        <a href="#" class="logo">Plodine d.d.</a>
        <nav class="navbar">
            <a href="/index.php">Printeri u informatici</a>
            <a href="/printeriServis.php">Printeri na servisu</a>
            <a href="/printeriLDC.php">Printeri na LDC-u</a>
            <a href="/objekti.php">Objekti</a>
        </nav>
    </header>
    <section class="main-content">
        <h1>Zamjenski printeri u informatici</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>RBr.</th>
                    <th>Model</th>
                    <th>SN</th>
                    <th>Akcija</th>
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
                $sql = "SELECT Rbr, Model, SN FROM printer WHERE Kategorija = 'Informatika'";
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
                        
                        <button type="button" class="btn btn-danger ldc-button" data-toggle="modal" data-target="#myModal_LDC">LDC</button>

                                <button type="button" class="btn btn-danger servis-button" data-toggle="modal" data-target="#myModal_Servis">Servis</button>
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

    <!-- Modal za LDC -->
    <div class="modal fade" id="myModal_LDC" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="row">
            <select name="objekt" id="objekt_list" class="InputBox">
                <option value="" disabled selected>Odaberi objekt</option>
                <?php
                foreach ($results as $objketi) {
                    ?>
                    <option value="<?php echo $objketi["ImeObjekta"]; ?>">
                        <?php echo $objketi["ImeObjekta"]; ?>
                    </option>
                <?php
                }
                ?>
            </select>
        </div>
        <button type="button" class="btn btn-danger">Spremi</button>
        <button type="button"id="btnOdustani" class="btn btn-danger">Odustani</button>
        <!-- Sadržaj modala za LDC -->
    </div>

    <!-- Modal za Servis -->
    <div class="modal fade" id="myModal_Servis" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <!-- Sadržaj modala za Servis -->
    </div>

    <script>
    // JavaScript kod za upravljanje modalskim dijalozima
    $(document).ready(function () {
        // Otvaranje moda za LDC pritiskom na gumb "LDC"
        $(".ldc-button").click(function () {
            $("#myModal_LDC").modal("show");
        });

        // Otvaranje moda za Servis pritiskom na gumb "Servis"
        $(".servis-button").click(function () {
            // Dohvaćanje podataka iz reda tablice
            var snValue = $(this).closest("tr").find("td:eq(2)").text(); // SN vrijednost

            // AJAX poziv za promjenu kategorije u "Servis"
            $.ajax({
                type: 'GET',
                url: 'editInformatika/editServis.php',
                data: {
                    SN: snValue,
                    Kategorija: 'Servis'
                },
                success: function (response) {
                    // Ovdje možete obraditi odgovor ako želite nešto prikazati korisniku
                    console.log(response);
                },
                error: function (error) {
                    // Ovdje možete obraditi pogreške ako dođe do problema s AJAX pozivom
                    console.error('AJAX error:', error);
                }
            });
        });
    });
</script>
    
</body>

</html>
