<?php
session_start();
$accountnummer = $_SESSION['accountnummer'];
session_write_close();
include("header.php");
include("connect.php");
$prop = mysql_query("SELECT * FROM products WHERE product_number=' $_POST[nummer] ' ");
$proparray = mysql_fetch_array($prop);
$temp = mysql_query("SELECT * FROM temp_order WHERE product_number=' $_POST[nummer] ' AND account_number = '$accountnummer'");
$temparray = mysql_fetch_array($temp);

if ( $temparray['amount'] != '' )
{
$newammount = $_POST['Aantal'] + $temparray['amount'];
mysql_query("UPDATE temp_order SET amount = '" . $newammount . "' WHERE product_number='". $_POST['nummer'] ."' AND account_number = '" . $accountnummer ."'");
}
else
{
mysql_query("INSERT INTO temp_order (product_number,account_number,amount) VALUES ( ' $_POST[nummer]','$accountnummer','$_POST[Aantal]')"); 
}
echo "<p> U heeft succesvol " . mysql_real_escape_string(htmlentities($_POST['Aantal'])) . " producten toegevoegd klik <a href='index.php' class='donker' >hier</a> om terug te gaan naar de homepage</p>";
if ( $_POST['Aantal'] <=  $proparray['stock']){ 

}
else
{ 
echo "<p> Wij hebben het aantal producten niet meer op voorraad, we hebben nog maar " . $proparray['stock'] ." op voorraad, De levering van uw producten duurt daarom iets langer. Klik <a href='index.php' class='donker' >hier</a> om terug te gaan naar de homepage</p>";
} 
include("footer.php");
?>