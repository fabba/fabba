<?php
include("header.php");
include("connect.php");
echo "<div id='midden'>";
if($rechten>1){
	if(!empty($_POST)){
		$orderquery = mysql_query("SELECT * from orders where order_number=".$_POST['order_number']);
		$bestelling = mysql_fetch_array($orderquery);
		if(empty($bestelling)){
			echo "Het ordernummer ".$_POST['order_number']." is niet gevonden in onze database. <br />";
			echo "<a href ='bestellingenbeheren.php'>Zoeken op een ander nummer</a>";
		}
		else{
			echo "U heeft gezocht op bestellingsnummer ".$_POST['order_number'].". ";
			echo "<a href ='bestellingenbeheren.php'>Zoeken op een ander nummer</a> <br />";
			echo "Laat onderstaande velden leeg als het product nog niet geleverd of betaald is. <br />";
			echo "<table><th colspan='2'><h1>Bestelling beheren</h1></th>";
			echo "<tr><td>Productnummer:</td><td>".$bestelling['product_number']."</td></tr>";
			echo "<tr><td>Accountnummer:</td><td>".$bestelling['account_number']."</td></tr>";
			echo "<tr><td>Prijs:</td><td>".$bestelling['price']."</td></tr>";
			echo "<form action='bestellingveranderen.php' method = 'post'>";
			echo "<input type='hidden' name='order_number' value=".$_POST['order_number']." />";
			echo "<tr><td>Betaaldatum:</td><td><input type='text name='date_paid' /></td></tr>";
			echo "<tr><td>Leveringsdatum:</td><td><input type='text' name=date_delivered'/></td></tr>";
			echo "<tr><td></td><td><input type='submit' /></td></tr>";
			echo "</form></table>";
		}
}
	else{
		echo "<h1>Bestellingen beheren</h1>";
		echo "Vul hier het ordernummer in van de bestelling die u wilt aanpassen:";
		echo "<form action='bestellingenbeheren.php' method = 'post'>";
		echo "<input type='text' name='order_number' />";
		echo "<input type='submit' value='zoeken' />";
		echo "</form><br />";
		echo "<a href='account.php' class='donker'>Terug naar mijn account</a>";

}
}
else{
	echo "Deze pagina is niet beschikbaar voor u. <br />";
	echo "<a href='index.php'>Terug naar FABBA.nl</a>.";
}
mysql_close($con);
echo "</div>";
include("footer.php");
?>