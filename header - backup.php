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
        <link rel="shortcut icon" type="image/x-icon" href="/afbeeldingen/favicon.ico" />
		<link rel="stylesheet" type="text/css" href="fabba.css" />
		

	</head>
	<body>
<?php 
include("connect.php");
?>


<script type="text/javascript">
           
    var aantal_cells = 0 ; 
    function voeg_categorie_toe( categorienummer, categorienaam){
             
        var toptable = document.getElementById("toptabel");
        var toptr ;
        var aantal_per_rij = 3 ;
        var rij = 1 + Math.floor( aantal_cells / aantal_per_rij ) ;
        if( aantal_cells % aantal_per_rij == 0  ){
            toptr = document.createElement("tr");
            toptr.setAttribute("valign", "top");
            toptr.setAttribute("id", "toprij" + rij );
            toptable.appendChild(toptr);
        } else {
            toptr = document.getElementById(  "toprij" + rij ) ;
        }
            
        var toptd = document.createElement("td");
        toptd.setAttribute("style", "width:" + Math.ceil( 200 / aantal_per_rij ) + "%;text-align:center;");
                    
        toptr.appendChild(toptd);
                        
        var linkje = document.createElement("a");
        linkje.setAttribute("href", "productlist.php?category=" + categorienummer );
                        
             
        toptd.appendChild(linkje);
             
        linkje.innerHTML = linkje.innerHTML + "<font size=\"" + Math.ceil( 5 / aantal_per_rij ) + "\">" + categorienaam + "<//font>"  ;
            
        aantal_cells += 1 ;
    }
        
</script>	

        <div id="helepaginadiv">
                <table border="0"  width="100%">
                        <tr>
                                <td> 
									<div id="logo" >
                                        <a href="index.php"   >
                                                <img src="afbeeldingen/logoblokje.gif" alt="FABBA.nl"  />
                                        </a>
                                        </div>
                                </td>
                                <td>
                                        <div id="toplijst">
                                        <table id="toptabel" border="0"> 
                                        </table>
                                        <form name="zoekbalk" > 
                                                <input type="text" name="search" /> 
                                                <input type="button" value="zoek" onclick="window.open('productlist.php?search=' + document.forms['zoekbalk']['search'].value ,'_self');" />
                                        </form>
									
                                        </div>
                                </td>

                                <td> <!-- in css width="305" -->
                                <div id = "klantblok">
                                Welkom <?php if($ingelogd) {
                                                echo $voornaam . " " . $achternaam ;
                                            } else {
                                                echo "op FABBA.nl" ;
                                            }
                                        ?> 
                                <br />
                                <div id="klantlinks">
                                        <?php if($ingelogd)
                                                echo "<a href='account.php'>mijn account</a> | <a href='logout.php'>log out</a> | <a href='winkelwagentje.php'>winkelwagentje</a>" ;
                                             else
                                                echo "<a href='login.php'>log in</a> | <a href='registreren.php'>registreren</a>" ;
                                        ?>
                                        
                                </div>
                                </div>
                                </td>
                        </tr>
                </table> 
                </div>     
<script type="text/javascript">
<?php
    $categoryquery = mysql_query("SELECT * FROM categories WHERE parent_category= 0");
    while ($category = mysql_fetch_array($categoryquery)) {
    echo "voeg_categorie_toe( \"" . mysql_real_escape_string(htmlentities($category['category_number'])) . "\", \"" . mysql_real_escape_string(htmlentities($category['category_name'])) . "\" );";
}
mysql_close($con);
?>
       
</script>