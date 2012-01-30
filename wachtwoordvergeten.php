<?php
// Wachtwoord vergeten pagina

include("header.php"); 
include("connect.php");

echo "<div id='midden'>";

if(!empty($_POST)) {
	$email = mysql_real_escape_string(htmlentities($_POST['email']));
	$persoonquery = mysql_query("SELECT * FROM account WHERE email ='$email'");
	$persoon = mysql_fetch_array($persoonquery);
	if($persoon){
		// Deze functie genereert een wachtwoord, door om de beurt een cijfer en 
		// een kleine letter te nemen (totaal $halvelengte keer), zodat een wachtwoord van
		// 2 maal $halvelengte letters/cijfers ontstaat.
		
		function maakWachtwoord($halvelengte) {
			$wachtwoord = "";
			for($i=0;$i<($halvelengte);$i++) {
				$wachtwoord .= rand(0, 9);
				$wachtwoord .= chr(rand(97,122));
			}
			return $wachtwoord;
		}
		
		$nieuw = maakWachtwoord(5);
		$bericht = "Beste ".$persoon['first_name']." ".$persoon['last_name'].
				",\n\nU ontvangt deze mail, omdat u geregistreerd staat bij Fabba.nl en een nieuw wachtwoord heeft aangevraagd. Uw nieuwe wachtwoord is:\n"
				.$nieuw."\n\nMet vriendelijke groeten,\nBob de Beheerder";
		$verstuurd = mail($email, "Wachtwoord vergeten", $bericht, "From:noreply@fabba.nl");
		if($verstuurd){
			echo "Er is een email gestuurd naar ".$email." met uw nieuwe wachtwoord. ";
			mysql_query("UPDATE account SET password='".md5($nieuw)."' WHERE email = '".$email."'");
		}
		else {
			echo "Email versturen naar ".$email." is mislukt. <br />";
			echo "<a href=\"{$_SERVER['PHP_SELF']}\">Probeer opnieuw</a>";
		}
	}
	else{
		echo "Dit email adres staat niet in onze database. <br />";
		echo "<a href = \"{$_SERVER['PHP_SELF']}\">Probeer opnieuw</a> of <a href='registreren.php'>registreer</a> ";
	}
}

else {
?>
<h1>Wachtwoord vergeten?</h1>
<p>
	Vul hieronder uw emailadres in, en u zult een mail ontvangen met een nieuw wachtwoord.
	<form action= "<?php echo $_SERVER['PHP_SELF']; ?>" method = "post">
		<input type = "text" name = "email" />
		<input type = "submit" value = "Verstuur" />
	</form>
</p>

<?php
}


echo "</div>";

include("footer.php");
?>