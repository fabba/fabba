<?php
include("header.php");
include("connect.php");
if(isset($accountnummer)){
mysql_query("DELETE from temp_order where account_number='$accountnummer'");

echo "Uw winkel wagen is leeggemaakt.";
echo "<a href='productlist.php'>Verder winkelen</a>";
}
else{
	echo "Deze pagina is alleen beschikbaar als u <a href='login.php'>inlogt</a>.";
}
mysql_close($con);
include("footer.php");
?>