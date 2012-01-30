<?php 
include("header.php"); 

// Controleren of er enkel cijfers ingevuld worden bij nummer velden! Patroonmatching bij email en postcode!

// Registreerformulier
// Zodra er iets gepost is, wordt er gecontroleerd of de gebruikersnaam al bestaat.
// Als de gebruikersnaam nog vrij is worden de gegevens toegevoegd aan de database.

if(!empty($_POST)){
	include("connect.php");
	$gebruikersquery = mysql_query("SELECT * from account WHERE email = '".$_POST['Email']."'");
	$bestaatal = mysql_fetch_array($gebruikersquery);
	if($bestaatal){
		echo "<p>Er is al een gebruiker geregistreerd met dit emailadres. <a href='registreren.php'>Probeer opnieuw</a>.</p>";
	}
	else{
		$wachtwoord = md5(mysql_real_escape_string(htmlentities($_POST['Wachtwoord']))); 
		mysql_query("
		INSERT INTO account (password,first_name,last_name,extra_name,company,address,zip_code,
		city,country,phone_number,mobile_number,bank_number,creditcard_number,sex,date_birth,email)
		VALUES('$wachtwoord',
		'".mysql_real_escape_string(htmlentities($_POST['Voornaam']))."',
		'".mysql_real_escape_string(htmlentities($_POST['Achternaam']))."',
		'".mysql_real_escape_string(htmlentities($_POST['Tussenvoegsel']))."',
		'".mysql_real_escape_string(htmlentities($_POST['Bedrijf']))."',
		'".mysql_real_escape_string(htmlentities($_POST['Adres']))."',
		'".mysql_real_escape_string(htmlentities($_POST['Postcode']))."',
		'".mysql_real_escape_string(htmlentities($_POST['Woonplaats']))."',
		'".mysql_real_escape_string(htmlentities($_POST['Land']))."',
		'".mysql_real_escape_string(htmlentities($_POST['Telefoonnummer']))."',
		'".mysql_real_escape_string(htmlentities($_POST['Mobielnummer']))."',
		'".mysql_real_escape_string(htmlentities($_POST['Bankrekeningnummer']))."',
		'".mysql_real_escape_string(htmlentities($_POST['Creditcardnummer']))."',
		'".mysql_real_escape_string(htmlentities($_POST['Geslacht']))."',
		'".$_POST['jaar']."-".$_POST['maand']."-".$_POST['dag']."',
		'" . mysql_real_escape_string(htmlentities($_POST['Email'])) . "')");
		echo "<p>U bent succesvol geregistreerd!<br />";
		echo "Klik <a href='index.php' class='donker' >hier</a> om terug te gaan naar de homepagina. </p>";
	}
	mysql_close($con);
}

// Als er niets is gepost, wordt het formulier getoond. 
// Met behulp van JavaScript wordt gecontroleerd of de gegevens goed zijn ingevuld.

else{
?>

        <script type="text/javascript">
            function validateForm()
            {	var letterpatroon = /^[a-zA-Z]{2,50}$/;
                var achternaam =document.forms["registreerForm"]["Achternaam"].value;
                var doorgaan = true ;
                if ( achternaam==null || achternaam=="") {
                    document.getElementById("AchternaamError" ).innerHTML = "Achternaam is niet ingevuld." ;
                    doorgaan = false ;
				} else if ( !(letterpatroon.test(achternaam))){
			        document.getElementById("AchternaamError" ).innerHTML = "Een achternaam bestaat alleen uit letters." ;
                    doorgaan = false ;
			    } else {
                    document.getElementById("AchternaamError" ).innerHTML = "" ;
                }
                
                var voornaam = document.forms["registreerForm"]["Voornaam"].value;
                if ( voornaam==null || voornaam=="" ) {
                    document.getElementById("VoornaamError" ).innerHTML = "Voornaam is niet ingevuld." ;
                    doorgaan = false ;
                } else if ( !(letterpatroon.test(voornaam))){
					document.getElementById("VoornaamError" ).innerHTML = "Een voornaam bestaat alleen uit letters. " ;
                    doorgaan = false ;
                } else if ( voornaam == "Dasyel" ){
                    document.getElementById("VoornaamError" ).innerHTML = "Dasyel is geen voornaam!" ;
                    doorgaan = false ;
                } else {
                    document.getElementById("VoornaamError" ).innerHTML = "" ;
                }
				
				var datumpatroon = /^[0-9]{2,4}$/ ;
                var dag = document.forms["registreerForm"]["dag"].value;
                var maand = document.forms["registreerForm"]["maand"].value;
                var jaar = document.forms["registreerForm"]["jaar"].value;
                var datumerror = "" ;
                if( dag == "" || dag == null ){
                    datumerror += "Er is geen dag ingevuld. " ;
                    doorgaan = false ;
                } else if( !datumpatroon.test(dag) ) {
				   datumerror += "Foutieve invoer bij dag. " ;
                    doorgaan = false;
				}
                if( maand == "" || maand == null ){
                    datumerror += "Er is geen maand ingevuld. " ;
                    doorgaan = false ;
                } else if( !datumpatroon.test(maand) ) {
				   datumerror += "Foutieve invoer bij maand. " ;
                    doorgaan = false;
				}
                if( jaar == "" || jaar == null ){
                    datumerror += "Er is geen jaar ingevuld. " ;
                    doorgaan = false ;
                } else if( !datumpatroon.test(jaar) ) {
				   datumerror += "Foutieve invoer bij jaar. " ;
                    doorgaan = false;
				} 
				var datum = dag + "-" + maand + "-" + jaar;
				var totaalpatroon = /^[0-9]{2}-[0-9]{2}-[0-9]{4}$/;
				if( totaalpatroon.test(datum) ) {
					if ( ! validateDate(datum) ){
					datumerror += "Deze datum bestaat niet. " ;
                    doorgaan = false ;
					}
				}
                document.getElementById("GeboorteDatumError" ).innerHTML = datumerror ;
                
                var adrespatroon = /^[a-zA-Z ]{2,40}\s+\w{1,6}$/
                var adres = document.forms["registreerForm"]["Adres"].value;
                if( adres == "" || adres == null ){
                    document.getElementById("AdresError" ).innerHTML = "Adres is niet ingevuld." ;
                    doorgaan = false ;
                }  else if ( !(adrespatroon.test(adres))){
                    document.getElementById("AdresError" ).innerHTML = "Dit adres bestaat niet." ;
                    doorgaan = false ;					
                } else {
                    document.getElementById("AdresError" ).innerHTML = "" ;
                }
				
				var postcodepatroon = /^[0-9]{4}[a-zA-Z]{2}$/;
                var postcode = document.forms["registreerForm"]["Postcode"].value;
                if( postcode == "" || postcode == null ){
                    document.getElementById("PostcodeError" ).innerHTML = "Postcode is niet ingevuld." ;
                    doorgaan = false ;
                } else if( !(postcodepatroon.test(postcode))) {  
					document.getElementById("PostcodeError").innerHTML = "Deze postcode bestaat niet. ";
					doorgaan = false;
				} else {
                    document.getElementById("PostcodeError" ).innerHTML = "" ;
                }
				
                var woonplaats = document.forms["registreerForm"]["Woonplaats"].value;
                if( woonplaats == "" || woonplaats == null ){
                    document.getElementById("WoonplaatsError" ).innerHTML = "Woonplaats is niet ingevuld." ;
                    doorgaan = false ;
				} else if ( !(letterpatroon.test(woonplaats))){
					document.getElementById("WoonplaatsError" ).innerHTML = "Een woonplaats bestaat alleen uit letters." ;
                    doorgaan = false ;             
                }  else {
                    document.getElementById("WoonplaatsError" ).innerHTML = "" ;
                }
                var land = document.forms["registreerForm"]["Land"].value;
                if( land == "" || land == null ){
                    document.getElementById("LandError" ).innerHTML = "Land is niet ingevuld." ;
                    doorgaan = false ;
                } else if ( !(letterpatroon.test(land))){
                    document.getElementById("LandError" ).innerHTML = "Een landnaam bestaat alleen uit letters. " ;
                    doorgaan = false ;
                } else {
                    document.getElementById("LandError" ).innerHTML = "" ;
                }
                
                var telefoonnummer = document.forms["registreerForm"]["Telefoonnummer"].value;
				var nummerpatroon = /^0[0-9]{9}$/;
                if( telefoonnummer == "" || telefoonnummer == null ){
                    document.getElementById("TelefoonnummerError" ).innerHTML = "Er is geen telefoonnummer ingevuld." ;
                    doorgaan = false ;
                } else if( !(nummerpatroon.test(telefoonnummer))){  
                    document.getElementById("TelefoonnummerError" ).innerHTML = "Telefoonnummer moet 10 getallen hebben en beginnen met een 0." ;
                    doorgaan = false ;
                }  else {
                    document.getElementById("TelefoonnummerError" ).innerHTML = "" ;
                }
                
                var mobielnummer = document.forms["registreerForm"]["Mobielnummer"].value;
				var mobielpatroon = /^06[0-9]{8}$/;
                if( mobielnummer != "" && mobielnummer!=null  && (!mobielpatroon.test(mobielnummer)) ){
                    document.getElementById("MobielnummerError" ).innerHTML = "Mobielnummer moet 10 getallen hebben en beginnen met 06." ;
                    doorgaan = false ;
                } else {
                    document.getElementById("MobielnummerError" ).innerHTML = "";
                }
                
				var emailpatroon = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/; 
				// Bron: http://www.zparacha.com/validate-email-address-using-javascript-regular-expression
                var email = document.forms["registreerForm"]["Email"].value;
                if( email == "" || email == null ){
                    document.getElementById("EmailError" ).innerHTML = "Email is niet ingevuld." ;
                    doorgaan = false ;
				} else if(!(emailpatroon.test(email))) {
				    document.getElementById("EmailError" ).innerHTML = "Dit emailadres bestaat niet" ;
                    doorgaan = false ;
                } else {
                    document.getElementById("EmailError" ).innerHTML = "";
                }
                
				var cijferpatroon = /^[0-9]{6,12}$/;
                var bankrekening = document.forms["registreerForm"]["Bankrekeningnummer"].value;
                if( bankrekening == "" || bankrekening == null ){
                    document.getElementById("BankrekeningnummerError" ).innerHTML = "Bankrekeningnummer is niet ingevuld." ;
                    doorgaan = false ;
                } else if(!(cijferpatroon.test(bankrekening)&& elfproef(bankrekening))){
		            document.getElementById("BankrekeningnummerError" ).innerHTML = "Dit bankrekeningnummer bestaat niet." ;
                    doorgaan = false ;       		
				} else {
                    document.getElementById("BankrekeningnummerError" ).innerHTML = "";
                }
                var creditpatroon = /^[0-9]{13,16}$/;
                var creditcard = document.forms["registreerForm"]["Creditcardnummer"].value;
                if( creditcard == "" || creditcard == null ){
                    document.getElementById("CreditcardnummerError" ).innerHTML = "Creditcardnummer is niet ingevuld." ;
                    doorgaan = false ;
                } else if(!(creditpatroon.test(creditcard))){
					document.getElementById("CreditcardnummerError" ).innerHTML = "Een creditcardnummer moet tussen de 13 en 16 cijfers hebben." ;
                    doorgaan = false ;
                }   else {
                    document.getElementById("CreditcardnummerError" ).innerHTML = "";
                }
                 
                var wachtwoord = document.forms["registreerForm"]["Wachtwoord"].value;
                var herhaalwachtwoord = document.forms["registreerForm"]["HerhaalWachtwoord"].value;
                if( wachtwoord == "" || wachtwoord == null ){
                    document.getElementById("WachtwoordError" ).innerHTML = "Wachtwoord is niet ingevuld." ;
                    doorgaan = false ;
                } else if( wachtwoord.length < 6 ){
                    document.getElementById("WachtwoordError" ).innerHTML = "Wachtwoord is te kort." ;
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
		
		
		// Deze functie kijkt of een datum bestaat. 
		// Benodigde invoervorm: dd-mm-jjjj.
		function validateDate(datum){
			var dag = datum.split("-")[0];
			var maand = datum.split("-")[1];
			var jaar = datum.split("-")[2];
			var datumobject = new Date(jaar, maand-1, dag);
			return (datumobject.getMonth()+1 == maand && datumobject.getDate() == dag && datumobject.getFullYear() == jaar);			
		}
		
		// Bron van het geimplementeerde algoritme: http://nl.wikipedia.org/wiki/Elfproef.
		// De elfproef valideert bankrekeningnummers (9 of 10 cijfers).
		// Als het nummer geen 9 of 10 cijfers heeft, slaagt de proef altijd.
		
		function elfproef(nummer){
			var totaal = 0;
			if(nummer.length==9){
				var positie = nummer.length;
				for( var i = 0; i < 9; i++ ) {
					totaal += nummer.charAt(i) * positie;
					positie -= 1;
				}
			}
			else if(nummer.length==10){
				var positie = 0;
				for( var i = 0; i < nummer.length; i++ ) {
					positie += 1;
					totaal += nummer.charAt(i) * positie;
				}
			}
			else {
				totaal = 11;
			}
			return ((totaal%11)==0);	
		}
			
        </script>



        <div id="midden">
        <form name ="registreerForm" onsubmit="return validateForm()" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <table>
                <tr>
	                <th colspan="2">
                		<h1>Registreer u nu gratis voor FABBA.nl</h1>
                    		Velden met een * zijn verplicht.
                	  </th>
                </tr>
				<tr>
                    <td>Voornaam*:</td>
					<td><input type="text" name="Voornaam" maxlength="50" /></td>
					<td id="VoornaamError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Tussenvoegels:</td>
					<td><input type="text" name="Tussenvoegsel" maxlength="20" /></td>
					<td id="TussenvoegselError" class="Error" ></td>
                </tr>
				<tr>
                    <td>Achternaam*:</td>
					<td><input type="text" name="Achternaam" maxlength="50"/></td>
					<td id="AchternaamError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Geslacht:</td>
					<td> 
						<select name="Geslacht">
							<option value="Man" select="selected">Man</option>
							<option value="Vrouw">Vrouw</option>
						</select>
					</td>
					<td id="GeslachtError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Bedrijf:</td>
					<td><input type="text" name="Bedrijf" maxlength="50" /></td>
					<td id="BedrijfError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Geboortedatum*:</td>
					<td>
						<input type="text" name="dag" maxlength="2" size="1" />-<input type="text" name="maand" maxlength="2" size="1"/>-<input type="text" name="jaar" maxlength="4" size="2" />
					</td>
					<td id="GeboorteDatumError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Adres*:</td>
					<td> <input type="text" name="Adres" maxlength = "50" /></td>
					<td id="AdresError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Postcode*:</td>
					<td> <input type="text" name="Postcode" maxlength="6" size="6"/></td>
					<td id="PostcodeError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Woonplaats*:</td>
					<td> <input type="text" name="Woonplaats" maxlength = "30" /></td>
					<td id="WoonplaatsError" class="Error"></td>
                </tr>
                <tr>
                    <td>Land*:</td>
					<td><input type="text" name="Land" maxlength="50" /></td>
					<td id="LandError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Telefoonnummer*:</td>
					<td><input type="text" name="Telefoonnummer" maxlength="10" /></td>
					<td id="TelefoonnummerError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Mobielnummer:</td>
					<td><input type="text" name="Mobielnummer" maxlength="10"/></td>
					<td id="MobielnummerError" class="Error" ></td>
                </tr>
                <tr>
                    <td>E-mailadres*:</td>
					<td> <input type="text" name="Email" maxlength = "30" /></td>
					<td id="EmailError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Bankrekeningnummer*:</td>
					<td><input type="text" name="Bankrekeningnummer" maxlength = "12"/></td>
					<td id="BankrekeningnummerError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Creditcardnummer*:</td>
					<td> <input type="text" name="Creditcardnummer" maxlength = "16" /></td>
					<td id="CreditcardnummerError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Wachtwoord*:</td>
					<td><input type="password" name="Wachtwoord" maxlength = "20" /></td>
					<td id="WachtwoordError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Herhaal Wachtwoord*:</td>
					<td><input type="password" name="HerhaalWachtwoord" maxlength = "20" /></td>
					<td id="HerhaalWachtwoordError" class="Error" ></td>
                </tr>
                <tr>
                    <td></td>
					<td><input type="submit" value="Registreer" /></td>
					<td></td>
                </tr>

            </table>
        </form>
	</div>
    
<?php }
include("footer.php"); ?>