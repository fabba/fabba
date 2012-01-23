<?php include("header.php"); ?>

<?php
$product_nummer = $_GET["product_number"];
include("connect.php");
$product_query = mysql_query("SELECT * FROM products WHERE product_number=$product_nummer");
$product = mysql_fetch_array($product_query);

if($rechten>1){ 
    if(!empty($_POST)){ ?>

        
    <?php } ?>
        <form method="post" action="product_aanpassen.php">
        <table width="100%" border="0">
            <form method="post" action="product_change.php">
            <tr>
                <td/>
                <td colspan="2" style="background-color:transparent">
                    <h1>Product Aanpassen</h1>
                </td>
            </tr>

            <tr valign="top">
                <td style="background-color:transparent;width:30%;height:60%;text-align:right;">
                    <img src="<?php echo $product['product_photo'] ?>" width="60%" height="60%" / >
                    <textarea name="product_foto" style="resize: none;" rows="1" cols="40"><?php echo $product['product_photo'] ?></textarea>
                </td>
                <td style="height:300px;width:40%;text-align:top;">

                    <b>Productnaam</b>:<textarea name="product_naam" style="resize: none;" rows="1" cols="40"><?php echo $product['product_name'] ?></textarea> <br />
                    <b>Prijs</b>: &#8364<input type="text" name="product_prijs" value="<?php echo $product['price'] ?>"/> <br />
                    <b>Productbeschrijving</b>:<textarea name="product_beschrijving" style="resize: none;" rows="20" cols="70"><?php echo $product['description'] ?></textarea><br />
                    <b>Voorraad</b>:<input type="text" name="product_voorraad" value="<?php echo $product['stock'] ?>"/> <br />
                    <b>Merk</b>:<input type="text" name="product_merk" value="<?php echo $product['brand_number'] ?>"/> <br />
                    <b>Categorie</b>:<input type="text" name="product_categorie" value="<?php echo $product['category'] ?>"/> <br />
                </td>
                <td style="width:30%;text-align:right;">
                    <input type="submit" value="Verzenden"/><br />
                    <font color="green">goed: <input type="text" name="product_likes" value="<?php echo$product['likes'] ?>"/></font> <br />

                    <font color="red">fuck: <input type="text" name="product_dislikes" value="<?php echo$product['dislikes'] ?>"/></font>
                                <br />
                                <br />

                    

                </td>
            </tr>

        </table>
        </form>
<?php   
    }

mysql_close($con);
include("footer.php"); ?>
