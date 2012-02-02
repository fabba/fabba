<?php
include("header.php");
include("connect.php");

if($ingelogd&&$rechten==3){
	
	if (!empty($_GET)) {
		if(!empty($_GET['num'])) {
			mysql_query("DELETE FROM categories WHERE category_number= '" . mysql_real_escape_string(htmlentities($_GET['num'])) ."'");
		?>
				<script type="text/javascript">
				alert("categorie verwijderd");
				window.location="categorie_aanpassen.php"; 
				</script>
		<?php
		}
				
			$categor = mysql_query("SELECT * FROM categories WHERE category_number='" . mysql_real_escape_string(htmlentities($_GET['categor'])) ."'");
			$categorarray = mysql_fetch_array($categor) ;
			
		?>
		<script type="text/javascript">
		 function verander_fot(fotot){
                 var foto = document.getElementById("fotootje");
				foto.setAttribute("src", fotot );
				 var fotopad = document.getElementById("foto");
				fotopad.value = fotot ;
				
             }
             function verander_foto(){
                 var fotol = document.getElementById("fotootje");
				  var foto = document.getElementById("foto");
                 var fotopad =foto.value  ;
                 fotol.setAttribute("src",fotopad );
             }
			 </script>
		
			<table>
            <tr>
                <th colspan="2" style="background-color:transparent">
                    <h1>Categorie Aanpassen</h1>
                </th>
            </tr>
			<input name="nummer" style="display:none;" value="<?php echo $_GET['categor']; ?>" />    
            <tr valign="top">
                <td >
                    <?php echo'   <form action="categorie_aanpassen.php?categor='.$_GET['categor'].'&name=1" name="fot" method="post" enctype="multipart/form-data">'; ?>
				    <img id="fotootje" src="<?php echo mysql_real_escape_string(htmlentities($categorarray['photo']));?>" width="100px" height="100px"/>
					<label for="file">Filename:</label>
					<input type="file" name="file" id="file" /> 
					<br />
					<input type="submit" name="submit" value="Submit" />
				</form>
				<?php echo'<form name="toevoegen" method="post" action="categorie_aanpassen.php?categor='.$_GET['categor'].'">'; ?>
				</td>
                <td>
					<textarea name="foto" id="foto" rows="1" cols="40"  style="resize: none;" onchange="verander_foto();"><?php echo $categorarray['photo']; ?></textarea>
                </td>
               </tr>
			   <tr>
				<td><b>Categorienaam</b>:</td>
				<td>
					<textarea name="naam" style="resize: none;" rows="1" cols="40" ><?php echo $categorarray['category_name']; ?></textarea>
				</td>
				</tr>
				<tr>
					<td><b>Categoriebeschrijving</b>:</td>
					<td>
						<textarea name="beschrijving" style="resize: none;" rows="20" cols="70" ><?php echo $categorarray['description']; ?></textarea>
					</td>
				</tr>
				<tr>
				<td>
				 <b>Parent Categorie</b>:</td>
				 <td><select name="categorie" > 
				 <?php
					
					$category = mysql_query("SELECT * FROM categories ORDER BY category_name");
					while ( $catearray = mysql_fetch_array($category) )
					{ 
					$selected = "";
					if( $catearray["category_number"] == $categorarray["parent_category"]){
					$selected= "selected='selected'" ;}
					if( $categorarray["parent_category"] == "0"){
					$seleced= "selected='selected'" ;}
					echo'
						<option value=" '. $catearray['category_number'] . '"' . $selected . '>' . $catearray['category_name'] .'</option>';
					} 
					echo'
						<option value="0"' . $seleced . '>Hoofdcategorie</option>';
					?>
					</select> <br /><br />
                </td>
                <td style="width:30%;text-align:right;">
                    <input type="submit" value="Pas aan" />
                    <input type="button" value="VERWIJDER categorie" 
					onclick="window.open('categorie_aanpassen.php?num=<?php echo  $categorarray['category_number']?>','_self');" />
                </td>
            </tr>
			</table>
			</form>

			<?php
			if (!empty($_POST)) {
	if(isset($_GET["name"])){
		include("Fileupload.php");?>
		<script type="text/javascript">

			<?php
			rename('/datastore/webdb1243/htdocs/Uploads/' . $_FILES["file"]["name"], '/datastore/webdb1243/htdocs/Uploads/category'.$_GET['categor']);
			$hey = "Uploads/category".$_GET['categor'] ;
			echo"verander_fot(\"". $hey . "\");";
			?>
			</script>
			<?php
		}
		else{
		mysql_query("UPDATE categories SET 
		category_name='" . mysql_real_escape_string(htmlentities($_POST['naam'])) . "',
		parent_category='" . mysql_real_escape_string(htmlentities($_POST['categorie'])) . "',
		photo='" . mysql_real_escape_string(htmlentities($_POST['foto'])) . "',
		description='" . mysql_real_escape_string(htmlentities($_POST['beschrijving'])) . 
		"' WHERE category_number='" .$_GET['categor'] . "'");
		
?>
        <script type="text/javascript">
            alert("categorie aangepast");
			window.open('categorie_aanpassen.php','_self');
         </script>             
        
          <?php
	}}
	}
	else {
			?>
			<form name="toevoegen" method="get" action="categorie_aanpassen.php">
			<h1>Kies de categorie die u wilt aanpassen:</h1><br/><br/>
			<select type="text" name="categor" value=""/>
				<?php
					$category = mysql_query("SELECT * FROM categories ORDER BY category_name");
					while ( $catearray = mysql_fetch_array($category) ) { 
						echo'<option value="'. $catearray['category_number'] . '">' . $catearray['category_name'] .'</option>';
					} 
				?>
			</select>
			<input type="submit" value="Pas aan" />
			</form>                        
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
