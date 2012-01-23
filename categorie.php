<?php
include("header.php");
include("connect.php");
mysql_query("INSERT INTO categories (category_name,parent_category,photo,description)
VALUES('$_POST[categorienaam]','$_POST[parent]','$_POST[foto]','$_POST[beschrijving]')");
echo"<p>Categorie toegevoegd.<a href='categorie toevoegen.php'>Nog een categorie toevoegen!</a></p>";
mysql_close($con);
include("footer.php");
?>
