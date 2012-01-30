<?php 
include("header.php");
include("connect.php");

// De product aanpaspagina
// Op deze pagina kan de beheerder gemakkelijk een product aanpassen. 
// Om de pagina te zien, dient de aanvrager van de pagina beheerdersrechten te hebben en een productnummer mee te geven.
// Als er iets gepost is, wordt dit ingevuld in de database. Het formulier is altijd zichtbaar.

if(isset($_GET["product_number"])){
	$product_nummer = $_GET["product_number"];
	$gelukt = false ;
	if($ingelogd&&$rechten>1){ 
		if(!empty($_POST)){ 
			$bar_query = mysql_query("SELECT * FROM bargains WHERE product_number=$product_nummer");
			$bar = mysql_fetch_array($bar_query);
			if(!empty($bar)){
				mysql_query("DELETE FROM bargains where product_number = '".mysql_real_escape_string(htmlentities($product_nummer))."'");
			}
			if (!empty($_POST['aanbieding_komma'])||!empty($_POST['aanbieding_prijs'])){
				$nieuweaanbiedingsprijs = $_POST['aanbieding_prijs'] * 100 + $_POST['aanbieding_komma'];
				mysql_query("INSERT INTO bargains (product_number, temp_price, from_date, to_date) 
				VALUES(' " . mysql_real_escape_string(htmlentities($product_nummer)) . "','" .
				mysql_real_escape_string(htmlentities($nieuweaanbiedingsprijs)) . "','" . 
				date("Y-m-d") . "','" . 
				mysql_real_escape_string(htmlentities($_POST['to_date'])). "')");
			}
            
			$nieuweprijs = $_POST['product_prijs'] * 100 + $_POST['prijskomma'] ;
            $gelukt = mysql_query("UPDATE  products SET  
			product_name ='" . mysql_real_escape_string(htmlentities($_POST['product_naam'])) . "' , 
			price ='" . mysql_real_escape_string(htmlentities($nieuweprijs)) . "', 
			stock ='" . mysql_real_escape_string(htmlentities($_POST['product_voorraad'])) . "', 
			product_photo ='" . mysql_real_escape_string(htmlentities($_POST['product_foto'])) . "', 
			description = '" . mysql_real_escape_string(htmlentities($_POST['product_beschrijving'])) . "', 
			brand_number = '" . mysql_real_escape_string(htmlentities($_POST['product_merk'])) . "',
			category = '" . mysql_real_escape_string(htmlentities($_POST['product_categorie'])) . "',
			likes = '" . mysql_real_escape_string(htmlentities($_POST['product_likes'])) . "',
			dislikes = '" . mysql_real_escape_string(htmlentities($_POST['product_dislikes'])) . "'
			WHERE  product_number =" . $product_nummer ) ;
		} 
               
        $bargains_query = mysql_query("SELECT * FROM bargains WHERE product_number=$product_nummer");
		$bargains = mysql_fetch_array($bargains_query);
		$totalebargainprijs = $bargains['temp_price'];
		$bargainprijs = floor($totalebargainprijs/100);
		$bargainkomma = $totalebargainprijs % 100;
		if(strlen($bargainkomma)<2){
			$bargainkomma = "0".$bargainkomma;
		}
        $product_query = mysql_query("SELECT * FROM products WHERE product_number=$product_nummer");
        $product = mysql_fetch_array($product_query);
		$Prijst = mysql_real_escape_string(htmlentities($product['price']));
		
		$prijs = floor($Prijst / 100); 
		$prijskomma =  ($Prijst % 100);
		if( strlen($prijskomma)<2){
			$prijskomma = "0".$prijskomma;
		}
		
        ?>
        <form method="post" action="product_aanpassen.php?product_number=<?php echo $product_nummer ?>">
        <table width="100%" border="0">
          
            <tr>
                <td/>
                <td colspan="2" style="background-color:transparent">
                    <?php if($gelukt) { ?>
                        <h1>Product Is Aangepast</h1>
                    <?php } else { ?>
                        <h1>Product Aanpassen</h1>
                    <?php } ?>
                </td>
            </tr>

            <tr valign="top">
                <td style="background-color:transparent;width:30%;height:60%;text-align:right;">
                    <img src="<?php echo $product['product_photo'] ?>" width="60%" height="60%" / >
                    <textarea name="product_foto" style="resize: none;" rows="1" cols="40"><?php echo $product['product_photo']; ?></textarea>
                </td>
                <td style="height:300px;width:40%;text-align:top;">

                    <b>Productnaam</b>:<textarea name="product_naam" style="resize: none;" rows="1" cols="40"><?php echo mysql_real_escape_string(htmlentities($product['product_name'])); ?></textarea> <br />
                    <b>Prijs</b>: &#8364;<input type="text" name="product_prijs" size= "4" style="text-align:right;" value="<?php echo $prijs ?>"/>,<input type="text" name="prijskomma" maxlength="2" size="2" value="<?php echo $prijskomma ?>"/>  <br />
                    <b>Productbeschrijving</b>:<textarea name="product_beschrijving" style="resize: none;" rows="20" cols="70"><?php echo mysql_real_escape_string(htmlentities($product['description'])); ?></textarea><br />
                    <b>Voorraad</b>:<input type="text" name="product_voorraad" value="<?php echo mysql_real_escape_string(htmlentities($product['stock'])); ?>"/> <br />
                    <b>Categorie</b>:<select name="product_categorie" > 
					<?php
					$category = mysql_query("SELECT * FROM categories");
					while ( $catearray = mysql_fetch_array($category) ){ ?>
						<option value="<?php echo mysql_real_escape_string(htmlentities($catearray['category_number'])) ; ?>" <?php if( $catearray['category_number'] == $product['category']){echo 'selected="selected"' ;}?> ><?php echo mysql_real_escape_string(htmlentities($catearray['category_name']));?></option><br />
					<?php } 
					?> </select><br />
					 <b>Merk</b>:<select name="product_merk" /> 
					<?php
					$brand = mysql_query("SELECT * FROM brands");
					while ( $brandarray = mysql_fetch_array($brand) )
					{ 
					?>
						<option value="<?php echo mysql_real_escape_string(htmlentities($brandarray['brand_number'])); ?>" <?php if( $brandarray['brand_number'] == $product['brand_number']){echo 'selected="selected"' ;}?> > <?php echo mysql_real_escape_string(htmlentities($brandarray['brand_name'])); ?></option><br />
					<?php ;
					} 
					?>
					</select>
					<br /><br />
					<?php if(!empty($bargains)) { ?>
					Dit product is een aanbieding. Leeg onderstaand veld als dit geen aanbieding meer moet zijn. <br />
					<b>Aanbiedingsprijs</b>: 
						<input type="text" name ="aanbieding_prijs" size="4" value="<?php echo $bargainprijs; ?>"/>,<input type="text" name ="aanbieding_komma" size = "2" maxlength = "2" value="<?php echo $bargainkomma; ?>"/><br />
					<b>Datum tot (jjjj-mm-dd)</b>: <input type="text" name="to_date" value="<?php echo mysql_real_escape_string(htmlentities($bargains['to_date'])); ?>"/><br />
					<?php } else{ ?>
					Dit product is geen aanbieding. Vul onderstaand veld in om het een aanbieding te maken. <br />
					<b>Aanbiedingsprijs</b>: <input type="text" name ="aanbieding_prijs" size = "4" />,<input type="text" name ="aanbieding_komma" size="2"  maxlength = "2" /><br />
					<b>Datum tot (jjjj-mm-dd)</b>: <input type="text" name="to_date" /><br />
					<?php } ?>

                </td>
                <td style="width:30%;text-align:right;">
                    <input type="submit" value="Pas aan"/><br /><br />
                    <input type="button" value="VERWIJDER dit product" onclick="window.open('product_verwijderen.php?nummer=<?php echo $product_nummer ?>','_self');"><br /><br />
                    <input type="button" value="terug" onclick="window.open('productpagina.php?product_number=<?php echo $product_nummer ?>','_self');"><br />
                    <font color="green">FABJA!!: <input type="text" name="product_likes" value="<?php echo mysql_real_escape_string(htmlentities($product['likes'])); ?>"/></font> <br />

                    <font color="red">FABNEE..: <input type="text" name="product_dislikes" value="<?php echo mysql_real_escape_string(htmlentities($product['dislikes'])); ?>"/></font>
                    <br />
                    <br />

                </td>
            </tr>

        </table>
        </form>
<?php   
    }
	else{
		echo "U bent niet bevoegd deze pagina te zien. ";
	}
}
else{
	echo "Selecteer eerst het product dat u wilt aanpassen via onze <a href='productlist.php'>productlijst</a>.";
}
mysql_close($con);
include("footer.php"); ?>
