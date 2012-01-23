<?php 
include("header.php"); 
include("connect.php");

if(!empty($_POST){
$tempquery = mysql_query("SELECT * FROM temp_order where account_number='$accountnumber'");
// temp_order: temp_number, product_number, account_number, amount
// orders: order_number, product_number, account_number, price, amount, paid, date_paid, date_order, 
// req_date_delivered, paymment_method, address_delivery, address_bill

$temp = mysql_fetch_array($tempquery);
$productnummer = $temp['product_number'];
$aantal = $temp['amount'];

$productquery = mysql_query("SELECT * FROM products where product_number='$productnummer'");
$product = mysql_fetch_array($productquery);
$prijs = $product['price']; 

$datum= date(Y-m-d);
mysql_query("INSERT INTO orders (product_number,account_number,amount,  price, amount, date_order, 
req_date_delivered, paymment_method, address_delivery, address_bill) VALUES (
'$productnummer','$accountnummer','$prijs','$aantal','$datum',".$_POST['req_date_delivered'].","
.$_POST['payment_method'].",".$_POST['address_delivery'].",".$_POST['address_bill'].")"); 
mysql_query("DELETE from temp_order where account_number='$accountnummer'");
?>
      
<div id="midden">
	<h1> U heeft succesvol afgerekent</h1>
	Bedankt voor het kopen bij FABBA.NL!<br />
	<a href="index.php" class="donker">Terug naar FABBA.nl</a>
</div>
<?php 
}
else{
	$accountquery = mysql_query("SELECT from accounts where account_number='$accountnummer'");
	$account = mysql_fetch_row($accountquery);
	$adres=$account['address'];
	echo'
<form method="post" action="succesvol.php">
	<table>
		<th colspan="2">Factuur- en leveringsinformatie</th>
		<tr><td>Leveringsadres:</td><td><input type="text" name="address_delivery" value="'.$adres.'"/></td></tr>
		<tr><td>Factuuradres:</td><td><input type="text" name="address_bill" value="'.$adres.'"/></td></tr>
		<tr><td>Betalingsmethode:</td><td><input type="text" name="payment_method"/></td></tr>
		<tr><td>Gewenste leveringsdatum:</td><td><input type="text" name="req_date_delivered"/></td></tr>
	</table>
</form>'; // Leveringsdatum controleren!
}
mysql_close($con);
include("footer.php"); ?>
