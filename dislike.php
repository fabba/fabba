<?php
$doorschrijven = true;
include("header.php");
include("connect.php");
$accountnummer = $_SESSION["accountnummer"];
$productnummer = $_GET["nummer"];
$dislikes = mysql_fetch_array(mysql_query("SELECT dislikes FROM products WHERE product_number=$productnummer"));
$newdislikes = ($dislikes['dislikes'] + 1);
$time = gettimeofday();
if (!isset($_SESSION['liketimer']) || $_SESSION['liketimer'] - $time['sec'] < 0) {
    $sql = "UPDATE products SET dislikes=$newdislikes WHERE product_number=$productnummer";
    $_SESSION['liketimer'] = $time['sec'] + 20;
    if (!mysql_query($sql, $con)) {
        die('Connectiefout: ' . mysql_error());
        ?>
        <p>Like kon niet geplaatst worden, klik <a href='productpagina.php?product_number=<?php echo $productnummer ?>'>hier</a> om terug te gaan.</p>
        <?php
    } else {
        ?>
        <script type="text/javascript">
            window.open("productpagina.php?product_number=<?php echo $productnummer ?>",'_self','',true);
        </script>
        <?php
    }
} else {
    ?>
    <script type="text/javascript">
        window.open("productpagina.php?product_number=<?php echo $productnummer ?>",'_self','',true);
    </script>
    <?php
}


mysql_close($con);
include("footer.php");
?>
