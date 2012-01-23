<?php
include("header.php");

if($rechten==2){
	if (!empty($_POST)) {
		include("connect.php");
		if (mysql_query("INSERT INTO products (product_name,category,price,stock,product_photo,description,brand_number)
            VALUES(' " . mysql_real_escape_string(htmlentities($_POST[productnaam])) . "','" . mysql_real_escape_string(htmlentities($_POST[categorie])) . "','" . mysql_real_escape_string(htmlentities($_POST[prijs])) . "','" . mysql_real_escape_string(htmlentities($_POST[vooraad])) . "','" . mysql_real_escape_string(htmlentities($_POST[foto])) . "','" . mysql_real_escape_string(htmlentities($_POST[beschrijving])) . "','" . mysql_real_escape_string(htmlentities($_POST[merk])) . "')")) {
?>
        <script type="text/javascript">
            alert("Product toegevoegd");
            window.open("product_toevoegen.php",'_self','',true);
        </script>
        <?php
		} 	
		else {
			die('Connectiefout: ' . mysql_error());
			?>
			doet niet :c
			<?php
		}
		mysql_close($con);
	} 

	else {
    ?>
	<div id="midden">
	<form name="input" action="product_toevoegen.php" method="post">
		<table>
			<th colspan='2'><h1>Product toevoegen</h1></th>
			<tr><td>Productnaam:</td> <td><input type="text" name="productnaam" /></td></tr>
			<tr><td>Prijs:</td> <td><input type="text" name="prijs" /></td><tr>
			<tr><td>Merknaam:</td> <td><input type="text" name="merk" /></td></tr>
			<tr><td>Categorie:</td> <td><input type="text" name="categorie" /></td></tr>
			<tr><td>Vooraad:</td>	<td><input type="text" name="vooraad" /></td></tr> 
			<tr><td>Foto:</td> <td><input type="text" name="foto" /></td></tr>
			<tr><td>Beschrijving:</td><td><textarea name="beschrijving" rows="6" cols="40">Vul hier uw productbeschrijving in...</textarea></td></tr> 
			<tr><td></td>	<td><input type="submit" value="voeg toe" /> <a href="account.php" class="donker">Terug naar account pagina</a></td></tr>
		</table>
    </form>
	
	</div>


    <?php
	}
}
else{
?>
<div id="midden">
	U bent niet bevoegd deze pagina te bekijken. <a href="index.html">Terug naar FABBA.nl</a>
</div>
<?php
}
include("footer.php");
?>
