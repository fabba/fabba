<?php 
include("header.php");
include("connect.php");

// De medewerkerbeheer pagina
// De beheerder kan op deze pagina een medewerker kiezen die hij wilt bekijken en misschien verwijderen,
// of een medewerker toevoegen. Voor het toevoegen wordt doorverwezen naar een andere pagina.

if($ingelogd&&$rechten==3){

	if(!empty($_POST['aanpassen'])){
		$accountnummer = $_POST['account_number'];
	    $userzoek = mysql_query("SELECT * FROM account WHERE account_number='$accountnummer'");
		$gegevens = mysql_fetch_array($userzoek);
?>
	<div id ="midden">
		<b>Medewerker gegevens</b> <br />
		Accountnummer: <?php echo mysql_real_escape_string(htmlentities($gegevens['account_number'])); ?><br />
		Voornaam: <?php echo mysql_real_escape_string(htmlentities($gegevens['first_name'])); ?><br /> 
		Tussenvoegels: <?php echo mysql_real_escape_string(htmlentities($gegevens['extra_name'])); ?><br /> 
		Achternaam: <?php echo mysql_real_escape_string(htmlentities($gegevens['last_name'])); ?><br /> 
		Geslacht: <?php echo mysql_real_escape_string(htmlentities($gegevens['sex'])); ?><br />
		Bedrijf: <?php echo mysql_real_escape_string(htmlentities($gegevens['company'])); ?><br />
		Geboortedatum: <?php echo mysql_real_escape_string(htmlentities($gegevens['date_birth'])); ?><br />
		Adres: <?php echo mysql_real_escape_string(htmlentities($gegevens['address'])); ?><br />
		Postcode: <?php echo mysql_real_escape_string(htmlentities($gegevens['zip_code'])); ?><br /> 
		Woonplaats: <?php echo mysql_real_escape_string(htmlentities($gegevens['city'])); ?><br /> 
		Telefoonnummer: <?php echo "0".mysql_real_escape_string(htmlentities($gegevens['phone_number'])); ?><br />
		06-nummer: <?php 
		if($gegevens['mobile_number']){
			echo "0".mysql_real_escape_string(htmlentities($gegevens['mobile_number']));
		}
		else {
			echo "onbekend";
		}
		?><br />
		Emailadres: <?php echo mysql_real_escape_string(htmlentities($gegevens['email'])); ?><br />
		Creditcardnummer: <?php echo mysql_real_escape_string(htmlentities($gegevens['creditcard_number'])); ?><br />
		Bankrekeningnummer: <?php echo mysql_real_escape_string(htmlentities($gegevens['bank_number'])); ?><br />
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method ="post">
			<input name="verwijderen" type = "submit" value="Verwijderen" /><a href="<?php echo $_SERVER['PHP_SELF']; ?>">Terug</a>
			<input type = "hidden" name="verwijdernummer" value="<?php echo $accountnummer; ?>" />
		</form>
	</div>
<?php
	}
	else if (!empty($_POST['verwijderen'])){
		$verwijdernummer = $_POST['verwijdernummer'];
		mysql_query("DELETE from account where account_number='$verwijdernummer'");
?>
<script type="text/javascript">
	alert("Medewerker is succesvol verwijderd");
    window.open("medewerkers_beheren.php",'_self','',true);
</script>
<?php
	}
	
	else {
?>	
<div id="midden">
	<h1>Medewerkers beheren</h1>
	Op deze pagina's kunt u uw medewerkers beheren.
	<br />
	Selecteer de medewerker die u wilt bekijken:
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method = "post">
		<select name="account_number">
	<?php 
		$query = mysql_query("SELECT * from account where acces='2'");
		while($medewerker = mysql_fetch_array($query)){
	?>
			<option value="<?php echo $medewerker['account_number']; ?>"><?php 
			echo $medewerker['first_name']." ".$medewerker['extra_name']." ".$medewerker['last_name'] ?></option>
	<?php } ?>
		</select>
		<input type="submit" name="aanpassen" value="Medewerker bekijken" />
	</form><br /><br />
	Komt er een een nieuw lid bij de Fabba-crew? Klik <a href="medewerker_toevoegen.php">hier</a> om een medewerker toe te voegen!
</div>

<?php	
	}
}
else{
?>
<div id = "midden">U bent niet bevoegd deze pagina te zien.</div>
<?php
}
mysql_close($con);
include("footer.php");
?>