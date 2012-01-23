<?php
$con = mysql_connect("localhost","webdb1243","wref6uba");
if (!$con){
  die('Connectiefout: ' . mysql_error());
}
else{
	mysql_select_db("webdb1243", $con);
}
?>
