<?php
// Connectpagina
// Hier wordt verbinding gemaakt met de database, waarbij de inloggegevens in een extern bestand staan (mysql_config.xml),
// die in de map dient te worden geplaatst waar ook de public_html map staat.

  $mysqlconfig = simplexml_load_file("mysql_config.xml");
  if ($mysqlconfig === FALSE) {
    die("Connectiefout met het XML bestand");
  }
  else {
    $con = mysql_connect($mysqlconfig->mysql_host, $mysqlconfig->mysql_username, $mysqlconfig->mysql_password) 
		or die('Connectiefout: '.mysql_error());
    mysql_select_db($mysqlconfig->mysql_database);
  }

?>
