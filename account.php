<?php
// Account pagina
include("header.php");
if ($ingelogd) {
    include("connect.php");
    $userzoek = mysql_query("SELECT * FROM account WHERE account_number=$accountnummer");
    $gegevens = mysql_fetch_array($userzoek);
?>
<div id="midden">
    <table width="100%" border="0">
		<tr valign="top">
			<td style="background-color:#009CEB;width:200px;text-align:top;">
				<img id="Afbeeld " src="<?php echo mysql_real_escape_string(htmlentities($gegevens['photo'])) ?>" width="100" height= "100"><br/>
				<b>Account</b><br />
    <?php if( $rechten > 1 ){ ?>
					<a href="account wijzigen.php">Mijn gegevens aanpassen</a><br />
                    <a href="categorie_toevoegen.php">Categorie toevoegen</a> <br />
					<a href="categorie_aanpassen.php">Categorie aanpassen</a> <br />
                    <a href="merk_toevoegen.php">Merk toevoegen</a> <br />
					<a href="merk_aanpassen.php">Merk Aanpassen</a> <br />
                    <a href="product_toevoegen.php">Product toevoegen</a><br /> 
					<a href="bestellingenbeheren.php">Bestellingen beheren</a>
     <?php } 
	 else{ ?> 
                    <a href="bestelgeschiedenis.php">Bestelstatus/geschiedenis</a> <br />
                    <a href="winkelwagentje.php">Winkelwagen</a> <br />
                    <a href="account wijzigen.php">Mijn gegevens aanpassen</a>
	<?php  } ?>
			</td>
			<td style="background-color:#eeeeee;height:50px;width:200px;text-align:top;">
				<b> Mijn Gegevens</b> <br />
				Klantnummer: <?php echo mysql_real_escape_string(htmlentities($gegevens['account_number'])); ?><br />
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
			</td>
        </tr>
        </table>
   </div>        
<?php 
mysql_close($con);
} 
else { ?>
        <script type="text/javascript">
        window.open("index.php",'_self','',true);
        </script>
<?php
}
include("footer.php"); ?>