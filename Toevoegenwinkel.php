<?php
session_start();
$accountnummer = $_SESSION['accountnummer'];
session_write_close();
include("header.php");
include("connect.php");
mysql_query("INSERT INTO temp_order (product_number,account_number,amount) VALUES ( ' $_POST[nummer]','$accountnummer','$_POST[Aantal]')"); 
echo "<p> U heeft succesvol " . $_POST['Aantal'] . " producten toegevoegd klik <a href='index.php' class='donker' >hier</a> om terug te gaan naar de homepage</p>";
include("footer.php");
?>