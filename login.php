<?php
// Loginpagina

if (@$_SERVER['HTTPS'] !== 'on') {
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: $redirect", true, 301); 
    exit();
}
// Bovenstaande 5 regels zijn gekopieerd uit login5.php, uit de collegevoorbeelden.

$doorschrijven = true ; // Dit zorgt ervoor dat de session nog niet afgesloten wordt.
include("header.php"); 

echo "<div id='midden'>";

// Als er iets gepost is, wordt gecontroleerd of de inloggegevens goed zijn ingevuld.
// Als de inlogggevens fout zijn, wordt er een foutmelding gegeven.
// Als de inloggegevens kloppen, wordt de persoon "ingelogd": zijn sessie variabelen worden ingevuld.

if (!empty($_POST)) {
	if($_POST['email']&&$_POST['wachtwoord']){
		include("connect.php");
		$inlognaam = mysql_real_escape_string(htmlentities($_POST['email']));
		$wachtwoord = mysql_real_escape_string(htmlentities(md5($_POST['wachtwoord'])));
		$password = mysql_query("SELECT * FROM account WHERE email ='$inlognaam' and password ='$wachtwoord' ");
		$persoon = mysql_fetch_array($password);
		if($persoon){
                    
			$_SESSION['accountnummer']= $persoon['account_number'] ;
			$_SESSION['voornaam'] =  mysql_real_escape_string(htmlentities($persoon['first_name'])) ;
                        $_SESSION['tussennaam'] =  mysql_real_escape_string(htmlentities($persoon['extra_name'])) ;
            $_SESSION['achternaam'] = mysql_real_escape_string(htmlentities($persoon['last_name'])) ;
            $_SESSION['liketimer']=0;
            $_SESSION['rechten'] = mysql_real_escape_string(htmlentities($persoon['acces'])) ;
?>
u bent ingelogd
<script type="text/javascript">
   window.open("account.php",'_self','',true);
</script>
<?php
		}
		else {
			echo "U heeft uw emailadres of wachtwoord verkeerd ingevoerd. <br /> <a href=\"{$_SERVER['PHP_SELF']}\" class=\"donker\">Probeer opnieuw</a>";
		}
		mysql_close($con);
	}
	else {	
		echo "Zowel het veld emailadres als het veld wachtwoord dienen ingevuld te worden! <br /> <a href=\"{$_SERVER['PHP_SELF']}\" class=\"donker\">Probeer opnieuw</a>";
	}
} 

// Als er niets gepost is, wordt dit formulier getoond.

else {
?>
<p>
<form action=" <?php echo $_SERVER['PHP_SELF']; ?> " method="post">
	<table>
	<tr>
		<th colspan="2" style="text-align: left;">
			<h1>Inlogscherm</h1>
		</th>
		<th>
		</th>
	</tr>
	<tr>
		<td>Emailadres:</td>
		<td>
			<input type="text" name ="email" size="35" maxlength = "40" />
		</td>
		<td style="text-align:right;">
			Nog geen lid van Fabba?
		</td>
	</tr>

	<tr>
		<td>
			Wachtwoord:
		</td>
		<td>
			<input type="password" name= "wachtwoord" size="35" maxlength = "20" />
		</td>
		<td style="text-align: right;">
			<a class="donker" href="registreren.php">Registreren</a>
		</td>
	</tr>

	<tr>
		<td>
		</td>
		<td style="text-align:right;">
			<input type= "submit" value ="Log in" />
		</td>
		<td>
		</td>
	</tr>
	</table>
</form>
</p>
<p style="text-align: left">
	<a href = "wachtwoordvergeten.php" class="donker">Wachtwoord vergeten?</a>
</p>

<?php }

echo "</div>";

session_write_close();

include("footer.php"); ?>