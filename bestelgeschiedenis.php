<?php include("header.php"); 
// Wat laten we hier allemaal zien? Hoe kun je meerdere orders laten zien, kan dit niet handiger met JavaScript?
// Ik (Carla) heb hier alles gedaan wat ik met php en html/css kon bedenken te doen, weet niet of het zo het handigst is..
// Ik ben er ook maar vanuit gegaan dat de admin zelf niets besteld.
include("connect.php");
if($rechten=1){
	echo "<h1>Bestelgeschiedenis</h1>";
	$bestellingen = mysql_query("SELECT * FROM orders WHERE account_number =".$accountnummer);
	$order = mysql_fetch_array($bestellingen);
	$productquery = mysql_query("SELECT * FROM products WHERE product_number=".$order['product_number']);
	$product = mysql_fetch_array($productquery);
	if(!empty($order)){
		// order_number, product_number, product_name [products], price, amount, price
		// amount, paid, date_paid, date_order, delivered, date_delivered, payment_method
		// address_delivery, address_bill
		// Totaal kolommen: 11
		echo "<table class='bestel'>
			<tr>
				<td><b>Bestellingsnummer</b></td> 
				<td><b>Productnummer</b></td>
				<td><b>Productnaam</b></td>
				<td><b>Prijs</b></td>
				<td><b>Aantal</b></td>
				<td><b>Datum bestelling</b></td>
				<td><b>Datum betaald</b></td>
				<td><b>Datum afgeleverd</b></td>
				<td><b>Betalingsmethode</b></td>
				<td><b>Leveringsadres</b></td>
				<td><b>Factuuradres</b></td>
			</tr>
			<tr>
				<td>".$order['order_number']."</td>
				<td>".$order['product_number']."</td>
				<td>".$product['product_name']."</td>
				<td>".$order['price']."</td>
				<td>".$order['amount']."</td>
				<td>".$order['date_order']."</td>";
			if(!empty($order['date_paid'])){
				echo "<td>".$order['date_paid']."</td>";
			}
			else{
				echo "<td>Nog niet betaald</td>";
			}
			if(!empty($order['delivered'])){
				echo "<td>".$order['date_delivered']."</td>";
			}
			else{
				echo "<td>Nog niet afgeleverd</td>";
			}
			echo"<td>".$order['payment_method']."</td>
				<td>".$order['address_delivery']."</td>
				<td>".$order['address_bill']."</td>
			</tr>
		</table> 
		";
	}
	else{
		echo "U heeft nog geen bestellingen gemaakt. <br /><a href ='productlist.php' class='donker'>Bekijk ons geweldig aanbod eens!</a>";
	}
}
else{
	echo "U bent niet ingelogd. <br /> <a href='index.php'>Terug naar FABBA.nl</a>";
}
mysql_close($con);
include("footer.php"); ?>
