<?php

session_start();
if(isset($_SESSION['accountnummer'])){
        $ingelogd = true ;
	$voornaam = $_SESSION['voornaam'];
	$achternaam = $_SESSION['achternaam'];
        $accountnummer = $_SESSION['accountnummer'] ;
        $rechten = $_SESSION['rechten'] ;
} else {
    $ingelogd = false ;
}
if( !isset($doorschrijven) || !$doorschrijven )
    session_write_close();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	
		<title>FABBA.nl</title>
              <link rel="shortcut icon" type="image/x-icon" href="/afbeeldingen/favicon.ico">
		<link rel="stylesheet" type="text/css" href="fabba.css" />
		

	</head>
	<body>

        <div id="helepaginadiv">
                <table border="0"  width="100%" align="center">
                        <tr>
                                <td width="270px">
                                        <div id="logo" >
                                        <a href="index.php"   >
                                                <img src="afbeeldingen/logoblokje.gif" alt="FABBA.nl"  />
                                        </a>
                                        </div>
                                </td>
                                <td>
                                        <div id="toplijst">
                                        <table id="toptabel" border="0"> 
                                        <tr>
                                                <td><a href="productlist.php"   >Pink Floyd</a></td>
                                                <td><a href="productlist.php"   >Pink Floyd cd's</a></td>
                                                <td><a href="productlist.php"   >Pink Floyd cd's</a></td>
                                        </tr>
                                        <tr>
                                                <td><a href="productlist.php"   >Pink Floyd cd's</a></td>
                                                <td><a href="productlist.php"   >Pink Floyd cd's</a></td>
                                                <td><a href="productlist.php"   >Pink Floyd cd's</a></td>
                                        </tr>
                                        <tr>
                                                <td><a href="productlist.php"   >zwart ding met prisma</a></td>
                                                <td><a href="productlist.php"   >Pink Floyd cd's</a></td>
                                                <td><a href="productlist.php"   >Pink Floyd cd's</a></td>
                                        </tr>
                                        </table> 
                                        <form name="input" method="LINK" action="productlist.php">
                                                <input type="text" name="user" />
                                                <input type="submit" value="zoek" />
                                        </form> 
                                        </div>
                                </td>

                                <td width="305">
                                <div id = "klantblok">
                                Welkom <?php if($ingelogd)
                                                echo $voornaam . " " . $achternaam;
                                             else
                                                echo "op FABBA.nl" ;
                                        ?> 
                                <br />
                                <div id="klantlinks">
                                        <?php if($ingelogd)
                                                echo "<a href=\"account.php\"  >mijn account</a> | <a href=\"logout.php\" \">log out</a> | <a href=\"winkelwagentje.php\" \">winkelwagentje</a>" ;
                                             else
                                                echo "<a href=\"login.php\" \">log in</a> | <a href=\"registreren.php\" \">registreren</a>" ;
                                        ?>
                                        
                                </div>
                                </div>
                                </td>
                        </tr>
                </table> 
                </div>     