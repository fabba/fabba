<?php
include("header.php");
include("connect.php");

$product_nummer = $_GET["product_number"];
$product_query = mysql_query("SELECT * FROM products WHERE product_number=$product_nummer");
$product = mysql_fetch_array($product_query);
$aanbieding_query = mysql_query("SELECT * FROM bargains WHERE product_number=$product_nummer");
$aanbiedingarr = mysql_fetch_array($aanbieding_query);
$aanbieding = false;
$merk_query = mysql_query("SELECT brand_name FROM brands WHERE brand_number=" . $product['brand_number']);
$merk = mysql_fetch_array($merk_query);
$categorie_query = mysql_query("SELECT category_name FROM categories WHERE category_number=" . $product['category']);
$cat = mysql_fetch_array($categorie_query);

// Deze functie bepaalt of een ingegeven datum op het moment van aanroepen nog moet komen.

function toekomst($datum) {
    $vandaagdatum = date("Y-m-d");
    $vandaag = strtotime($vandaagdatum);
    $anderedatum = strtotime($datum);
    return ($vandaag <= $anderedatum);
}

if ($aanbiedingarr) {
    $geldigtot = $aanbiedingarr['to_date'];
    if (toekomst($geldigtot)) {
        $aanbieding = true;
        $aanbiedingsprijs = $aanbiedingarr['temp_price'];
    }
    // Als de aanbieding niet meer geldig is, moet deze uit de aanbiedingdatabase worden verwijderd.
    else {
        mysql_query("DELETE from bargains where product_number=$product_nummer");
    }
}
$Prijst = mysql_real_escape_string(htmlentities($product['price']));
$prijs = floor($Prijst / 100);
$prijskomma = ($Prijst % 100);
if (strlen($prijskomma) != 2) {
    $prijskomma = "0" . $prijskomma;
}
?>

<br />
<br />
<br />
<table width="100%" border="0"  >

    <tr valign="top">
        <td style="background-color:transparent;width:20%;text-align:right;"  rowspan="3" >
            <a href="<?php echo mysql_real_escape_string(htmlentities($product['product_photo'])) ?>" ><img src="<?php echo mysql_real_escape_string(htmlentities($product['product_photo'])) ?>" width="60%" height="60%" /></a>
        </td>
        <td style="width:70%;text-align:top;" colspan="3" >

            <b class="producttitel" class="productinfo"><?php echo mysql_real_escape_string(htmlentities($product['product_name'])) ?></b><br />
            


        </td>
    </tr>
    <tr >
        <td style="width:20%;text-align:left;vertical-align:top;" class="merklinks" >
            <a class="donker" href="productlist.php?search=<?php echo mysql_real_escape_string(htmlentities($merk['brand_name'])) ?>" ><?php echo mysql_real_escape_string(htmlentities($merk['brand_name'])) ?></a>
            <br />
            <a class="donker" href="productlist.php?category=<?php echo mysql_real_escape_string(htmlentities($product['category'])) ?>" ><?php echo mysql_real_escape_string(htmlentities($cat['category_name'])) ?></a>


        </td>
        <td style="width:20%;text-align:right;vertical-align:top;">
            
                <?php
                if ($aanbieding) {
                    $nul = "";
                    if (strlen($aanbiedingsprijs % 100) < 2) {
                        $nul = "0" . $nul;
                    }
                    ?>
                    <strike id="oudeprijs">&#8364; <?php echo $prijs . ',' . $prijskomma ?></strike><br />
                    <span id="prijsblok">
                    &#8364; <?php echo floor($aanbiedingsprijs / 100) . "," . $nul . ($aanbiedingsprijs % 100); ?> <br /></span>
                    <b>Geldig tot</b>: <?php echo $geldigtot; ?> <br />
                    <?php } else { ?>
                    <span id="prijsblok">
                    &#8364; <?php echo $prijs . '.' . $prijskomma; }?>
                    </span>
            </td>
            <td style="width:10%;text-align:right;vertical-align:top;" rowspan="2">
                <font color="green" style="font-size:30px;">FABja: <?php echo mysql_real_escape_string(htmlentities($product['likes'])) ?></font> <br />
                <font color="red" style="font-size:30px;">FABnee: <?php echo mysql_real_escape_string(htmlentities($product['dislikes'])) ?></font>


                <?php if ($ingelogd) { ?>
                    <form action="like.php" method="get">
                        <input type="button" value="FABJA!!" onclick="window.open('like.php?nummer=<?php echo mysql_real_escape_string(htmlentities($product_nummer)) ?>','_self');">
                    </form>
                <?php } ?>   
                <?php if ($ingelogd) { ?>
                    <form action="like.php" method="get">
                        <input type="button" value="FABNEE..." onclick="window.open('dislike.php?nummer=<?php echo $product_nummer; ?>','_self');">
                    </form>
                <?php } ?>
                <br />
                <br />

                <?php if ($ingelogd && $rechten == 1) { ?>
                    <form action="Toevoegenwinkel.php" method="post">
                        Winkelwagen:
                        <input type="text" name="Aantal" maxlength="10" size="3" value="1">
                        <br />
                        <input type="hidden" name="nummer"  value="<?php echo $product_nummer; ?>">
                        <input type="submit" value="Toevoegen" onclick="window.open('Toevoegenwinkel.php?nummer=<?php echo $product_nummer; ?>','_self');"><br />
                    </form>

                <?php } ?>
                <?php if ($ingelogd && $rechten == 3) { ?>
                    <br /><br />
                    <form >
                        <input type="button" value="product aanpassen" onclick="window.open('product_aanpassen.php?product_number=<?php echo mysql_real_escape_string(htmlentities($product_nummer)) ?>','_self');">
                    </form>
                <?php } ?>
                <?php if (!$ingelogd) { ?>
                    <br /><a href="login.php" class="donker">Log in</a> om ook te kunnen stemmen.
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:justify;vertical-align:top;">
                <?php echo mysql_real_escape_string(htmlentities($product['description'])); ?> <br /> 
            </td>
        </tr>
    </table>
    <?php
    include("gerelateerd.php");
    include("reviews.php");
    mysql_close($con);
    include("footer.php");
    ?>
