<?php
include("header.php");
include("connect.php");
$accountnummer = mysql_real_escape_string(htmlentities($_SESSION["accountnummer"]));
;
$productnummer = mysql_real_escape_string(htmlentities($_POST["product_nummer"]));
$rating = mysql_real_escape_string(htmlentities($_POST["rating"]));
$reviewtext = mysql_real_escape_string(htmlentities($_POST["reviewtext"]));

$sql = "INSERT INTO reviews (product_number,account_number,rating,review_text)VALUES('$productnummer','$accountnummer','$rating','$reviewtext')";
$time = gettimeofday();
if (!isset($_SESSION['liketimer']) || $_SESSION['liketimer'] - $time['sec'] < 0) {
    if (!mysql_query($sql, $con)) {
        die('Connectiefout: ' . mysql_error());
        ?>
        <p>Review kon niet geplaatst worden, klik <a href='productpagina.php?product_number=<?php echo $productnummer ?>'>hier</a> om terug te gaan.</p>
        <?php
    } else {
        $_SESSION['liketimer']= $time['sec'] + 20 ;
        ?>
        
        <script type="text/javascript">
            window.open("productpagina.php?product_number=<?php echo $productnummer ?>#review",'_self','',true);
        </script>
    <?php
    }
    mysql_close($con);
} else {
    ?>
    <script type="text/javascript">
            window.open("productpagina.php?product_number=<?php echo $productnummer ?>#review",'_self','',true);
     </script>
     <?php
}
include("footer.php");
?>
