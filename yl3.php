<?php
require_once 'config.php';

// Kui vormi on saatnud, siis lisame uue albumi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['artist']) && isset($_POST['album'])) {
        $artist = $_POST['artist'];
        $album = $_POST['album'];

        $sql = "INSERT INTO albumid (artist, album) VALUES ('$artist', '$album')";

        if ($conn->query($sql) === TRUE) {
            echo "Uus album lisatud edukalt";
        } else {
            echo "Viga lisamisel: " . $conn->error;
        }
    }
}

// Kui vormi on saadetud, siis muudame albumi andmeid
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_edit'])) {
    $id = $_POST['id_edit'];
    $artist = $_POST['artist_edit'];
    $album = $_POST['album_edit'];

    $sql = "UPDATE albumid SET artist='$artist', album='$album' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Album muudetud edukalt";
    } else {
        echo "Viga muutmisel: " . $conn->error;
    }
}

// Kui get päring on saadetud ja sisaldab id-d, kustutame albumi
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM albumid WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Album kustutatud edukalt";
    } else {
        echo "Viga kustutamisel: " . $conn->error;
    }
}

// Kõikide albumite kuvamine
$sql = "SELECT * FROM albumid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "Artist: " . $row["artist"] . " - Album: " . $row["album"];

        // Lisame kustutamise lingi
        echo " <a href='?delete=" . $row["id"] . "'>Kustuta</a>";

        // Lisame muutmise lingi
        echo " <a href='#' onclick='edit(" . $row["id"] . ", \"" . $row["artist"] . "\", \"" . $row["album"] . "\")'>Muuda</a>";
        echo "</div>";
    }
} else {
    echo "Andmeid ei leitud";
}
?>

<h2>Lisa uus album</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Artist: <input type="text" name="artist"><br>
    Album: <input type="text" name="album"><br>
    <input type="submit" value="Lisa">
</form>

<!-- Muuda albumi vorm -->
<div id="editForm" style="display:none;">
    <h2>Muuda albumit</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" id="id_edit" name="id_edit">
        Artist: <input type="text" id="artist_edit" name="artist_edit"><br>
        Album: <input type="text" id="album_edit" name="album_edit"><br>
        <input type="submit" value="Salvesta">
    </form>
</div>

<script>
// Funktsioon, mis täidab muutmise vormi väärtustega
function edit(id, artist, album) {
    document.getElementById("id_edit").value = id;
    document.getElementById("artist_edit").value = artist;
    document.getElementById("album_edit").value = album;
    document.getElementById("editForm").style.display = "block";
}
</script>

<?php
$conn->close();
?>
