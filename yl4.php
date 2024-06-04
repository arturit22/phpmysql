<?php
include('config.php');

$sql = "SELECT arved.arve_nr, albumid.artist, albumid.album, kliendid.eesnimi
        FROM arved 
        JOIN albumid ON arved.albumid_id = albumid.id
        JOIN kliendid ON arved.kliendid_id = kliendid.id";

$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        while ($rida = $result->fetch_assoc()) {
            echo 'Arve number: ' . $rida['arve_nr'] . '<br>';
            echo 'Toote nimetus: ' . $rida['artist'] . ' - ' . $rida['album'] . '<br>';
            echo 'Kliendi eesnimi: ' . $rida['eesnimi'] . '<br><br>';
        }
        $result->free();
    } else {
        echo "Andmeid ei leitud";
    }
} else {
    echo "Viga: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
