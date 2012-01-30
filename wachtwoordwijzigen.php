<?php
// Wachtwoord wijzigen pagina

include("header.php");
include("connect.php");
echo "<div id='midden'>";
if(!$ingelogd){
	die("Deze pagina is alleen beschikbaar als u <a href = 'login.php'>inlogt</a>");
}
$userzoek = mysql_query("SELECT * FROM account WHERE account_number=$accountnummer");
$gegevens = mysql_fetch_array($userzoek);

if(!empty($_POST)){
	$oud = md5(mysql_real_escape_string(htmlentities($_POST['oudww'])));
	$wachtwoordzoek = mysql_query("SELECT * FROM account WHERE account_number='$accountnummer' and password ='$oud'");
	$gevonden = mysql_fetch_array($wachtwoordzoek);
	if($gevonden){
		$wachtwoord = md5(mysql_real_escape_string(htmlentities($_POST['ww1'])));
		mysql_query("UPDATE account SET password = '".$wachtwoord."' WHERE account_number='$accountnummer'");
		echo "Uw wachtwoord is succesvol gewijzigd. ";
	}
	else{
		echo "U heeft uw oude wachtwoord incorrect ingevuld. Het wachtwoord is niet gewijzigd. <br />";
		echo "<a href=\"{$_SERVER['PHP_SELF']}\" class=\"donker\">Probeer opnieuw</a><br /><br />";
		echo "<a href='wachtwoordvergeten.php'>Wachtwoord vergeten?</a>";
	}
}
else {
?>       
    <script type="text/javascript">
        function validateForm() {
			var doorgaan = true;
			var oudwachtwoord = document.forms["wachtwoordVergeten"]["oudww"].value;
			if( oudwachtwoord == "" || oudwachtwoord == null ){
				document.getElementById("OudWachtwoordError").innerHTML = "Oude wachtwoord is niet ingevuld.";
				doorgaan = false;
            } else {
				document.getElementById("OudWachtwoordError").innerHTML = "";
	        }
			var wachtwoord = document.forms["wachtwoordVergeten"]["ww1"].value;
			var herhaalwachtwoord = document.forms["wachtwoordVergeten"]["ww2"].value;
			if( wachtwoord == "" || wachtwoord == null ){
                document.getElementById("HerhaalWachtwoordError" ).innerHTML = "" ;
                document.getElementById("WachtwoordError" ).innerHTML = "Nieuwe wachtwoord is niet ingevuld." ;
                doorgaan = false ;
            } else if( wachtwoord.length < 6 ){
				document.getElementById("HerhaalWachtwoordError" ).innerHTML = "" ;
                document.getElementById("WachtwoordError" ).innerHTML = "Nieuwe wachtwoord is te kort." ;
                doorgaan = false ;
            } else if( wachtwoord != herhaalwachtwoord ){
                document.getElementById("WachtwoordError" ).innerHTML = "" ;
                document.getElementById("HerhaalWachtwoordError" ).innerHTML = "Wachtwoord is niet correct herhaald." ;
                doorgaan = false ;
            } else {
				document.getElementById("WachtwoordError" ).innerHTML = "" ;
                document.getElementById("HerhaalWachtwoordError" ).innerHTML = "" ;
            }
            return doorgaan ;
        }
    </script>
		<table>
            <tr valign="top">
                <td style="background-color:#009CEB;width:200px;text-align:top;">
					<img id="Afbeeld " src="<?php echo $gegevens['photo']; ?>" width="100" height= "100"><br/>
                    <b>Account</b><br />
             <?php if( $rechten > 1 ){ ?>
					<a href="account wijzigen.php">Mijn gegevens aanpassen</a><br />
                    <a href="categorie_toevoegen.php">Categorie toevoegen</a> <br />
                    <a href="merk_toevoegen.php">Merk toevoegen</a> <br />
                    <a href="product_toevoegen.php">Product toevoegen</a><br /> 
					<a href="bestellingenbeheren.php">Bestellingen beheren</a>
     <?php } 
	 else{ ?> 
                    <a href="bestelgeschiedenis.php">Bestelstatus/geschiedenis</a> <br />
                    <a href="winkelwagentje.php">Winkelwagen</a> <br />
                    <a href="account wijzigen.php">Mijn gegevens aanpassen</a>
	<?php  } ?>
				</td>
                <td style="background-color:#eeeeee;height:100px;width:90%;">
				<form name = "wachtwoordVergeten" onsubmit="return validateForm()" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<table>
						<tr>
							<th colspan="3"><h1>Wachtwoord wijzigen</h1></th>
						</tr>
						<tr>
							<td><b>Oude wachtwoord:</b></td>
							<td>
								<input type="password" name="oudww" />
							</td>
							<td id="OudWachtwoordError" class="Error" ></td>
						</tr>
						<tr>
							<td><b>Nieuw wachtwoord:</b></td>
							<td>
								<input type="password" name="ww1" />
							</td>
							<td id="WachtwoordError" class="Error" ></td>
						</tr>
						<tr>
							<td><b>Herhaal nieuw wachtwoord:</b></td>
							<td>
								<input type="password" name="ww2" />
							</td>
							<td id="HerhaalWachtwoordError" class="Error" ></td>
						</tr>
						<tr>
							<td></td>
							<td>
								<input type="submit" name="Pas aan" />
							</td>
						</tr>
					</table>
				</form>
				</td>
			</tr>
		</table>
<?php
}
echo "</div>";
mysql_close($con);
include("footer.php");

