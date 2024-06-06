<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    //kas väljad on täidetud 
$vnimi="";
$vemail="";
$vsonum="";
if (isset($_POST['nimi']) && isset($_POST['email']) && isset($_POST['sonum'])) { 
	//andmed vormist 
	$nimi = trim(addslashes($_POST['nimi'])); 
	$email = trim(addslashes($_POST['email'])); 
	$sonum = trim(addslashes($_POST['sonum'])); 
    $vnimi=$nimi; 
	$vemail=$email; 
	$vsonum=$sonum; 
	//emaili andmed 
	$to = 'metshein\@gmail.com'; 
	$subject = 'Tagasiside kodulehelt'; 
	$message = $sonum; $from = 'From: '.$nimi.'<'.$email.'>'; 

	//kas emaili saatmine õnnestus 
	if (!empty($nimi) && !empty($email) && !empty($sonum)) {
		//kas vastavad soovitud pikkusele
		if (strlen($nimi)>25 || !preg_match("/^[a-z0-9]((\.|_)?[a-z0-9]+)+@([a-z0-9]+(\.|-)?)+[a-z0-9]\.[a-z]{2,}$/", strtolower($email)) || strlen($sonum)>500 ) {
			echo'Tekstid on liiga pikad või email on valesti!';
		} else {
			//emaili andmed
			$to = 'metshein\@gmail.com';
			$subject = 'Tagasiside kodulehelt';
			$message = $sonum;
			$from = 'From: '.$nimi.'<'.$email.'>';
			//CAPTCHA kontroll
			if ($_POST['kood']==$_SESSION['captchatekst']) {
				//kas emaili saatmine õnnestus
				if(mail($to, $subject, $message, $from)){
					echo "Email saadetud!<br>Täname tagasiside eest!";
					echo "<meta http-equiv=\"refresh\" content=\"2;URL='10_email.php'\">";
					exit();
				} else {
					echo "Teie emaili ei saadetud ära!";
				}
			} else{
				echo "Turvakood on vale!";
			} 
		}
	} else {
		$error = 'Palun täida kõik väljad!';
	}
}
    ?>
<h2>Tagasiside</h2>
<form action="" method="post">
	Teie nimi:<br>
	<input name="nimi" type="text" value="<?php echo $vnimi; ?>"><br>
	Teie email:<br>
	<input name="email" type="text" value="<?php echo $vemail; ?>"><br>
	Sõnum:<br>
	<textarea cols="30" rows="10" name="sonum"><?php echo $vsonum; ?></textarea><br>
	<img src="C:\xampp\htdocs\phpmysql\captcha.php"><br>
	Sisesta kood pildilt:<br>
	<input name="kood" type="text"><br>
	<input value="saada sõnum" type="submit">
</form>
</form>
</form>
</form>
</form>
</body>
</html>