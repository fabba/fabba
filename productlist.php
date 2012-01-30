
<?php
include("header.php");
include("connect.php");
?>

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
$zoek = "";
if (isset($_GET['search']))
    $zoek = mysql_real_escape_string(htmlentities($_GET['search']));

$pagenumber = 0;
if (!empty($_GET['page']) && is_numeric($_GET['page']))
    $pagenumber = $_GET['page'];

$categorie = "";
if (isset($_GET['category']) && is_numeric($_GET['category'])) {
    $categorie = $_GET['category'];
    if( $pagenumber == 0 ){
        $catquery = mysql_query("SELECT * FROM categories WHERE category_number= " . $categorie);
        $cat = mysql_fetch_array($catquery);
        ?>

        <table width="100%" border="0">
            <tr>
                <td style="width:30%;height:130px;text-align:right;">
                    <img src="<?php echo mysql_real_escape_string(htmlentities($cat['photo'])) ?>" height="100%" />
                </td>
                <td style="height:130px;width:70%;text-align:left;">
                    <h1><?php echo mysql_real_escape_string(htmlentities($cat['category_name'])) ;?></h1>
                    <h3><?php echo mysql_real_escape_string(htmlentities($cat['description'])) ;?></h3>
                </td>
            </tr>
        </table>
        <?php

        $subaantal = mysql_query("SELECT COUNT(*) FROM categories WHERE parent_category=" . $categorie);
        $aantal = mysql_fetch_array($subaantal);
        if ($aantal['COUNT(*)'] >= 1) {
            include("categorylist.php");
        }
    }
}



$volgorde = "DESC";
$vol = "D";
if (!empty($_GET['vol'])) {
    if ($_GET['vol'] == "A") {
        $volgorde = "ASC";
        $vol = "A";
    }
}
$aantal_op_pagina = 24;
$min = $pagenumber * $aantal_op_pagina + 0;
$max = $aantal_op_pagina;


$sorteerop = "likes";
$sort = "l"; // word meegegeven via get
if (!empty($_GET['sort'])) {
    if ($_GET['sort'] == "n") {
        $sorteerop = "product_name";
        $sort = "n";
    } else if ($_GET['sort'] == "p") {
        $sorteerop = "price";
        $sort = "p";
    } else if ($_GET['sort'] == "l") {
        $sorteerop = "likes";
        $sort = "l";
    } else if ($_GET['sort'] == "s") {
        $sorteerop = "sold";
        $sort = "s";
    }
}
$categorieselect = "";
if ($categorie != "") {
    $categorieselect = " AND category = $categorie";
}

    $volgendequery = mysql_query("SELECT COUNT(product_number) FROM (products INNER JOIN categories ON products.category=categories.category_number) INNER JOIN brands ON products.brand_number=brands.brand_number WHERE ( products.product_name LIKE '%" . $zoek . "%' OR products.description LIKE '%" . $zoek . "%' OR categories.category_name LIKE '%" . $zoek . "%' OR brands.brand_name LIKE '%" . $zoek . "%') " . $categorieselect );
    $v_aantal = mysql_fetch_array($volgendequery);
    if($v_aantal['COUNT(product_number)'] > 0){
?>
<div id="ordenbalk">
    <b>Ordenen op</b>
        <a href="productlist.php?page=0&search=<?php echo $zoek ?>&sort=n&category=<?php echo $categorie ?><?php if( $sorteerop == "product_name"){?>&vol=<?php if($volgorde == "ASC"){?>D<?php } else{?>A<?php }} ?>" class="ordenlink" >
            Naam</a><?php if( $sorteerop == "product_name"){if($volgorde == "DESC"){?>&uarr;<?php } else{?>&darr;<?php }} ?> |
        <a href="productlist.php?page=0&search=<?php echo $zoek ?>&sort=p&category=<?php echo $categorie ?><?php if( $sorteerop == "price"){?>&vol=<?php if($volgorde == "ASC"){?>D<?php } else{?>A<?php }} ?>" class="ordenlink" >
            Prijs</a><?php if( $sorteerop == "price"){if($volgorde == "DESC"){?>&uarr;<?php } else{?>&darr;<?php }} ?> |
        <a href="productlist.php?page=0&search=<?php echo $zoek ?>&sort=l&category=<?php echo $categorie ?><?php if( $sorteerop == "likes"){?>&vol=<?php if($volgorde == "ASC"){?>D<?php } else{?>A<?php }} ?>" class="ordenlink" >
            Likes</a><?php if( $sorteerop == "likes"){if($volgorde == "DESC"){?>&uarr;<?php } else{?>&darr;<?php }} ?> |
        <a href="productlist.php?page=0&search=<?php echo $zoek ?>&sort=s&category=<?php echo $categorie ?><?php if( $sorteerop == "sold"){?>&vol=<?php if($volgorde == "ASC"){?>D<?php } else{?>A<?php }} ?>" class="ordenlink" >
            Bestverkocht</a><?php if( $sorteerop == "sold"){if($volgorde == "DESC"){?>&uarr;<?php } else{?>&darr;<?php }} ?></div>
<hr />

        <table id="producttabel" class="productlijst" width="100%" border="0">
        </table> <br />
    <?php

    $productquery = mysql_query("SELECT * FROM (products INNER JOIN categories ON products.category=categories.category_number) INNER JOIN brands ON products.brand_number=brands.brand_number WHERE ( products.product_name LIKE '%" . $zoek . "%' OR products.description LIKE '%" . $zoek . "%' OR categories.category_name LIKE '%" . $zoek . "%' OR brands.brand_name LIKE '%" . $zoek . "%' ) " . $categorieselect . " ORDER BY products." . $sorteerop . " " . $volgorde . "  LIMIT " . $min . " ," . $max);

    if ($pagenumber >= 1) {
        ?>
        <div id="vorige"><a href="productlist.php?page=0&search=<?php echo $zoek ?>&sort=<?php echo $sort ?>&vol=<?php echo $vol ; ?>&category=<?php echo $categorie ?>" class="donker" >Eerste</a>   <a href="productlist.php?page=<?php echo $pagenumber - 1 ?>&search=<?php echo $zoek ?>&sort=<?php echo $sort ?>&vol=<?php echo $vol ; ?>&category=<?php echo $categorie ?>" class="donker" >Vorige</a> </div>
    <?php
    }

    if (ceil($v_aantal['COUNT(product_number)'] / 24) - 1 > $pagenumber) {
        ?>
        <div id="volgende" style="width:150px;float:right;"><a href="productlist.php?page=<?php echo $pagenumber + 1 ?>&search=<?php echo $zoek ?>&sort=<?php echo $sort ?>&vol=<?php echo $vol ; ?>&category=<?php echo $categorie ?>" class="donker" >Volgende</a> <a href="productlist.php?page=<?php echo ceil($v_aantal['COUNT(product_number)'] / 24) - 1 ?>&search=<?php echo $zoek ?>&sort=<?php echo $sort ?>&vol=<?php echo $vol ; ?>&category=<?php echo $categorie ?>" class="donker" >Laatste</a></div> <br />
    <?php } ?>
    <script type="text/javascript">
    <?php

    while ($product = mysql_fetch_array($productquery)) {
    $Prijst = mysql_real_escape_string(htmlentities($product['price']));
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


<?php include("footer.php"); ?>
