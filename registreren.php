<?php include("header.php"); 
if(!empty($_POST)){
	include("connect.php");
	mysql_query("INSERT INTO account (password,first_name,last_name,extra_name,company,address,zip_code,city,country,phone_number,mobile_number,bank_number,creditcard_number,sex,date_birth,email)
	VALUES('$_POST[Wachtwoord]','$_POST[Voornaam]','$_POST[Achternaam]','$_POST[Tussenvoegsel]','$_POST[Bedrijf]','$_POST[Adres]','$_POST[Postcode]','$_POST[Woonplaats]','$_POST[Land]','$_POST[Telefoonnummer]','$_POST[Mobielnummer]','$_POST[Bankrekeningnummer]','$_POST[Creditcardnummer]','$_POST[Geslacht]','$_POST[jaar]-$_POST[maand]-$_POST[dag]','$_POST[Email]')");
	echo "<p>U bent succesvol registreert klik<a href='index.php' class='donker' >hier</a> om terug te gaan naar de homepage</p>";
	mysql_close($con);
}
else{
?>

        <script type="text/javascript">
            function validateForm()
            {
                var achternaam =document.forms["registreerForm"]["Achternaam"].value;
                var doorgaan = true ;
                if ( achternaam==null || achternaam=="" )
                {
                    document.getElementById("AchternaamError" ).innerHTML = "U bent achternaam vergeten in te vullen." ;
                    doorgaan = false ;
                } else {
                    document.getElementById("AchternaamError" ).innerHTML = "" ;
                }
                
                var voornaam = document.forms["registreerForm"]["Voornaam"].value;
                if ( voornaam==null || voornaam=="" )
                {
                    document.getElementById("VoornaamError" ).innerHTML = "U bent voornaam vergeten in te vullen." ;
                    doorgaan = false ;
                } else if ( voornaam == "Dasyel" ){
                    document.getElementById("VoornaamError" ).innerHTML = "Dasyel is geen voornaam!" ;
                    doorgaan = false ;
                } else {
                    document.getElementById("VoornaamError" ).innerHTML = "" ;
                }
                
                var dag = document.forms["registreerForm"]["dag"].value;
                var maand = document.forms["registreerForm"]["maand"].value;
                var jaar = document.forms["registreerForm"]["jaar"].value;
                var datumerror = "" ;
                if( dag == "" || dag == null ){
                    datumerror = datumerror + "Er is geen dag ingevuld. "
                    doorgaan = false ;
                }
                if( maand == "" || maand == null ){
                    datumerror = datumerror + "Er is geen maand ingevuld. "
                    doorgaan = false ;
                }
                if( jaar == "" || jaar == null ){
                    datumerror = datumerror + "Er is geen jaar ingevuld. "
                    doorgaan = false ;
                }
                document.getElementById("GeboorteDatumError" ).innerHTML = datumerror ;
                
                
                var adres = document.forms["registreerForm"]["Adres"].value;
                if( adres == "" || adres == null ){
                    document.getElementById("AdresError" ).innerHTML = "Adres is niet ingevuld." ;
                    doorgaan = false ;
                }  else {
                    document.getElementById("AdresError" ).innerHTML = "" ;
                }
                var postcode = document.forms["registreerForm"]["Postcode"].value;
                if( postcode == "" || postcode == null ){
                    document.getElementById("PostcodeError" ).innerHTML = "Postcode is niet ingevuld." ;
                    doorgaan = false ;
                }  else {
                    document.getElementById("PostcodeError" ).innerHTML = "" ;
                }
                var woonplaats = document.forms["registreerForm"]["Woonplaats"].value;
                if( woonplaats == "" || woonplaats == null ){
                    document.getElementById("WoonplaatsError" ).innerHTML = "Woonplaats is niet ingevuld." ;
                    doorgaan = false ;
                }  else {
                    document.getElementById("WoonplaatsError" ).innerHTML = "" ;
                }
                var land = document.forms["registreerForm"]["Land"].value;
                if( land == "" || land == null ){
                    document.getElementById("LandError" ).innerHTML = "Land is niet ingevuld." ;
                    doorgaan = false ;
                }  else {
                    document.getElementById("LandError" ).innerHTML = "" ;
                }
                
                var telefoonnummer = document.forms["registreerForm"]["Telefoonnummer"].value;
                if( telefoonnummer == "" || telefoonnummer == null ){
                    document.getElementById("TelefoonnummerError" ).innerHTML = "Er is geen telefoonnummer ingevuld." ;
                    doorgaan = false ;
                } else if(  telefoonnummer.length < 10 ){
                    document.getElementById("TelefoonnummerError" ).innerHTML = "Telefoonnummer heeft minder dan 10 getallen." ;
                    doorgaan = false ;
                }  else {
                    document.getElementById("TelefoonnummerError" ).innerHTML = "" ;
                }
                
                var mobielnummer = document.forms["registreerForm"]["Mobielnummer"].value;
                if( mobielnummer != "" && mobielnummer!=null  && mobielnummer.length < 10 ){
                    document.getElementById("MobielnummerError" ).innerHTML = "Mobielnummer heeft minder dan 10 getallen." ;
                    doorgaan = false ;
                } else if( mobielnummer != "" && mobielnummer!=null  && mobielnummer.substring(0,2) != "06" ){
                    document.getElementById("MobielnummerError" ).innerHTML = "Dit mobiele nummer begin niet met 06." ;
                    doorgaan = false ;
                } else {
                    document.getElementById("MobielnummerError" ).innerHTML = "";
                }
                
                var email = document.forms["registreerForm"]["Email"].value;
                if( email == "" || email == null ){
                    document.getElementById("EmailError" ).innerHTML = "Email is niet ingevuld." ;
                    doorgaan = false ;
                } else {
                    document.getElementById("EmailError" ).innerHTML = "";
                }
                
                var bankrekening = document.forms["registreerForm"]["Bankrekeningnummer"].value;
                if( bankrekening == "" || bankrekening == null ){
                    document.getElementById("BankrekeningnummerError" ).innerHTML = "Bankrekeningnummer is niet ingevuld." ;
                    doorgaan = false ;
                } else {
                    document.getElementById("BankrekeningnummerError" ).innerHTML = "";
                }
               
                var creditcard = document.forms["registreerForm"]["Creditcardnummer"].value;
                if( creditcard == "" || creditcard == null ){
                    document.getElementById("CreditcardnummerError" ).innerHTML = "Creditcardnummer is niet ingevuld." ;
                    doorgaan = false ;
                }  else {
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
        </script>



        
        <form name="registreerForm" onsubmit="return validateForm()" method="post">
            <table>
                <tr>
                    <th colspan="2">
                <h1>Registreer u nu gratis voor FABBA.nl</h1>
                    Velden met een * zijn verplicht.
                </th>
                </tr>
                <tr>
                    <td>Achternaam*:</td><td> <input type="text" name="Achternaam" /></td><td id="AchternaamError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Tussenvoegels:</td><td> <input type="text" name="Tussenvoegsel" /></td><td id="TussenvoegselError" class="Error" ></td>
                </tr><tr>
                    <td>Voornaam*:</td><td> <input type="text" name="Voornaam" /></td><td id="VoornaamError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Geslacht</td><td> <select type="text" name="Geslacht:" />
                <option value="Man" SELECTED>Man</option>
                <option value="Vrouw">Vrouw</option></td><td id="GeslachtError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Bedrijf:</td><td> <input type="text" name="Bedrijf" /></td><td id="BedrijfError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Geboortedatum*:</td><td> <input type="text" name="dag" maxlength="2" size="1" />-<input type="text" name="maand" maxlength="2" size="1"/>-<input type="text" name="jaar" maxlength="4" size="2" /></td><td id="GeboorteDatumError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Adres*:</td><td> <input type="text" name="Adres" /></td><td id="AdresError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Postcode*:</td><td> <input type="text" name="Postcode" maxlength="6" size="6"/></td><td id="PostcodeError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Woonplaats*:</td><td> <input type="text" name="Woonplaats" /></td><td id="WoonplaatsError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Land*:</td><td> <input type="text" name="Land" /></td><td id="LandError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Telefoonnummer*:</td><td> <input type="text" name="Telefoonnummer" maxlength="10" /></td><td id="TelefoonnummerError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Mobielnummer:</td><td> <input type="text" name="Mobielnummer" maxlength="10"/></td><td id="MobielnummerError" class="Error" ></td>
                </tr>
                <tr>
                    <td>E-mailadres*:</td><td> <input type="text" name="Email" /></td><td id="EmailError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Bankrekeningnummer*:</td><td> <input type="text" name="Bankrekeningnummer" /></td><td id="BankrekeningnummerError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Creditcardnummer*:</td><td> <input type="text" name="Creditcardnummer" /></td><td id="CreditcardnummerError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Wachtwoord*:</td><td><input type="password" name="Wachtwoord" /></td><td id="WachtwoordError" class="Error" ></td>
                </tr>
                <tr>
                    <td>Herhaal Wachtwoord*:</td><td><input type="password" name="HerhaalWachtwoord" /></td><td id="HerhaalWachtwoordError" class="Error" ></td>
                </tr>
                <tr>
                    <td></td><td>
                        <input type="submit" value="Registreer" /></td>
                </tr>

            </table>
        </form>
    
<?php }
include("footer.php"); ?>