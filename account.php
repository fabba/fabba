<?php

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
    <img id="Afbeeld " src="<?php echo $gegevens['photo'] ?>" weight="100" height= "100"><br/>
    <b>Account</b><br />
    <?php if( $rechten > 1 ){ ?>
					<a href="account wijzigen.php">Mijn gegevens aanpassen</a><br />
                    <a href="categorie toevoegen.php">Categorie toevoegen</a> <br />
                    <a href="product_toevoegen.php">Product toevoegen</a><br /> 
					<a href="product_aanpassen.php">Product aanpassen</a><br />
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
        
        Klantnummer: <?php echo $gegevens['account_number']; ?><br />
        Achternaam: <?php echo $gegevens['last_name']; ?><br /> 
        Tussenvoegels: <?php echo $gegevens['extra_name']; ?><br /> 
        Voornaam: <?php echo $gegevens['first_name']; ?><br /> 
        Geslacht: <?php echo $gegevens['sex']; ?><br />
        Bedrijf: <?php echo $gegevens['company']; ?><br />
        Geboortedatum: <?php echo $gegevens['date_birth']; ?><br />
        Adres:<?php echo $gegevens['address']; ?><br />
        Postcode: <?php echo $gegevens['zip_code']; ?><br /> 
        Woonplaats: <?php echo $gegevens['city']; ?><br /> 
        Telefoonnummer: <?php echo $gegevens['phone_number']; ?><br />
        06-nummer <?php echo $gegevens['mobile_number']; ?><br />
        Emailadres: <?php echo $gegevens['email']; ?><br />
        Creditcardnummer: <?php echo $gegevens['creditcard_number']; ?><br />
        Bankrekeningnummer: <?php echo $gegevens['bank_number']; ?><br />
        </td>
        </tr>
        </table>
        </div>        
<?php } else { ?>
        <script type="text/javascript">
        window.open("index.php",'_self','',true);
        </script>
    <?php
}
        include("footer.php"); ?>
