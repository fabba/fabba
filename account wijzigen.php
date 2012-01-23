<?php 
session_start();
$accountnummer = $_SESSION['accountnummer'];
session_write_close();
include("header.php"); 
include("connect.php");
$userzoek =  mysql_query("SELECT * FROM account WHERE account_number = $accountnummer ") ;
$gegevens = mysql_fetch_array( $userzoek ) ;
$vrouw = "";
$man = "";
if($gegevens['sex'] == "Vrouw")
{
  
	$vrouw = "SELECTED";
}
else
{
	$man = "SELECTED";
	}

$month = date("m",strtotime($gegevens['date_birth'] ));
$year = date("y",strtotime($gegevens['date_birth'] ));
$day = date("d",strtotime($gegevens['date_birth'] ));
?>
<script type="text/javascript">
            function validateForm()
            {
                var achternaam =document.forms["updateForm"]["Achternaam"].value;
                var doorgaan = true ;
                if ( achternaam==null || achternaam=="" )
                {
                    document.getElementById("AchternaamError" ).innerHTML = "U bent achternaam vergeten in te vullen." ;
                    doorgaan = false ;
                } else {
                    document.getElementById("AchternaamError" ).innerHTML = "" ;
                }
                
                var voornaam = document.forms["updateForm"]["Voornaam"].value;
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
                
                var dag = document.forms["updateForm"]["dag"].value;
                var maand = document.forms["updateForm"]["maand"].value;
                var jaar = document.forms["updateForm"]["jaar"].value;
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
                
                
                var adres = document.forms["updateForm"]["Adres"].value;
                if( adres == "" || adres == null ){
                    document.getElementById("AdresError" ).innerHTML = "Adres is niet ingevuld." ;
                    doorgaan = false ;
                }  else {
                    document.getElementById("AdresError" ).innerHTML = "" ;
                }
                var postcode = document.forms["updateForm"]["Postcode"].value;
                if( postcode == "" || postcode == null ){
                    document.getElementById("PostcodeError" ).innerHTML = "Postcode is niet ingevuld." ;
                    doorgaan = false ;
                }  else {
                    document.getElementById("PostcodeError" ).innerHTML = "" ;
                }
                var woonplaats = document.forms["updateForm"]["Woonplaats"].value;
                if( woonplaats == "" || woonplaats == null ){
                    document.getElementById("WoonplaatsError" ).innerHTML = "Woonplaats is niet ingevuld." ;
                    doorgaan = false ;
                }  else {
                    document.getElementById("WoonplaatsError" ).innerHTML = "" ;
                }
                var land = document.forms["updateForm"]["Land"].value;
                if( land == "" || land == null ){
                    document.getElementById("LandError" ).innerHTML = "Land is niet ingevuld." ;
                    doorgaan = false ;
                }  else {
                    document.getElementById("LandError" ).innerHTML = "" ;
                }
                
                var telefoonnummer = document.forms["updateForm"]["Telefoonnummer"].value;
                if( telefoonnummer == "" || telefoonnummer == null ){
                    document.getElementById("TelefoonnummerError" ).innerHTML = "Er is geen telefoonnummer ingevuld." ;
                    doorgaan = false ;
                } else if(  telefoonnummer.length < 10 ){
                    document.getElementById("TelefoonnummerError" ).innerHTML = "Telefoonnummer heeft minder dan 10 getallen." ;
                    doorgaan = false ;
                }  else {
                    document.getElementById("TelefoonnummerError" ).innerHTML = "" ;
                }
                
                var mobielnummer = document.forms["updateForm"]["Mobielnummer"].value;
                if( mobielnummer != "" && mobielnummer!=null  && mobielnummer.length < 10 ){
                    document.getElementById("MobielnummerError" ).innerHTML = "Mobielnummer heeft minder dan 10 getallen." ;
                    doorgaan = false ;
                } else if( mobielnummer != "" && mobielnummer!=null  && mobielnummer.substring(0,2) != "06" ){
                    document.getElementById("MobielnummerError" ).innerHTML = "Dit mobiele nummer begin niet met 06." ;
                    doorgaan = false ;
                } else {
                    document.getElementById("MobielnummerError" ).innerHTML = "";
                }
                
                var email = document.forms["updateForm"]["Email"].value;
                if( email == "" || email == null ){
                    document.getElementById("EmailError" ).innerHTML = "Email is niet ingevuld." ;
                    doorgaan = false ;
                } else {
                    document.getElementById("EmailError" ).innerHTML = "";
                }
                
                var bankrekening = document.forms["updateForm"]["Bankrekeningnummer"].value;
                if( bankrekening == "" || bankrekening == null ){
                    document.getElementById("BankrekeningnummerError" ).innerHTML = "Bankrekeningnummer is niet ingevuld." ;
                    doorgaan = false ;
                } else {
                    document.getElementById("BankrekeningnummerError" ).innerHTML = "";
                }
               
                var creditcard = document.forms["updateForm"]["Creditcardnummer"].value;
                if( creditcard == "" || creditcard == null ){
                    document.getElementById("CreditcardnummerError" ).innerHTML = "Creditcardnummer is niet ingevuld." ;
                    doorgaan = false ;
                }  else {
                    document.getElementById("CreditcardnummerError" ).innerHTML = "";
                }
              
                
                return doorgaan ;
            }
        </script>
	<?php
