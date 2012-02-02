<?php
// De account wijzigen pagina

$doorschrijven = true;
include("header.php");
include("connect.php");

echo "<div id='midden'>";

if (!$ingelogd) {
    die("U bent niet ingelogd!");
}
    $userzoek = mysql_query("SELECT * FROM account WHERE account_number = '$accountnummer' ");
    $gegevens = mysql_fetch_array($userzoek);

    $vrouw = "";
    $man = "";
    if ($gegevens['sex'] == "Vrouw") {
        $vrouw = "selected = 'SELECTED'";
    } else {
        $man = "selected= 'SELECTED'";
    }
    $month = date("m", strtotime($gegevens['date_birth']));
    $year = date("Y", strtotime($gegevens['date_birth']));
    $day = date("d", strtotime($gegevens['date_birth']));
    ?>
    <script type="text/javascript">

        // De invoervelden moeten aan dezelfde voorwaarden voldoen als bij registreren.php
        // Het enige verschil is dat wachtwoord wijzigen op een andere pagina gebeurt.

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
            if( (bankrekening != "" && bankrekening != null) && !(cijferpatroon.test(bankrekening)&& elfproef(bankrekening))) {
                document.getElementById("BankrekeningnummerError" ).innerHTML = "Dit bankrekeningnummer bestaat niet." ;
                doorgaan = false ;       		
            } else {
                document.getElementById("BankrekeningnummerError" ).innerHTML = "";
            }
            var creditpatroon = /^[0-9]{13,16}$/;
            var creditcard = document.forms["registreerForm"]["Creditcardnummer"].value;
            if( (creditcard != "" && creditcard != null) && !(creditpatroon.test(creditcard)) ){
                document.getElementById("CreditcardnummerError" ).innerHTML = "Een creditcardnummer moet tussen de 13 en 16 cijfers hebben." ;
                doorgaan = false ;
            }   else {
                document.getElementById("CreditcardnummerError" ).innerHTML = "";
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
        function verander_fot(fotot){
    		 
            var foto = document.getElementById("fotootje");
            foto.setAttribute("src", fotot );
            var fotol = document.getElementById("newfoto");
            fotol.value = fotot ;
            var fotoll = document.getElementById("foto");
            fotoll.value = fotot ;
        }
        function verander_foto(){
            var foto = document.getElementById("fotootje");
            var fotoll = document.getElementById("foto");
            var fotopad =fotoll.value  ;
            foto.setAttribute("src",fotopad );
            var fotol = document.getElementById("newfoto");
            fotol.value = fotoll.value;
        }
    		
    </script>


    <table>
        <tr valign="top">
            <td style="background-color:#009CEB;width:200px;text-align:top;">
                <form action="account wijzigen.php?name=1" name="fot" method="post" enctype="multipart/form-data">
                    <img id="fotootje" src="<?php echo mysql_real_escape_string(htmlentities($gegevens['photo'])); ?>" width="100px" height="100px"/>

                    <textarea name="foto" id="foto" style="resize: none;" rows="1" cols="40" onchange="verander_foto()"><?php echo mysql_real_escape_string(htmlentities($gegevens['photo'])); ?> </textarea>



                    <label for="file">Filename:</label>
                    <input type="file" name="file" id="file" /> 
                    <br />
                    <input type="submit" name="submit" value="Submit" />
                </form>
                <b>Account</b><br />
    <?php if ($rechten == 3) { ?>
                    <a href="account wijzigen.php">Mijn gegevens aanpassen</a><br />
                    <a href="medewerkers_beheren.php">Medewerkers beheren</a><br />
                    <a href="categorie_toevoegen.php">Categorie toevoegen</a><br />
                    <a href="categorie_aanpassen.php">Categorie aanpassen</a><br />
                    <a href="merk_toevoegen.php">Merk toevoegen</a> <br />
                    <a href="merk_aanpassen.php">Merk aanpassen</a> <br />
                    <a href="product_toevoegen.php">Product toevoegen</a><br /> 
        <?php
    } else if ($rechten == 2) {
        ?> 
                    <a href="bestellingenbeheren.php">Bestellingen beheren</a>
                    <a href="account wijzigen.php">Mijn gegevens aanpassen</a>
                    <?php
                } else {
                    ?> 
                    <a href="bestelgeschiedenis.php">Bestelstatus/geschiedenis</a> <br />
                    <a href="winkelwagentje.php">Winkelwagen</a> <br />
                    <a href="account wijzigen.php">Mijn gegevens aanpassen</a>
                <?php } ?>
            </td>
            <td style="background-color:#eeeeee;height:100px;width:90%;text-align:right;">
                <b>Mijn Gegevens</b> <br />
                <!-- Aangezien de valideer functie van registratie is gebruikt, moet dit formulier ook registreerForm heten! -->
                <form name="registreerForm" method="post" onsubmit="return validateForm()" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <table>
                        <tr>
                            <td>Voornaam:</td>
                            <td> 
                                <input type="text" name="Voornaam" 
                                       value="<?php echo mysql_real_escape_string(htmlentities($gegevens['first_name'])); ?>" />
                            </td>
                            <td id="VoornaamError" class="Error" ></td>
                        </tr>
                        <td>Tussenvoegels:</td>
                        <td>
                            <input type="text" name="Tussenvoegsel" 
                                   value="<?php echo mysql_real_escape_string(htmlentities($gegevens['extra_name'])); ?>" />
                        </td>
                        <td id="TussenvoegselError" class="Error" ></td>
                        </tr>
                        <tr>
                        <tr>
                            <td>Achternaam:</td>
                            <td>
                                <input type="text" name="Achternaam" 
                                       value="<?php echo mysql_real_escape_string(htmlentities($gegevens['last_name'])); ?>" />
                            </td>
                            <td id="AchternaamError" class="Error" ></td>
                        </tr>
                        <tr>
                            <td>Geslacht:</td>
                            <td> 
                                <select type="text" name="Geslacht">
                                    <option value="Man" <?php echo $man; ?>>Man</option>
                                    <option value="Vrouw" <?php echo $vrouw; ?>>Vrouw</option>
                                </select>
                            </td>
                            <td id="GeslachtError" class="Error" ></td>
                        </tr>
                        <tr>
                            <td>Bedrijf:</td>
                            <td> 
                                <input type="text" name="Bedrijf" 
                                       value="<?php echo mysql_real_escape_string(htmlentities($gegevens['company'])); ?>"/>
                            </td>
                            <td id="BedrijfError" class="Error" ></td>
                        </tr>
                        <tr>
                            <td>Geboortedatum:</td>
                            <td> 
                                <input type="text" name="dag" maxlength= " 2 " size="1" value="<?php echo $day; ?>" />-
                                <input type="text" name="maand" maxlength="2 " size="1" value="<?php echo $month; ?>" />-
                                <input type="text" name="jaar" maxlength= "4 " size="2" value="<?php echo $year; ?>" />
                            </td>
                            <td id="GeboorteDatumError" class="Error" ></td><br />
                        </tr>
                        <tr>
                            <td>Adres:</td>
                            <td> 
                                <input type="text" name="Adres" 
                                       value="<?php echo mysql_real_escape_string(htmlentities($gegevens['address'])); ?>" />
                            </td>
                            <td id="AdresError" class="Error" ></td>
                        </tr>
                        <tr>
                            <td>Postcode:</td>
                            <td>
                                <input type="text" name="Postcode" maxlength="6 " size="6 " 
                                       value="<?php echo mysql_real_escape_string(htmlentities($gegevens['zip_code'])); ?>" />
                            </td>
                            <td id="PostcodeError" class="Error" ></td>
                        </tr>
                        <tr>
                            <td>Woonplaats:</td>
                            <td> 
                                <input type="text" name="Woonplaats" 
                                       value="<?php echo mysql_real_escape_string(htmlentities($gegevens['city'])); ?>" />
                            </td>
                            <td id="WoonplaatsError" class="Error" ></td>
                        </tr>
                        <tr>
                            <td>Land:</td>
                            <td> 
                                <input type="text" name="Land" 
                                       value="<?php echo mysql_real_escape_string(htmlentities($gegevens['country'])); ?>" />
                            </td>
                            <td id="LandError" class="Error" ></td>
                        </tr>
                        </tr>
                        <tr>
                            <td>Telefoonnummer:</td>
                            <td> 
                                <input type="text" name="Telefoonnummer" 
                                       value="0<?php echo mysql_real_escape_string(htmlentities($gegevens['phone_number'])); ?>" />
                            </td>
                            <td id="TelefoonnummerError" class="Error" ></td>
                        </tr>
                        <tr>
                            <td>Mobielnummer:</td>
                            <td>
                                <input type="text" name="Mobielnummer" maxlength="10"  
                                       value="<?php
            if ($gegevens['mobile_number']) {
                echo "0" . mysql_real_escape_string(htmlentities($gegevens['mobile_number']));
            }
            ?>" />
                            </td>
                            <td id="MobielnummerError" class="Error" ></td>
                        </tr>
                        <tr>
                            <td>E-mailadres:</td>
                            <td>
                                <input type="text" name="Email" 
                                       value="<?php echo mysql_real_escape_string(htmlentities($gegevens['email'])); ?>" />
                            </td>
                            <td id="EmailError" class="Error" ></td>
                        </tr>
                        <tr>
                            <td>Bankrekeningnummer:</td>
                            <td>
                                <input type="text" name="Bankrekeningnummer" maxlength="12"
                                       value="<?php echo $gegevens['bank_number']; ?>" />
                            </td>
                            <td id="BankrekeningnummerError" class="Error" ></td>
                        </tr>
                        <tr>
                            <td>Creditcardnummer:</td>
                            <td>
                                <input type="text" name="Creditcardnummer" maxlength ="16"
                                       value="<?php echo $gegevens['creditcard_number']; ?>" />
                            </td>
                            <td id="CreditcardnummerError" class="Error" ></td>
                        </tr>
                        <tr>
                            <td>Foto-link:</td>
                            <td><TEXTAREA name="Newphoto" id="newfoto" rows="4" cols="20"><?php echo mysql_real_escape_string(htmlentities($gegevens['photo'])); ?></TEXTAREA></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><a href="wachtwoordwijzigen.php" class="donker">Wachtwoord wijzigen?</a></td>
                            <td><input type="submit" value="Update" /></td>
                            <td></td>
                        </tr>
                </form>						
    </table> 
    </td>
    </tr>
    </table>
    <?php
    if (!empty($_POST)) {
        if (!empty($_GET)) {
            include("Fileupload.php");
            ?>
            <script type="text/javascript">
            <?php
            rename('/datastore/webdb1243/htdocs/Uploads/' . $_FILES["file"]["name"], '/datastore/webdb1243/htdocs/Uploads/account' . $accountnummer);
            $hey = "Uploads/account" . $accountnummer;
            echo"verander_fot(\"" . $hey . "\");";
            ?>
            </script>
            <?php
        }
        $gebruikersquery = mysql_query("SELECT * from account WHERE email = '" . mysql_real_escape_string(htmlentities($_POST['Email'])) . "'");
        $bestaatal = mysql_fetch_array($gebruikersquery);

// Als het emailadres is gewijzigd en het al in de database staat, dan kunnen de gegevens niet gewijzigd worden.
// Het emailadres is immers onze unieke gebruikersnaam.

        if ($bestaatal && ($_POST['Email'] != $gegevens['email'])) {
            echo "<p>Er is al een gebruiker geregistreerd met dit emailadres. Uw gegevens zijn niet gewijzigd. <br/ >";
            echo "<a href='account wijzigen.php'>Probeer opnieuw</a>.</p>";
        } else {
            mysql_query("UPDATE  account SET  first_name =  '" .
                    mysql_real_escape_string(htmlentities($_POST['Voornaam'])) . "' , last_name = '" . mysql_real_escape_string(htmlentities($_POST['Achternaam'])) . "', 
		extra_name = '" . mysql_real_escape_string(htmlentities($_POST['Tussenvoegsel'])) . "', sex = '" .
                    mysql_real_escape_string(htmlentities($_POST['Geslacht'])) . "', 
		photo = '" . mysql_real_escape_string(htmlentities($_POST['Newphoto'])) . "', 
		company = '" . mysql_real_escape_string(htmlentities($_POST['Bedrijf'])) . "', date_birth = '" .
                    $_POST['jaar'] . "-" . $_POST['maand'] . "-" . $_POST['dag'] . "', 
		address = '" . mysql_real_escape_string(htmlentities($_POST['Adres'])) . "', zip_code = '" . mysql_real_escape_string(htmlentities($_POST['Postcode'])) . "', 
		city = '" . mysql_real_escape_string(htmlentities($_POST['Woonplaats'])) . "', country = '" . mysql_real_escape_string(htmlentities($_POST['Land'])) . "', 
		phone_number = '" . mysql_real_escape_string(htmlentities($_POST['Telefoonnummer'])) . "', mobile_number = '" . mysql_real_escape_string(htmlentities($_POST['Mobielnummer'])) . "', 
		email = '" . mysql_real_escape_string(htmlentities($_POST['Email'])) . "', bank_number = '" . mysql_real_escape_string(htmlentities($_POST['Bankrekeningnummer'])) . "',
		creditcard_number = '" . mysql_real_escape_string(htmlentities($_POST['Creditcardnummer'])) . "'
		WHERE  account_number =" . $accountnummer);
            $_SESSION['voornaam'] = $_POST['Voornaam'];
            $_SESSION['achternaam'] = $_POST['Achternaam'];
            ?>
            <script type="text/javascript">
                window.open("account.php",'_self','',true);
            </script>
            <?php
        }
    }
echo "</div>";
session_write_close();
mysql_close($con);
include("footer.php");
?>