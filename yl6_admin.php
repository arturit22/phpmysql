<?php
include('config.php');

session_start(); // Start or resume session

if ($conn->connect_error) {
    die("Ühenduse viga: " . $conn->connect_error);
}

// User registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["registreeri"])) {
    $kasutajanimi = $_POST["kasutajanimi"];
    $parool = $_POST["parool"];

    // Check if username is already taken
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

// User login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logi_sisse"])) {
    $kasutajanimi = $_POST["login"];
    $parool = $_POST["pass"];

    $kasutaja_query = "SELECT * FROM paroolid WHERE login='$kasutajanimi'";
    $result = $conn->query($kasutaja_query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_password = $row['pass'];

        // Verify password
        if (crypt($parool, $stored_password) === $stored_password) {
            $_SESSION['kasutajanimi'] = $kasutajanimi; // Store username in session
            echo "Sisselogimine õnnestus!";
            // Redirect or do further actions after successful login
        } else {
            echo "Vale parool!";
        }
    } else {
        echo "Kasutajat ei leitud!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<h1>Registreeri uus kasutaja</h1>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    Kasutajanimi: <input type="text" name="kasutajanimi" required><br><br>
    Parool: <input type="password" name="parool" required><br><br>
    <input type="submit" name="registreeri" value="Registreeri">
</form>

<h1>Login</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    Login: <input type="text" name="login"><br>
    Password: <input type="password" name="pass"><br>
    <input type="submit" name="logi_sisse" value="Logi sisse">
</form>
</body>
</html>
