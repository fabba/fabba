<?php
include("header.php");
include("connect.php");
$nummer=$_POST['product_number'];
mysql_query("UPDATE  products SET  
			product_name =  '" . $_POST['product_name'] . "' , 
			price = '" . $_POST['price'] . "', 
			stock = '" . $_POST['stock'] . "', 
			product_photo = '" . $_POST['product_photo'] . "', 
			decription = '" . $_POST['description'] . "' 
			WHERE  product_number =" . $nummer);
echo "<div id='midden'>";
echo "Uw product is succesvol aangepast.<br />";
echo "De naam van productnummer ".$_POST['product_number']." is nu ".$_POST['product_name']."! <br />";
echo "<a href='account.php' class='donker'>Terug naar mijn account</a>";
echo "</div>";
mysql_close($con);
include("footer.php");
?>