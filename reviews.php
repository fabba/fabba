<a name="topreview"></a>

<script type="text/javascript"> 
    var aantal_cellen = 0 ; 
    function voeg_cel_toe( nummer, deletable, positie, foto, voornaam, tussenvoegsel, achternaam, rating, datum, text ){
        var table = document.getElementById("reviewtabel");
        var tr ;
        var aantal_in_rij = 1 ;
        var rij = 1 + Math.floor( aantal_cellen / aantal_in_rij ) ;
        if( aantal_cellen % aantal_in_rij == 0  ){
            tr = document.createElement("tr");
            tr.setAttribute("valign", "top");
            tr.setAttribute("id", "rij" + rij );
            tr.setAttribute("style", "width:100%;");
            table.appendChild(tr);
        } else {
            tr = document.getElementById(  "rij" + rij ) ;
        }
            
        var td = document.createElement("td");
        td.setAttribute("style", "height:100%;width:10%;");
        var td1 = document.createElement("td");
        td1.setAttribute("style", "height:100%;width:20%;");
        var td2 = document.createElement("td");
        td2.setAttribute("style", "height:100%;width:70%;text-align:left;");
        var pict = document.createElement("img");
        pict.setAttribute("src", foto );
        pict.setAttribute("alt", "pic not found");
        pict.setAttribute("width", "200");
        pict.setAttribute("height", "200");
             
        td.appendChild(pict);
        tr.appendChild(td);
        tr.appendChild(td1);
        tr.appendChild(td2);
             
        td1.innerHTML = td1.innerHTML + "<a name=\"reviewpos" + positie +"\"+></a><br /><b>" + voornaam + " " + tussenvoegsel + " " + achternaam + "<b> <br />" + datum + "<br /> <h3 style='text-align:center;font-size:40px;'>" + rating + "</h2>" ;
        td2.innerHTML = td2.innerHTML + "<hr />" + text ;
        if( deletable ){
            td1.innerHTML = td1.innerHTML + '<form action="delete.php" method="get"><input type="button" value="verwijder deze review" onclick="window.open(\'delete_review.php?nummer=' + nummer + '&positie=' + positie + '&product=<?php echo $product_nummer ?>\',\'_self\');"></form>' ;
        }
        
        aantal_cellen += 1 ;
    }
</script>
<?php
$ratecount = mysql_query("SELECT COUNT(*) FROM reviews WHERE product_number=" . $product_nummer);
$counter = mysql_fetch_array($ratecount);
if ($counter['COUNT(*)'] >= 1){
$ratetotal = mysql_query("SELECT SUM(rating) FROM reviews WHERE product_number=$product_nummer");
$rateavg = mysql_fetch_array($ratetotal);
$rateaverage = $rateavg['SUM(rating)'] / $counter['COUNT(*)'];
echo $rateavg['SUM(rating)'];
echo $counter['COUNT(*)'];
}
else $rateaverage = "-";
?>

<h2 style="text-align:center;">Reviews</h2> 
<div class="cijfer" > Gemiddeld cijfer: <?php echo $rateaverage; ?> </div>
<table id="reviewtabel" class="reviewlijst" style="width:100%" border="0">

</table>

<script type="text/javascript">
<?php
$reviewquery = mysql_query("SELECT * FROM account INNER JOIN reviews ON account.account_number=reviews.account_number AND reviews.product_number=$product_nummer ORDER BY reviews.review_number");
$reviewpositie = 0;
while ($review = mysql_fetch_array($reviewquery)) {
    if ($ingelogd)
        $deletable = (($review['account_number'] == $accountnummer) || $rechten > 1 );
    else
        $deletable = false;
    echo "voeg_cel_toe( \"" . $review['review_number'] . "\", \"" . $deletable . "\", \"" . $reviewpositie . "\", \"" . $review['photo'] . "\", \"" . $review['first_name'] . "\", \"" . mysql_real_escape_string(htmlentities($review['extra_name'])) . "\", \"" . mysql_real_escape_string(htmlentities($review['last_name'])) . "\", \"" . mysql_real_escape_string(htmlentities($review['rating'])) . "\", \"" . mysql_real_escape_string(htmlentities($review['review_date'])) . "\", \"" . mysql_real_escape_string(htmlentities($review['review_text'])) . "\" );\n";
    $reviewpositie += 1;
}
?>
</script>
<a name="reviewpos<?php echo $reviewpositie ?>"></a>
<a name="review"></a>
<?php if ($ingelogd) { ?>
    <form name="input" method="post" action="add_review.php">
        <fieldset>
            <legend>Plaats review</legend>
            <textarea name="reviewtext" style="resize: none;" rows="10" cols="80"> Type hier je review en geef hiernaast een cijfer. </textarea>
            Cijfer:
            <select name="rating" valign="top">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6" selected="selected">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
            </select>
            <input type="hidden" name="product_nummer" value="<?php echo mysql_real_escape_string(htmlentities($product_nummer)); ?>"/>
            <input type="submit" value="review toevoegen" >
            </input>
        </fieldset>
    </form>
<?php } else { ?>
    <a href="login.php" class="donker">Log in</a> om ook een review achter te laten.
<?php
}
?>