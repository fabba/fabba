<?php
include("header.php");
include("connect.php");
$order=$_POST['order_number'];

if(isset($_POST['date_delivered'])||isset($_POST['date_paid'])){
	if(isset($_POST['date_paid'])){
		mysql_query("UPDATE  orders SET paid ='1', date_paid ='" . $_POST['date_paid']. "'
		WHERE  order_number =" . $order);
	}
	if(isset($_POST['date_delivered'])){
		mysql_query("UPDATE  orders SET delivered='1',date_delivered ='" . $_POST['date_delivered']. "' 
		WHERE  order_number =" . $order);
	}
	echo "<div id='midden'>";
	echo "De bestelling is succesvol aangepast.<br />";
	echo "<a href='account.php' class='donker'>Terug naar mijn account</a>";
	echo "</div>";
}
else{
	echo "Er is niets aangepast. ";
	echo "<a href='index.html'>Terug naar FABBA.nl </a>";
}
mysql_close($con);
include("footer.php");
?>