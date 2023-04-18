<?php

$hotels = [

    [
        'name' => 'Hotel Belvedere',
        'description' => 'Hotel Belvedere Descrizione',
        'parking' => true,
        'vote' => 4,
        'distance_to_center' => 10.4
    ],
    [
        'name' => 'Hotel Futuro',
        'description' => 'Hotel Futuro Descrizione',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 2
    ],
    [
        'name' => 'Hotel Rivamare',
        'description' => 'Hotel Rivamare Descrizione',
        'parking' => false,
        'vote' => 1,
        'distance_to_center' => 1
    ],
    [
        'name' => 'Hotel Bellavista',
        'description' => 'Hotel Bellavista Descrizione',
        'parking' => false,
        'vote' => 5,
        'distance_to_center' => 5.5
    ],
    [
        'name' => 'Hotel Milano',
        'description' => 'Hotel Milano Descrizione',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 50
    ],

];

$isParkingFilterActive = $_GET["parking"] ?? "off";
$minVote = (int) ($_GET["vote"] ?? 0);
$numResults = 0;

?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Hotel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>

<body>
    <h1>PHP Hotel</h1>

    <form action="index.php" method="get">
        <label for="checkbox-parking">Parcheggio disponibile</label>
        <input type="checkbox" name="parking" id="checkbox-parking" <?php echo $isParkingFilterActive == "on" ? "checked" : ""; ?>>

        <br>

        <label for="input-vote">Voto</label>
        <input type="number" min="0" name="vote" id="input-vote" placeholder="Inserisci voto minimo" <?php echo $minVote > 0 ? "value='{$minVote}'" : "" ?>>

        <br>

        <input type="submit" value="Filtra">
    </form>

    <table class="table">
        <thead>
            <tr>
                <?php
                // Ciclo il primo oggetto dell'array(sarebbe andato bene uno qualsiasi) per prendere i nomi delle chiavi da inserire in testa alla tabella
                foreach ($hotels[0] as $key => $value) {
                    ?>

                    <th scope="col">
                        <?php
                        echo $key;
                        ?>
                    </th>

                    <?php
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            // Tramite due cicli annidati:
            // - con il primo scorro tutti gli oggetti hotel
            // - con il secondo all'interno di ogni oggetto hotel leggo il valore di ognuno dei campi presenti
            foreach ($hotels as $hotel) {
                // Considera l'hotel solo se:
                // - non è attivo nessun filtro
                // - è attivo il filtro sul parcheggio e l'hotel ha il parcheggio
                // - il voto minimo dell'hotel è >= a quello impostato nel filtro di ricerca (in caso non fosse presente 0)
                if (($isParkingFilterActive == "off" || ($isParkingFilterActive == "on" && $hotel["parking"] == "yes")) && $hotel["vote"] >= $minVote) {
                    $numResults++;
                    ?>

                    <tr>
                        <?php
                        foreach ($hotel as $key => $value) {
                            ?>

                            <td>
                                <?php
                                // Nel caso in cui stia leggendo il campo con chiave "parking" associo i valori (true, false) alla stampa di (yes, no)
                                // Altrimenti stampo il valore così come è
                                if ($key == "parking") {
                                    if ($value) {
                                        echo "yes";
                                    } else {
                                        echo "no";
                                    }
                                } else {
                                    echo $value;
                                }
                                ?>
                            </td>

                            <?php
                        }
                        ?>
                    </tr>

                    <?php
                }
            }
            ?>
        </tbody>
    </table>

    <?php
    // In caso ci fosse almeno un risultato stampo il numero di risultati ottenuti dalla ricerca
    // Altrimenti avviso l'utente che non ci sono risultati corrispondenti con i criteri selezionati
    if ($numResults > 0) {
        echo "<p>Risultati trovati: {$numResults}</p>";
    } else {
        echo "<p>Non è stato possibile trovare risultati con i criteri selezionati.</p>";
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>