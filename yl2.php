<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
require_once 'config.php';

$sql = "SELECT * FROM albumid";
$result = $conn->query($sql);

if ($result === false) {
    die("Päring ebaõnnestus: " . $conn->error);
}


echo "<h1>1</h1>";
if ($result->num_rows > 0) {
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    
    foreach ($rows as $row) {
        echo "ID: " . $row["id"]. " - Artist: " . $row["artist"]. " - Aasta: " . $row["aasta"].  " - Hind: " . $row["hind"]. "<br>";
    }
} else {
    echo "Tulemusi ei leitud";
}

echo "<br>";
echo "<h1>2</h1>";

$sql2 = "SELECT artist, album FROM albumid ORDER BY artist ASC LIMIT 10";
$result2 = $conn->query($sql2);
if ($result2->num_rows > 0) {
    while($row = $result2->fetch_assoc()) {
        echo "Artist: " . $row["artist"]. " - Album: " . $row["album"]. "<br>";
    }
} else {
    echo "Tulemusi ei leitud";
}



echo "<br>";
echo "<h1>3</h1>";
$sql3 = "SELECT artist, album FROM albumid WHERE aasta >= 2010";
$result3 = $conn->query($sql3);
if ($result3->num_rows > 0) {
    while($row = $result3->fetch_assoc()) {
        echo "Artist: " . $row["artist"]. " - Album: " . $row["album"]. "<br>";
    }
} else {
    echo "Tulemusi ei leitud";
}




echo "<br>";
echo "<h1>4</h1>";
$sql4 = "SELECT COUNT(DISTINCT album) AS albumite_arv, AVG(hind) AS keskmine_hind, SUM(hind) AS kogu_hind FROM albumid";
$result4 = $conn->query($sql4);
if ($result4->num_rows > 0) {
    $row = $result4->fetch_assoc();
    echo "Erinevate albumite arv: " . (isset($row["albumite_arv"]) ? $row["albumite_arv"] : "Puudub") . "<br>";
    echo "Keskmine hind: " . (isset($row["keskmine_hind"]) ? $row["keskmine_hind"] : "Puudub") . "<br>";
    echo "Koguväärtus: " . (isset($row["kogu_hind"]) ? $row["kogu_hind"] : "Puudub") . "<br>";
} else {
    echo "Tulemusi ei leitud";
}


echo "<br>";
echo "<h1>5</h1>";
$sql5 = "SELECT album FROM albumid ORDER BY aasta ASC LIMIT 1";
$result5 = $conn->query($sql5);
if ($result5->num_rows > 0) {
    $row = $result5->fetch_assoc();
    echo "Kõige vanema albumi nimi: " . $row["album"]. "<br>";
} else {
    echo "Tulemusi ei leitud";
}

echo "<br>";
echo "<h1>6</h1>";
$sql6 = "SELECT * FROM albumid WHERE hind > (SELECT AVG(hind) FROM albumid)";
$result6 = $conn->query($sql6);
if ($result6->num_rows > 0) {
    while($row = $result6->fetch_assoc()) {
        echo "Artist: " . $row["artist"]. " - Album: " . $row["album"]. " - Hind: " . $row["hind"]. "<br>";
    }
} else {
    echo "Tulemusi ei leitud";
}

echo "<br>";
echo "<h1>Otsi</h1>";
if(isset($_GET['search_type'], $_GET['keyword'])) {
    $search_type = $_GET['search_type'];
    $keyword = $_GET['keyword'];
    
    if($search_type === 'artist') {
        $sql = "SELECT * FROM albumid WHERE artist LIKE '%$keyword%'";
    } else {
        $sql = "SELECT * FROM albumid WHERE album LIKE '%$keyword%'";
    }
    
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "Artist: " . $row["artist"]. " - Album: " . $row["album"]. "<br>";
        }
    } else {
        echo "Tulemusi ei leitud";
    }
}
$conn->close();
?>

<form action="" method="GET">
    <select name="search_type">
        <option value="artist">Artistid</option>
        <option value="album">Albumid</option>
    </select>
    <input type="text" name="keyword" placeholder="Otsingusõna">
    <input type="submit" value="Otsi">

</form>
</body>
</html>
