<?php include("header.php"); ?>

<?php
$product_nummer = $_GET["nummer"];
include("connect.php");


if($rechten>1){ 
    if(mysql_query("DELETE FROM products WHERE  product_number =" . $product_nummer ) ){
    ?>
        <script type="text/javascript">
            alert("Product <?php echo $product_nummer?> is verwijdert.");
        </script>
    <?php
    } else {
        ?>
        <script type="text/javascript">
            alert("Product <?php echo $product_nummer?> kon niet worden verwijdert.");
            window.open('product_aanpassen.php?nummer=<?php echo $product_nummer ?>','_self');
        </script>
     <?php
    }
} 
?>
        <script type="text/javascript">
            window.open('index.php','_self');
         </script>   
<?php
mysql_close($con);
include("footer.php"); ?>
