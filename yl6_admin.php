<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
include('config.php');

if ($conn->connect_error) {
    die("Ühenduse viga: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kasutajanimi = $_POST["kasutajanimi"];
    $parool = $_POST["parool"];

    $kasutajanimi_kontroll = "SELECT COUNT(*) AS count FROM paroolid WHERE login='$kasutajanimi'";
    $result = $conn->query($kasutajanimi_kontroll);
    $row = $result->fetch_assoc();
    $kasutajanimi_korduvusi = $row['count'];

    if ($kasutajanimi_korduvusi > 0) {
        echo "Kasutajanimi on juba võetud!";
    } elseif (strlen($parool) < 8) {
        echo "Parool peab olema vähemalt 8 tähemärki pikk!";
    } else {
        $sool = 'taiestisuvalinetekst';
        $kryp = crypt($parool, $sool);
        $sql = "INSERT INTO paroolid (login, pass) VALUES ('$kasutajanimi', '$kryp')";

        if ($conn->query($sql) === TRUE) {
            echo "Uus kasutaja on edukalt registreeritud!";
        } else {
            echo "Viga: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<h1>Login</h1>
<form action="" method="post">
    Login: <input type="text" name="login"><br>
    Password: <input type="password" name="pass"><br>
    <input type="submit" value="Logi sisse">
</form>
<br>
<br>

<h1>Registreeri uus kasutaja</h1>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    Kasutajanimi: <input type="text" name="kasutajanimi" required><br><br>
    Parool: <input type="password" name="parool" required><br><br>
    <input type="submit" value="Registreeri">
</form>
</body>
</html>
