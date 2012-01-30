<?php
include("header.php");
include("connect.php");

if($rechten==2){
	if (!empty($_POST)) {
		
		if (mysql_query("INSERT INTO categories (category_name,parent_category,photo,description)
            VALUES('" . mysql_real_escape_string(htmlentities($_POST['naam'])) . "','" . mysql_real_escape_string(htmlentities($_POST['categorie'])) . "','" . mysql_real_escape_string(htmlentities($_POST['foto'])) . "','" . mysql_real_escape_string(htmlentities($_POST['beschrijving'])) . "')")) {
?>
        <script type="text/javascript">
            alert("categorie toegevoegd");
            
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

	

       ?>
         <script type="text/javascript">
             function verander_foto(){
                 var foto = document.getElementById("product_foto");
                 var fotopad =document.forms["toevoegen"]["foto"].value ;
                 foto.setAttribute("src", fotopad );
             }
         </script>              
         <form name="toevoegen" method="post" action="categorie_toevoegen.php">
        <table width="100%" border="0">
          
            <tr>
                <td/>
                <td colspan="2" style="background-color:transparent">
                    
                    
                        <h1>Categorie Toevoegen</h1>
                    
                </td>
            </tr>

            <tr valign="top">
                <td style="background-color:transparent;width:30%;height:60%;text-align:right;">
                    
                    
                    <img id="product_foto" src="" width="60%" height="60%" alt="geen foto gevonden" />
                    <textarea name="foto" style="resize: none;" rows="1" cols="40" onblur="verander_foto();">foto url</textarea>
                </td>
                <td style="height:300px;width:40%;text-align:top;">

                    <b>Categorienaam</b>:<textarea name="naam" style="resize: none;" rows="1" cols="40"></textarea> <br />
                    <b>Categoriebeschrijving</b>:<textarea name="beschrijving" style="resize: none;" rows="20" cols="70"></textarea><br />                   
                    <b>Parent Categorie</b>:<select type="text" name="categorie" value=""/>
                                         <option value="0">geen</option>
					<?php
					$category = mysql_query("SELECT * FROM categories");
					while ( $catearray = mysql_fetch_array($category) )
					{ 
					echo'
						<option value=" '. $catearray['category_number'] . '">' . $catearray['category_name'] .'</option>
					';
					} 
					?></select><br />					<br />
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
include("footer.php");
?>
