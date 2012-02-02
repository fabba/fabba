<?php
include("header.php");
include("connect.php");
?>
   <script type="text/javascript">
		 function verander_fot(fotot){
                 var foto = document.getElementById("fotootje");
				foto.setAttribute("src", fotot );
				 var foto = document.getElementById("foto");
				foto.value = fotot ;
				
             }
             function verander_foto(){
                 var fotol = document.getElementById("fotootje");
				  var foto = document.getElementById("foto");
                 var fotopad =foto.value  ;
                 fotol.setAttribute("src",fotopad );
             }
         </script>            
<?php
// Product toevoegen pagina
// Op deze pagina kan de beheerder gemakkelijk een product toevoegen. 
// Deze pagina is alleen beschikbaar voor gebruikers met beheerdersrechten. 

if($rechten==3){
	
	
	?>
      
		
        
        <table width="100%">
            <tr>
                <td colspan="2" style="background-color:transparent">
                    <h1>Product Toevoegen</h1>
                </td>
            </tr>
			<tr valign="top">
                <td style="background-color:transparent;width:30%;height:60%;text-align:right;">
				<form action="product_toevoegen.php?name=1" name="fot" method="post" enctype="multipart/form-data">
				<img id="fotootje" src="" width="100px" height="100px"/>
									
					<label for="file">Filename:</label>
					<input type="file" name="file" id="file" /> 
					<br />
					<input type="submit" name="submit" value="Submit" />
				</form>
				<form name="toevoegen" method="post" action="product_toevoegen.php">
				
                    <textarea name="foto" id="foto" style="resize: none;" rows="1" cols="40" onchange="verander_foto()">Uploads/( Uw file name ) of uw url</textarea>
					
					

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

if (!empty($_POST)) {
		if(!empty($_GET)) {
		include("Fileupload.php");?>
		<script type="text/javascript">

			<?php
		
			
			rename('/datastore/webdb1243/htdocs/Uploads/' . $_FILES["file"]["name"], '/datastore/webdb1243/htdocs/Uploads/'.$accountnummer);
			$hey = "Uploads/".$accountnummer ;
			echo"verander_fot(\"". $hey . "\");";
			?>
			</script>
			<?php
		}
		else{
		if (mysql_query("INSERT INTO products (product_name,category,price,stock,product_photo,description,brand_number)
            VALUES('" . mysql_real_escape_string(htmlentities($_POST['naam'])) . "','" . 
			mysql_real_escape_string(htmlentities($_POST['categorie'])) . "','" . 
			mysql_real_escape_string(htmlentities($_POST['prijs'])) . "" . 
			mysql_real_escape_string(htmlentities($_POST['prijskomma'])) . "','" . 
			mysql_real_escape_string(htmlentities($_POST['voorraad'])) . "','" .
			mysql_real_escape_string(htmlentities($_POST['foto'])) . "','" . 			
			mysql_real_escape_string(htmlentities($_POST['beschrijving'])) . "','" . 
			mysql_real_escape_string(htmlentities($_POST['merk'])) . "')")) {
			if($_POST['foto']=='Uploads/'.$accountnummer){
			$naming = mysql_query("SELECT product_number FROM products ORDER BY product_number DESC");
			$namingg = mysql_fetch_row($naming);
			$nummerfoto = $namingg[0];
			rename('/datastore/webdb1243/htdocs/Uploads/'.$accountnummer  , '/datastore/webdb1243/htdocs/Uploads/product'. $nummerfoto);
			mysql_query("UPDATE products SET product_photo = 'Uploads/product".$nummerfoto."' WHERE product_number='".$nummerfoto."'");
			}
			?>
        <script type="text/javascript">
            alert("Product toegevoegd");
            
        </script>
        <?php
		}
		else{
			echo "Fout in de mysql-query";
		}}
		
	} 
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
