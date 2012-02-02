
<script type="text/javascript">
           
    var aantal_cellen = 0 ; 
    function voeg_cel_toe( productnummer, fotopad, naam, prijs ){
             
        var table = document.getElementById("producttabel");
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
<?php
$pagenumber = 0;
if (!empty($_GET['page']) && is_numeric($_GET['page']))
    $pagenumber = $_GET['page'];   
    




$volgorde = "DESC";
$vol = "D";
if (!empty($_GET['vol'])) {
    if ($_GET['vol'] == "A") {
        $volgorde = "ASC";
        $vol = "A";
    }
}
$aantal_op_pagina = 12;
$min = $pagenumber * $aantal_op_pagina;
$max = $aantal_op_pagina;


$sorteerop = "likes";
$sort = "l"; // word meegegeven via get
if (!empty($_GET['sort'])) {
    if ($_GET['sort'] == "n") {
        $sorteerop = "products.product_name";
        $sort = "n";
    } else if ($_GET['sort'] == "p") {
        $sorteerop = "bargains.temp_price";
        $sort = "p";
    } else if ($_GET['sort'] == "l") {
        $sorteerop = "products.likes";
        $sort = "l";
    } else if ($_GET['sort'] == "s") {
        $sorteerop = "products.sold";
        $sort = "s";
    }
}

    $volgendequery = mysql_query("SELECT COUNT(product_number) FROM bargains");
    $v_aantal = mysql_fetch_array($volgendequery);
    if($v_aantal['COUNT(product_number)'] > 0){
?>
<div id="ordenbalk">
    <b>Ordenen op</b>
        <a href="index.php?page=0&sort=n<?php if( $sorteerop == "products.product_name"){?>&vol=<?php if($volgorde == "ASC"){?>D<?php } else{?>A<?php }} ?>" class="ordenlink" >
            Naam</a><?php if( $sorteerop == "products.product_name"){if($volgorde == "DESC"){?>&uarr;<?php } else{?>&darr;<?php }} ?> |
        <a href="index.php?page=0&sort=p<?php if( $sorteerop == "bargains.temp_price"){?>&vol=<?php if($volgorde == "ASC"){?>D<?php } else{?>A<?php }} ?>" class="ordenlink" >
            Prijs</a><?php if( $sorteerop == "bargains.temp_price"){if($volgorde == "DESC"){?>&uarr;<?php } else{?>&darr;<?php }} ?> |
        <a href="index.php?page=0&sort=l<?php if( $sorteerop == "products.likes"){?>&vol=<?php if($volgorde == "ASC"){?>D<?php } else{?>A<?php }} ?>" class="ordenlink" >
            Likes</a><?php if( $sorteerop == "products.likes"){if($volgorde == "DESC"){?>&uarr;<?php } else{?>&darr;<?php }} ?> |
        <a href="index.php?page=0&sort=s<?php if( $sorteerop == "products.sold"){?>&vol=<?php if($volgorde == "ASC"){?>D<?php } else{?>A<?php }} ?>" class="ordenlink" >
            Bestverkocht</a><?php if( $sorteerop == "products.sold"){if($volgorde == "DESC"){?>&uarr;<?php } else{?>&darr;<?php }} ?></div>
<hr />

        <table id="producttabel" class="productlijst" width="100%" border="0">
        </table> <br />
    <?php

    $productquery = mysql_query("SELECT * FROM bargains INNER JOIN products ON products.product_number=bargains.product_number ORDER BY " . $sorteerop . " " . $volgorde . "  LIMIT " . $min . " ," . $max);

    if ($pagenumber >= 1) {
        ?>
        <div id="vorige"><a href="index.php?page=0&sort=<?php echo $sort ?>&vol=<?php echo $vol ; ?>" class="donker" >Eerste</a>   <a href="index.php?page=<?php echo $pagenumber - 1 ?>&sort=<?php echo $sort ?>&vol=<?php echo $vol ; ?>" class="donker" >Vorige</a> </div>
    <?php
    }

    if (ceil($v_aantal['COUNT(product_number)'] / $max) - 1 > $pagenumber) {
        ?>
        <div id="volgende" style="width:150px;float:right;"><a href="index.php?page=<?php echo $pagenumber + 1 ?>&sort=<?php echo $sort ?>&vol=<?php echo $vol ; ?>" class="donker" >Volgende</a> <a href="index.php?page=<?php echo ceil($v_aantal['COUNT(product_number)'] / $max) - 1 ?>&sort=<?php echo $sort ?>&vol=<?php echo $vol ; ?>" class="donker" >Laatste</a></div> <br />
    <?php } ?>
    <script type="text/javascript">
    <?php

    while ($product = mysql_fetch_array($productquery)) {
    $Prijst = mysql_real_escape_string(htmlentities($product['temp_price']));
    $prijs = floor($Prijst / 100); 
    $prijskomma =  ($Prijst % 100);
            if( strlen($prijskomma)!= 2)
            {
                    $prijskomma = "0".$prijskomma;
            }
        echo "voeg_cel_toe( \"" . mysql_real_escape_string(htmlentities($product['product_number'])) . "\", \"" . mysql_real_escape_string(htmlentities($product['product_photo'])) . "\", \"" . mysql_real_escape_string(htmlentities($product['product_name'])) . "\", \"" . $prijs . '.' . $prijskomma . "\" );";
   }
}
?>
       
</script>


