<?php include("header.php"); 

if($rechten==2){

	if(!empty($_POST)){
		include("connect.php");
		mysql_query("INSERT INTO categories (category_name,parent_category,photo,description)
		VALUES('$_POST[categorienaam]','$_POST[parent]','$_POST[foto]','$_POST[beschrijving]')");
		echo"<p>Categorie toegevoegd. <br /><a href='categorie toevoegen.php'>Nog een categorie toevoegen?</a></p>";
		mysql_close($con);
	}
	else {
?>
	<div id="midden">
	<form action="categorie toevoegen.php" method="post">
		<table>
			<th colspan='2'><h1>Categorie toevoegen</h1></th>
			<tr><td>Categorienaam:</td> <td><input type="text" name="categorienaam" /></td></tr>
			<tr><td>Parentcategorie:</td> <td><input type="text" name="parent" /></td></tr>
			<tr><td>Foto:</td> <td><input type="text" name="foto" /></td></tr>
			<tr><td>Beschrijving:</td><td><textarea name="beschrijving" rows="6" cols="40">Vul hier uw categoriebeschrijving in...</textarea></td></tr> 
			<tr><td></td>	<td><input type="submit" value="voeg toe" />  <a href="account.php" class="donker">Terug naar account pagina</a></td></tr>
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
include("footer.php"); ?>
