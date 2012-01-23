<?php
include("header.php");
include("connect.php");
$reviewnummer = $_GET["nummer"];
$productnummer = $_GET["product"];
$positie = $_GET["positie"];
if ($positie - 1 >= 0)
    $positie -= 1;
$sql = "DELETE FROM reviews WHERE review_number=$reviewnummer";
$vindreview = mysql_query("SELECT account_number FROM reviews WHERE review_number=$reviewnummer");
if (!$review = mysql_fetch_array($vindreview)) {
    die('Connectiefout: ' . mysql_error());
    ?>
    <p>Database niet gevonden, klik <a href='productpagina.php?product_number=<?php echo $productnummer ?>'>hier</a> om terug te gaan.</p>
    <?php
} else {
    if ($accountnummer == $review['account_number'] || $rechten > 1) {
        if (!mysql_query($sql, $con)) {
            die('Connectiefout: ' . mysql_error());
            ?>
            <p>Review kon niet verwijdert worden, klik <a href='productpagina.php?product_number=<?php echo $productnummer ?>'>hier</a> om terug te gaan.</p>
            <?php
        } else {
            ?>
            <script type="text/javascript">
                window.open("productpagina.php?product_number=<?php echo $productnummer ?>#reviewpos<?php echo $positie ?>",'_self','',true);
            </script>
            <?php
        }
    } else {
        ?>
        <script type="text/javascript">
            alert("Dit is niet jouw review vriend");
            window.open("productpagina.php?product_number=<?php echo $productnummer ?>#reviewpos<?php echo $positie ?>",'_self','',true);
        </script>
        <?php
    }
    mysql_close($con);
}
include("footer.php");
?>
