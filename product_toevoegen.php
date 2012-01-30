<?php
include("header.php");
include("connect.php");

// Product toevoegen pagina
// Op deze pagina kan de beheerder gemakkelijk een product toevoegen. 
// Deze pagina is alleen beschikbaar voor gebruikers met beheerdersrechten. 

if($rechten==2){
	if (!empty($_POST)) {
		if (mysql_query("INSERT INTO products (product_name,category,price,stock,product_photo,description,brand_number)
            VALUES('" . mysql_real_escape_string(htmlentities($_POST['naam'])) . "','" . 
			mysql_real_escape_string(htmlentities($_POST['categorie'])) . "','" . 
			mysql_real_escape_string(htmlentities($_POST['prijs'])) . "" . 
			mysql_real_escape_string(htmlentities($_POST['prijskomma'])) . "','" . 
			mysql_real_escape_string(htmlentities($_POST['voorraad'])) . "','" . 
			mysql_real_escape_string(htmlentities($_POST['foto'])) . "','" . 
			mysql_real_escape_string(htmlentities($_POST['beschrijving'])) . "','" . 
			mysql_real_escape_string(htmlentities($_POST['merk'])) . "')")) {
?>
        <script type="text/javascript">
            alert("Product toegevoegd");
            
        </script>
        <?php
		}
		else{
			echo "Fout in de mysql-query";
		}
		
	} ?>
         <script type="text/javascript">
             function verander_foto(){
                 var foto = document.getElementById("product_foto");
                 var fotopad =document.forms["toevoegen"]["foto"].value ;
                 foto.setAttribute("src", fotopad );
             }
         </script>            
		
        <form name="toevoegen" method="post" action="product_toevoegen.php">
        <table width="100%">
            <tr>
                <td colspan="2" style="background-color:transparent">
                    <h1>Product Toevoegen</h1>
                </td>
            </tr>
			<tr valign="top">
                <td style="background-color:transparent;width:30%;height:60%;text-align:right;">
                    <img id="product_foto" src="" width="60%" height="60%" alt="geen foto gevonden" />
                    <textarea name="foto" style="resize: none;" rows="1" cols="40" onblur="verander_foto();">foto url</textarea>
                </td>
                <td style="height:300px;width:40%;text-align:top;">
                    <b>Productnaam</b>:<textarea name="naam" style="resize: none;" rows="1" cols="40"></textarea> <br />
                    <b>Prijs</b>: &#8364 <input type="text" name="prijs" value=""/>,<input type="text" name="prijskomma" maxlength="2" size="2" value=""/> <br />
                    <b>Productbeschrijving</b>:<textarea name="beschrijving" style="resize: none;" rows="20" cols="70"></textarea><br />
                    <b>Voorraad</b>:<input type="text" name="voorraad" value=""/> <br />
                    <b>Categorie</b>:<select type="text" name="categorie" > 
<?php
$category = mysql_query("SELECT * FROM categories");
while ( $catearray = mysql_fetch_array($category) ){
echo '<option value=" '. $catearray['category_number'] . '">' . $catearray['category_name'] .'</option><br />';
} ?> 				
					</select><br />
					<b>Merk</b>:<select type="text" name="merk" /> 
<?php
$brand = mysql_query("SELECT * FROM brands");
while ($brandarray = mysql_fetch_array($brand)){ 
echo '<option value=" '. $brandarray['brand_number'] . '" >' . $brandarray['brand_name'] .'</option><br />';
} ?>
					<br />
                    
                </td>
                <td style="width:30%;text-align:right;">
                    <input type="submit" value="voeg toe" />
                </td>
            </tr>

        </table>
        </form>
                        
<?php
}
else{
?>
<div id="midden">
	U bent niet bevoegd deze pagina te bekijken. <a href="index.html">Terug naar FABBA.nl</a>
</div>
<?php
}
mysql_close($con);
include("footer.php");
?>
