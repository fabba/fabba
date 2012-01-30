
<script type="text/javascript">
           
    var aantal_cellen = 0 ; 
    function voeg_cel_toe( productnummer, fotopad, naam, prijs ){
             
        var table = document.getElementById("relatetabel");
        var tr ;
        var aantal_in_rij = 6 ;
        var rij = 1 + Math.floor( aantal_cellen / aantal_in_rij ) ;
        if( aantal_cellen % aantal_in_rij == 0  ){
            tr = document.createElement("tr");
            tr.setAttribute("valign", "top");
            tr.setAttribute("id", "rij" + rij );
            table.appendChild(tr);
        } else {
            tr = document.getElementById(  "rij" + rij ) ;
        }
            
        var td = document.createElement("td");
        td.setAttribute("style", "width:" + Math.ceil( 100 / aantal_in_rij ) + "%;text-align:center;");
                    
        tr.appendChild(td);
                        
        var link = document.createElement("a");
        link.setAttribute("class", "donker");
        link.setAttribute("href", "productpagina.php?product_number=" + productnummer );
        link.setAttribute("class", "productinlijst" );
                        
        var plaat = document.createElement("img");
        plaat.setAttribute("src", fotopad );
        plaat.setAttribute("alt", "pic not found");
        plaat.setAttribute("width", "150");
        plaat.setAttribute("height", "150");
             
        td.appendChild(link);
             
        link.appendChild(plaat);
        link.innerHTML = link.innerHTML + "<br //> " + naam + " <br //> &#8364 " + prijs ;
            
        aantal_cellen += 1 ;
    }
        
</script>
<h2 style="text-align:center;" >Bekijkt u ook eens:</h2>
<table id="relatetabel" width="100%" border="0px">                                                                    
            </table>
<?php
    $andereproductenquery = mysql_query("SELECT COUNT(product_number) FROM products WHERE category = " . $product['category'] . " AND product_number <> $product_nummer" );
    $anderproduct = mysql_fetch_array($andereproductenquery);
    $aantal_producten = $anderproduct['COUNT(product_number)'];
    if($aantal_producten > 6){
        $randomplek = floor(rand(0, $aantal_producten -5));
    } else {
        $randomplek = 0 ;
    }
    $relate_query = mysql_query("SELECT * FROM products WHERE category = " . $product['category'] . " AND product_number <> $product_nummer LIMIT $randomplek, 5 ");
    ?>
<script type="text/javascript">
<?php
$aantal_suggesties = 0;
while ($relate = mysql_fetch_array($relate_query)) {
$r_Prijst = mysql_real_escape_string(htmlentities($relate['price']));
$r_prijs = floor($r_Prijst / 100); 
$r_prijskomma =  ($r_Prijst % 100);
	if( strlen($r_prijskomma)!= 2)
	{
		$prijskomma = "0".$prijskomma;
	}
    echo "voeg_cel_toe( \"" . mysql_real_escape_string(htmlentities($relate['product_number'])) . "\", \"" . mysql_real_escape_string(htmlentities($relate['product_photo'])) . "\", \"" . mysql_real_escape_string(htmlentities($relate['product_name'])) . "\", \"" . $r_prijs . '.' . $r_prijskomma . "\" );";
    $aantal_suggesties += 1;
}
if($aantal_suggesties < 5){
     $andereproductenquery = mysql_query("SELECT COUNT(product_number) FROM products WHERE product_number <> $product_nummer" );
    $anderproduct = mysql_fetch_array($andereproductenquery);
    $aantal_producten = $anderproduct['COUNT(product_number)'];
    $randomplek = floor(rand(0, $aantal_producten ));
    
   $relate_query = mysql_query("SELECT * FROM products WHERE product_number <> $product_nummer LIMIT $randomplek, 1 ");
    while (($relate = mysql_fetch_array($relate_query)) && $aantal_suggesties < 6) {
      $r_Prijst = mysql_real_escape_string(htmlentities($relate['price']));
        $r_prijs = floor($r_Prijst / 100); 
        $r_prijskomma =  ($r_Prijst % 100);
            if( strlen($r_prijskomma)!= 2)
            {
                    $prijskomma = "0".$prijskomma;
            }
        echo "voeg_cel_toe( \"" . mysql_real_escape_string(htmlentities($relate['product_number'])) . "\", \"" . mysql_real_escape_string(htmlentities($relate['product_photo'])) . "\", \"" . mysql_real_escape_string(htmlentities($relate['product_name'])) . "\", \"" . $r_prijs . '.' . $r_prijskomma . "\" );";
        $aantal_suggesties += 1;  
        $randomplek = floor(rand(0, $aantal_producten ));
        $relate_query = mysql_query("SELECT * FROM products WHERE product_number <> $product_nummer LIMIT $randomplek, 1 ");
    
    }
}
?>
       
</script>
