<?php 
include("header.php"); 
include("connect.php");

// succesvol.php wordt aangeroepen als iemand probeert af te rekenen.
// Deze pagina bestaat dus alleen voor gebruikers die ingelogd zijn.

if($ingelogd){

// Als er de leveringsgegevens zijn ingevuld, dan worden de bestelgegevens uit het winkelwagentje (temp_order) opgehaald
// en ingevuld in de bestellingen database (orders). Hierbij worden ook enkele extra gegegevens opgezocht, zoals de prijs van het product.
// Dit gebeurt per product dat zich in het winkelwagentje bevond. Vervolgens wordt het winkelwagentje geleegd.

	if(!empty($_POST)){
	
	// Deze functie bepaalt of een ingegeven datum op het moment van aanroepen nog moet komen.

function toekomst2($datum) {
    $vandaagdatum = date("Y-m-d");
    $vandaag = strtotime($vandaagdatum);
    $anderedatum = strtotime($datum);
    return ($vandaag < $anderedatum); //Het product kan niet op dezelfde dag nog geleverd worden.
}
function toekomst($datum) {
    $vandaagdatum = date("Y-m-d");
    $vandaag = strtotime($vandaagdatum);
    $anderedatum = strtotime($datum);
    return ($vandaag <= $anderedatum); //De aanbieding is wel op dezelfde dag nog geldig
}

		$dag = $_POST['dag'];
		$maand = $_POST['maand'];
		$jaar = $_POST['jaar'];
		$datum = strtotime($jaar."-".$maand."-".($dag)); 
		if(!toekomst2($datum)){
			die("Afrekenen mislukt: ingevoerde datum moet in de toekomst liggen! ");
		}
		$tempquery = mysql_query("SELECT * FROM temp_order WHERE account_number= ".$accountnummer);
		while($temp = mysql_fetch_array($tempquery)) {
			$productnummer = $temp['product_number'];
			$aantal = $temp['amount'];
			$aanbieding_query = mysql_query("SELECT * FROM bargains WHERE product_number=$productnummer");
			$aanbiedingarr = mysql_fetch_array($aanbieding_query);
			$aanbieding = false;
			if ($aanbiedingarr) {
				$geldigtot = $aanbiedingarr['to_date'];
				if (toekomst($geldigtot)) {
					$aanbieding = true;
					$aanbiedingsprijs = $aanbiedingarr['temp_price'];
				}
				// Als de aanbieding niet meer geldig is, moet deze uit de aanbiedingdatabase worden verwijderd.
				else {
					mysql_query("DELETE from bargains where product_number=$productnummer");
				}
			}
			$productquery = mysql_query("SELECT * FROM products WHERE product_number= ".$productnummer);
			$product = mysql_fetch_array($productquery);
			$sold = $product['sold'] + $aantal;
			$stock = $product['stock'] - $aantal;
			$prijs = $product['price']; 
			if($aanbieding){
				$prijs=$aanbiedingsprijs;
			}
			$adresdelivery = mysql_real_escape_string(htmlentities($_POST['address_delivery']));
			$adresrekening = mysql_real_escape_string(htmlentities($_POST['address_bill']));
			mysql_query("UPDATE products SET sold='$sold', stock='$stock' WHERE product_number='$productnummer'");
			mysql_query("INSERT INTO orders (product_number,account_number,  price, amount, 
			req_date_delivered, payment_method, address_delivery, address_bill) VALUES (
			'$productnummer','$accountnummer','$prijs','$aantal','".$_POST['jaar']."-".$_POST['maand']."-".$_POST['dag']."','"
			.$_POST['payment_method']."','".$adresdelivery."','".$adresrekening."')"); 
		}
		mysql_query("DELETE FROM temp_order WHERE account_number=".$accountnummer);
?>
      
<div id="midden">
	<h1> U heeft succesvol afgerekend</h1>
	Bedankt voor het kopen bij FABBA.NL!<br />
	<a href="index.php" class="donker">Terug naar FABBA.nl</a>
</div>
<?php 
	}
	
// Als er niets gepost is, moeten eerst enkele bestelgegevens ingevuld worden, zoals het gewenste leveringsadres.
	
	else{
		$accountquery = mysql_query("SELECT * FROM account WHERE account_number=". $accountnummer);
		$account = mysql_fetch_array($accountquery);
		$adres=$account['address'];
	?>
	<script type="text/javascript">

	 function validateForm() {
		var doorgaan = true;
        var adrespatroon = /^[a-zA-Z ]{2,40}\s+\w{1,6}$/;
        var adres1 = document.forms["succesvol"]["address_bill"].value;
        if( adres1 == "" || adres1 == null ){
            document.getElementById("Adres1Error" ).innerHTML = "Factuuradres is niet ingevuld." ;
            doorgaan = false ;
        }  else if ( !(adrespatroon.test(adres1))){
            document.getElementById("Adres1Error" ).innerHTML = "Dit adres bestaat niet." ;
            doorgaan = false ;					
        } else {
            document.getElementById("Adres1Error" ).innerHTML = "" ;
        }

        var adres2 = document.forms["succesvol"]["address_delivery"].value;
        if( adres2 == "" || adres2 == null ){
            document.getElementById("Adres2Error" ).innerHTML = "Leveringsadres is niet ingevuld." ;
            doorgaan = false ;
        }  else if ( !(adrespatroon.test(adres2))){
            document.getElementById("Adres2Error" ).innerHTML = "Dit adres bestaat niet." ;
            doorgaan = false ;					
        } else {
           document.getElementById("Adres2Error" ).innerHTML = "" ;
        }
		
		var datumpatroon = /^[0-9]{2,4}$/ ;
		var totaalpatroon = /^[0-9]{2}-[0-9]{2}-[0-9]{4}$/;

        var dag = document.forms["succesvol"]["dag"].value;
        var maand = document.forms["succesvol"]["maand"].value;
        var jaar = document.forms["succesvol"]["jaar"].value;
		var datum = dag + "-" + maand + "-" + jaar;

        var datumerror = "" ;

        if( !datumpatroon.test(dag) ) {
		   datumerror += "Foutieve invoer bij dag. " ;
            doorgaan = false;
		} else if( !datumpatroon.test(maand) ) {
		    datumerror += "Foutieve invoer bij maand. " ;
            doorgaan = false;
		} else if( !totaalpatroon.test(datum) ) {
			datumerror += "Foutieve invoer bij jaar. ";
			doorgaan = false;
		} else if ( ! validateDate(datum) ){
				datumerror += "Deze datum bestaat niet. " ;
				doorgaan = false ;
		}
		document.getElementById("DatumError" ).innerHTML = datumerror ;
		
		return doorgaan;
	}
	
		// Deze functie kijkt of een datum bestaat. 
		// Benodigde invoervorm: dd-mm-jjjj.
		function validateDate(datum){
			var dag = datum.split("-")[0];
			var maand = datum.split("-")[1];
			var jaar = datum.split("-")[2];
			var datumobject = new Date(jaar, maand-1, dag);
			return (datumobject.getMonth()+1 == maand && datumobject.getDate() == dag && datumobject.getFullYear() == jaar);			
		}
		
	</script>
	<noscript>
		Uw browser biedt geen ondersteuning aan JavaScript.
	</noscript>
	<div id="midden">
	<form name="succesvol" onsubmit="return validateForm()" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<table>
			<tr>
				<th colspan="2">Factuur- en leveringsinformatie</th>
			</tr>
			<tr>
				<td>Leveringsadres:</td><td><input type="text" name="address_delivery" value="<?php echo $adres;?>" /></td>
				<td id = "Adres1Error" class = "Error"></td>
			</tr>
			<tr>
				<td>Factuuradres:</td>
				<td><input type="text" name="address_bill" value="<?php echo $adres; ?>" /></td>
				<td id = "Adres2Error" class = "Error" ></td>
			</tr>
			<tr>
				<td>
					Betalingsmethode:
				</td>
				<td>
					<select name="payment_method">
						<option value="1" selected="selected">Ideal</option>
						<option value="2">Eenmalige Machting</option>
						<option value="3">Onder Rembours (+ &#8364; 5,00 administratiekosten)</option>
						<option value="4">Paypal</option>
					</select>
				</td>
				<td></td>
			</tr>
			<tr>
				<td>Gewenste leveringsdatum:</td>
				<td><input type="text" maxlength="2" size="2" name="dag"/>-<input type="text" maxlength="2" size="2" name="maand"/>-<input type="text" maxlength="4" size="4" name="jaar" />(dd-mm-jjjj)</td>
				<td id="DatumError" class="Error" ></td>
			</tr>
			<tr>
				<td colspan="3"><input type="submit" value="Afrekenen" /></td>
			</tr>
			</table>
		</table>
	</form>
	</div>
<?php
	}
}
else {
	echo "Deze pagina is alleen beschikbaar als u <a href = 'login.php'>inlogt</a>.";
}

mysql_close($con);
include("footer.php"); ?>
