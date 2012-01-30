<?php

include("header.php");
include("connect.php");
if (mysql_query("INSERT INTO account (password,first_name,last_name,extra_name,company,address,zip_code,city,country,phone_number,mobile_number,bank_number,creditcard_number,sex,date_birth,email)
VALUES('$_POST[Wachtwoord]','$_POST[Voornaam]','$_POST[Achternaam]','$_POST[Tussenvoegsel]','$_POST[Bedrijf]','$_POST[Adres]','$_POST[Postcode]','$_POST[Woonplaats]','$_POST[Land]','$_POST[Telefoonnummer]','$_POST[Mobielnummer]','$_POST[Bankrekeningnummer]','$_POST[Creditcardnummer]','$_POST[Geslacht]','$_POST[jaar]-$_POST[maand]-$_POST[dag]','$_POST[Email]')")) {
    ?>
    <script type="text/javascript">
            window.open("login.php",'_self','',true);
    </script>
    <?php
} else {
    ?>

    <p>U bent succesvol registreert klik<a href='index.php' class='donker' >hier</a> om terug te gaan naar de homepage</p>
<?php

}
include("footer.php");
?>

