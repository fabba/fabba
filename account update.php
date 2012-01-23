<?php

$doorschrijven = true;
session_start();
$accountnummer = $_SESSION['accountnummer'];
session_write_close();
include("header.php");
include("connect.php");
mysql_query("UPDATE  account SET  first_name =  '" . $_POST['Voornaam'] . "' , last_name = '" . $_POST['Achternaam'] . "', 
			extra_name = '" . $_POST['Tussenvoegsel'] . "', sex = '" . $_POST['Geslacht'] . "', 
			company = '" . $_POST['Bedrijf'] . "', date_birth = '" . $_POST['jaar'] . "-" . $_POST['maand'] . "-" . $_POST['dag'] . "', 
			address = '" . $_POST['Adres'] . "', zip_code = '" . $_POST['Postcode'] . "', 
			city = '" . $_POST['Woonplaats'] . "', country = '" . $_POST['Land'] . "', 
			phone_number = '" . $_POST['Telefoonnummer'] . "', mobile_number = '" . $_POST['Mobielnummer'] . "', 
			email = '" . $_POST['Email'] . "', bank_number = '" . $_POST['Bankrekeningnummer'] . "',
			creditcard_number = '" . $_POST['Creditcardnummer'] . "', 
			photo = '" . $_POST['Newphoto'] . "'
			WHERE  account_number =" . $accountnummer);

$_SESSION['voornaam'] = $_POST['Voornaam'];
$_SESSION['achternaam'] = $_POST['Achternaam'];
?>
<script type="text/javascript">
    window.open("account.php",'_self','',true);
</script>
<?php include("footer.php"); ?>