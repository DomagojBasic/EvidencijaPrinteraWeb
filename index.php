<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Printeri</title>

    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!--Procedura za click LDC -->
    <script>
        $(document).ready(function () {
            // Korisnik klikne na btnLDC
            $('.ldc-button').on('click', function (e) {
                e.preventDefault();

                // Dobavi SN i Kategorija vrijednost iz data-atributa
                var snValue = $(this).data('sn');
                var kategorijaValue = $(this).data('kategorija');

                // Izvrši AJAX poziv na editLDC.php
                $.ajax({
                    type: 'GET',
                    url: 'editInformatika/editLDC.php',
                    data: {
                        SN: snValue,
                        Kategorija: kategorijaValue
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
    <!--Procedura za click LDC -->
    <!--Procedura za click Servis -->
    <script>
        $(document).ready(function () {
            // Korisnik klikne na btnLDC
            $('.servis-button').on('click', function (e) {
                e.preventDefault();

                // Dobavi SN i Kategorija vrijednost iz data-atributa
                var snValue = $(this).data('sn');
                var kategorijaValue = $(this).data('kategorija');

                // Izvrši AJAX poziv na editLDC.php
                $.ajax({
                    type: 'GET',
                    url: 'editInformatika/editServis.php',
                    data: {
                        SN: snValue,
                        Kategorija: kategorijaValue
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
    <!--Procedura za click Servis -->
    <script type="text/javascript">
        function getObjekt(val) {
            $.ajax({
                type: "POST",
                url: "getObjekt.php",
                data: 'ImeObjekta=' + val,
                success: function (data) {
                    $("#objekt_list").html(data);
                }
            })
        }
    </script>

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
            <a href="/objekti.php">Objekti</a>
        </nav>
    </header>
    <section class="main-content">
        <h1>Zamjenski printeri u informatici</h1>
        <table>
            <tr>
                <th>RBr.</th>
                <th>Model</th>
                <th>SN</th>
                <!-- Button trigger modal -->
                <div id="myModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <p>Odaberite Objekt</p>
                        <div class="row">
                            <select name="objekt" id="objekt_list" class="InputBox" onChange="getObjekt(this.value);">
                                <option value="" disabled selected></option>
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
                        <button type="btnSpremi" class="btn btn-danger">Spremi</button>
                    </div>
                </div>
            </tr>

            <?php
            $conn = mysqli_connect("localhost", "root", "", "printeri");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT Rbr, Model, SN, Kategorija  FROM printer";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($row["Kategorija"] == "Informatika") {
                        echo "<tr>";
                        echo "<td>" . $row["Rbr"] . "</td>";
                        echo "<td>" . $row["Model"] . "</td>";
                        echo "<td>" . $row["SN"] . "</td>";
                        echo '<td><a id="btnLDC_' . $row['Rbr'] . '" href="#" data-kategorija="' . $row['Kategorija'] . '" data-sn="' . $row['SN'] . '" class="btn btn-danger ldc-button">LDC</a></td>';
                        echo '<td><a id="btnServis_' . $row['Rbr'] . '" href="#" data-kategorija="' . $row['Kategorija'] . '" data-sn="' . $row['SN'] . '" class="btn btn-danger servis-button">Servis</a></td>';
                        echo "</tr>";

                        // Generate script block for each row
                        echo '<script>
                                document.getElementById("btnLDC_' . $row['Rbr'] . '").addEventListener("click", function() {
                                    document.getElementById("myModal").style.display = "block";
                                });

                                document.getElementsByClassName("close")[0].addEventListener("click", function() {
                                    document.getElementById("myModal").style.display = "none";
                                });
                            </script>';
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
