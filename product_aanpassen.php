<?php
include("header.php");
include("connect.php");
echo "<div id='midden'>";
if($rechten>1){
	if(!empty($_POST)){
		$nummer = $_POST['product'];
		if($nummer){
			$alles = mysql_query("SELECT * FROM products WHERE product_number = $nummer");
			$array = mysql_fetch_array($alles);
			if(!empty($array['product_number'])){
				echo "<b>U zocht op het productnummer: ".$nummer."</b><br />";
				$merknummer = $array["brand_number"];
				$merkalles = mysql_query("SELECT * FROM brands WHERE brand_number = '$merknummer'");
				$merkarray = mysql_fetch_array($merkalles);
				$categorienummer =$array["category"];
				$categoriealles = mysql_query("SELECT * FROM categories WHERE category_number = '$categorienummer'");
				$categoriearray = mysql_fetch_array($categoriealles);
				echo '<form method="post" action="product_change.php">';
				echo '<input type="hidden" name="product_number" value="'.$nummer.'"/>';
				echo '	<table>';
				echo '		<th colspan="2"><h1>Product Aanpassen</h1></th>';
				echo '		<tr><td>Productnaam:</td><td> <input type="text" name="product_name" value="' . $array["product_name"] . '"/></td></tr>';
				echo '		<tr><td>Prijs:</td><td><input type="text" name="price" value="'.$array["price"].'"/></td></tr>';
				echo '		<tr><td>Aantal:</td><td><input type="text" name="stock" value="'.$array["stock"].'"/></td></tr>';
				echo '		<tr><td>Foto:</td><td><input type="text" name="product_photo" value="'.$array["product_photo"].'"/></td></tr>';
				echo '		<tr><td>Beschrijving:</td><td><input type="text" name="description" value="'.$array["description"].'"/></td></tr>';
				echo '		<tr><td></td><td><input type="submit" value="Verzenden"</td></tr>';
				echo '	</table>';
				echo '</form> <br /><br />';
				echo '<table><th colspan="2"><h2>Verdere informatie</h2></th>';
				echo '<tr><td>Merk:</td><td>'.$merkarray["brand_name"].'/></td></tr>';
				echo '<tr><td>Categorie:</td><td>'.$categoriearray["category_name"].'/></td></tr>';
				echo '<tr><td><b>Aantal verkocht</b>:</td><td>'.$array["sold"].'</td></tr>';
				echo '<tr><td><b>Aantal likes</b>:</td><td>'.$array["likes"].'</td></tr>';
				echo '<tr><td><b>Aantal dislikes</b>:</td><td>'.$array["dislikes"].'</td></tr></table>';
			}
			else{
				echo "Sorry, er staat geen product met product nummer ".$nummer." in onze database";
				echo "<br /><a href='product_aanpassen.php' class='donker'>Probeer opnieuw</a>";
			}
		}
		else{
			echo "Gelieve iets in te vullen <br />";
			echo "<a href='product_aanpassen.php' class='donker'>Probeer opnieuw</a>";
		}
	}
	else{
?>
	<h1>Producten aanpassen</h1>
	<form action="product_aanpassen.php" method="post">
		Vul hier het productnummer in van het product dat u wilt aanpassen:<br />
		<input type="text" name="product" /><br />
		<input type="submit" value="Zoeken"/>
	</form>
<?php
	}
}
else{
	echo'U bent niet bevoegd deze pagina te bekijken. <a href="index.html">Ga terug naar FABBA.nl</a>';
}
echo "</div>";
mysql_close($con);
include("footer.php");
?>