echo ' 
	 

        <table width="60%" border="0">
            <tr valign="top">
                <td style="background-color:#009CEB;width:200px;text-align:top;">
					<img id="Afbeeld " src="'. $gegevens['photo'] .'" weight="100" height= "100"><br/>
                    <b>Account</b><br />
                    <a href="bestelgeschiedenis.php">Bestelstatus/geschiedenis</a> <br />
                    <a href="winkelwagentje.php">Winkelwagen</a> <br />
                    <a href="account wijzigen.php">Mijn gegevens aanpassen</a> 

                    <br />
                    <a href="categorie toevoegen.php">Categorie toevoegen</a> <br />
                    <a href="product toevoegen.php">Product toevoegen</a> 
                </td>
                <td style="background-color:#eeeeee;height:100px;width:90%;text-align:right;">
                    <b>Mijn Gegevens</b> <br />
                    <form name="updateForm" method="post" onsubmit="return validateForm()" action="account update.php">
					
                        <table>

                            <tr>
                                <td>Achternaam:</td> <td>   <input type="text" name="Achternaam" value="' . $gegevens['last_name'] . '"/></td><td id="AchternaamError" class="Error" ></td>
							</tr>
                            <tr>
                                <td>Tussenvoegels:</td><td> <input type="text" name="Tussenvoegsel" value="' . $gegevens['extra_name'] . '"/></td><td id="TussenvoegselError" class="Error" ></td>
                            </tr>
                            <tr>
                                <td>Voornaam:</td><td> <input type="text" name="Voornaam" value="' . $gegevens['first_name'] . '"/></td><td id="VoornaamError" class="Error" ></td>
                            </tr>
                            <tr>
                                <td>Geslacht</td><td> <select type="text" name="Geslacht" />
                                    <option value="Man" ' . $man . '>Man</option>
                                    <option value="Vrouw" ' . $vrouw .'>Vrouw</option></td><td id="GeslachtError" class="Error" ></td>
				
								
                            </tr>
                            <tr>
                                <td>Bedrijf:</td><td> <input type="text" name="Bedrijf" value="' . $gegevens['company'] . '"/></td><td id="BedrijfError" class="Error" ></td>
                            </tr>
                            <tr>
                                <td>Geboortedatum:</td><td> <input type="text" name="dag" maxlength= " 2 " size="1 " value="' . $day . '"/>-<input type="text" name="maand" maxlength="2 " size=" 1 " value="' . $month . '"/>-<input type="text" name="jaar" maxlength="4 " size="2 " value="' . $year . '"/></td><td id="GeboorteDatumError" class="Error" ></td><br />
                            </tr>
                            <tr>
                                <td>Adres:</td><td> <input type="text" name="Adres" value="' . $gegevens['address'] . '"/></td><td id="AdresError" class="Error" ></td>
                            </tr>
                            <tr>
                                <td>Postcode</td><td> <input type="text" name="Postcode" maxlength="6 " size="6 " value="' . $gegevens['zip_code'] . '"/></td><td id="PostcodeError" class="Error" ></td>
                            </tr>
                            <tr>
                                <td>Woonplaats:</td><td> <input type="text" name="Woonplaats" value="' . $gegevens['city'] . '"/></td><td id="WoonplaatsError" class="Error" ></td>
                            </tr>
                            <tr>
                                <td>Land:</td><td> <input type="text" name="Land" value="' . $gegevens['country'] . '"/></td><td id="LandError" class="Error" ></td>
                </tr>
                            </tr>
                            <tr>
                                <td>Telefoonnummer</td><td> <input type="text" name="Telefoonnummer" value="' . $gegevens['phone_number'] . '"/></td><td id="TelefoonnummerError" class="Error" ></td>
                            </tr>
                            <tr>
                                <td>Mobielnummer:</td><td> <input type="text" name="Mobielnummer" maxlength="10"  value="0' . $gegevens['mobile_number'] . '"/></td><td id="MobielnummerError" class="Error" ></td>
                            </tr>
                            <tr>
                                <td>E-mailadres:</td><td> <input type="text" name="Email" value="' . $gegevens['email'] . '"/></td><td id="EmailError" class="Error" ></td>
                            </tr>
                            <tr>
                                <td>Bankrekeningnummer</td><td> <input type="text" name="Bankrekeningnummer" value="' . $gegevens['bank_number'] . '"/></td><td id="BankrekeningnummerError" class="Error" ></td>
                            </tr>
                            <tr>
                                <td>Creditcardnummer</td><td> <input type="text" name="Creditcardnummer" value="' . $gegevens['creditcard_number'] . '"/></td><td id="CreditcardnummerError" class="Error" ></td>
                            </tr>
							<tr>
								<td>Foto-link</td><td> <TEXTAREA Name="Newphoto" rows="4" cols="20">'. $gegevens['photo'] . '</TEXTAREA></td>
							</tr>
							<tr>
                                    <td></td><td><input type="submit" value="Update" /></td>
							</tr>
							</form>
							
						
                        </table> 
						
						</td>
				
					
				 
			 
            </tr>

        
        </table>';


 include("footer.php"); ?>