<?php
$doorschrijven = true ;

include("header.php"); 

if (!empty($_POST)) {
	$inlognaam = $_POST['naam'];
	$wachtwoord = $_POST['wachtwoord'];
	if($inlognaam&&$wachtwoord){
		include("connect.php");
		$password = mysql_query("SELECT password FROM account WHERE email ='$inlognaam'");
		$pass = mysql_fetch_row($password);
		if($wachtwoord==$pass[0]){
			$persoon = mysql_fetch_array(mysql_query("SELECT * FROM account WHERE email ='$inlognaam'"));                    
			$_SESSION['accountnummer']= $persoon['account_number'] ;
			$_SESSION['voornaam'] = $persoon['first_name'] ;
            $_SESSION['achternaam'] = $persoon['last_name'] ;
            $_SESSION['liketimer']=0;
            $_SESSION['rechten'] = $persoon['acces'] ;
?>
<script type="text/javascript">
    window.open("account.php",'_self','',true);
</script>
<?php
		}
		else {
			echo "U heeft uw gebruikersnaam of wachtwoord verkeerd ingevoerd. <br /> <a href=\"login.php\" class=\"donker\">Probeer opnieuw</a>";
		}
		mysql_close($con);
	}
	else {	
		echo "Zowel het veld gebruikersnaam als het veld wachtwoord dienen ingevuld te worden! <br /> <a href=\"login.php\" class=\"donker\">Probeer opnieuw</a>";
	}	
} 

else {
	echo '<form action="login.php" method="post">
	<table>
	<tr>
		<th colspan="2" style="text-align: left;">
			<h1>Inlogscherm</h1>
		</th>
		<th>
		</th>
	<tr>
	<tr>
		<td>Email:</td>
		<td>
			<input type="text" name ="naam" size="20" />
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
			<input type="password" name= "wachtwoord" size="20" />
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
	</table>
	</form>';
}
include("footer.php"); ?>