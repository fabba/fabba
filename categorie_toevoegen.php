<?php
include("header.php");
include("connect.php");

if($ingelogd&&$rechten==3){
	

	

       ?>
         <script type="text/javascript">
		 function verander_fot(fotot){
                 var foto = document.getElementById("fotootje");
				foto.setAttribute("src", fotot );
				 var foto = document.getElementById("foto");
				foto.value = fotot ;
				
             }
             function verander_foto(){
                 var foto = document.getElementById("fotootje");
                 var fotopad =document.forms["toevoegen"]["foto"].value ;
                 foto.setAttribute("src", fotopad );
             }
         </script>              
        
        <table width="100%" border="0">
          
            <tr>
                <td/>
                <td colspan="2" style="background-color:transparent">
                    
                    
                        <h1>Categorie Toevoegen</h1>
                    
                </td>
            </tr>

            <tr valign="top">
                <td style="background-color:transparent;width:30%;height:60%;text-align:right;">
                    
                    
                  <form action="categorie_toevoegen.php?name=1" name="fot" method="post" enctype="multipart/form-data">
				<img id="fotootje" src="" width="100px" height="100px"/>
									
					<label for="file">Filename:</label>
					<input type="file" name="file" id="file" /> 
					<br />
					<input type="submit" name="submit" value="Submit" />
				</form>
				 <form name="toevoegen" method="post" action="categorie_toevoegen.php">
                    <textarea name="foto" id="foto" style="resize: none;" rows="1" cols="40" onchange="verander_foto();"></textarea>
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
		if (mysql_query("INSERT INTO categories (category_name,parent_category,photo,description)
            VALUES('" . mysql_real_escape_string(htmlentities($_POST['naam'])) . "','" . mysql_real_escape_string(htmlentities($_POST['categorie'])) . "','" . mysql_real_escape_string(htmlentities($_POST['foto'])) . "','" . mysql_real_escape_string(htmlentities($_POST['beschrijving'])) . "')")) {
			if( mysql_real_escape_string(htmlentities($_POST['categorie'])) == 'Uploads/'.$accountnummer ){
			$naming = mysql_query("SELECT category_number FROM categories ORDER BY category_number DESC");
			$namingg = mysql_fetch_row($naming);
			$nummerfoto = $namingg[0];
			rename('/datastore/webdb1243/htdocs/Uploads/'.$accountnummer  , '/datastore/webdb1243/htdocs/Uploads/category'. $nummerfoto);
			mysql_query("UPDATE categories SET photo = 'Uploads/category".$nummerfoto."' WHERE category_number='".$nummerfoto."'");
			}
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
		}}
		mysql_close($con);
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
