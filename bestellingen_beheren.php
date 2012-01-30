
<?php   include("header.php"); 
        include("connect.php");?>

   
       <script type="text/javascript"> 
            var aantal_cellen = 0 ; 
        function voeg_cel_toe( nummer, deletable, positie, foto, voornaam, achternaam, aantal, datum, productnaam, prijs ){
            var table = document.getElementById("ordertabel");
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

            td1.innerHTML = td1.innerHTML + "<a name=\"orderpos" + positie +"\"+></a><br /><b>" + voornaam + " " + achternaam + "<b> <br />" + datum ;
            td2.innerHTML = td2.innerHTML + "<hr />" + productnaam + "<br />" + aantal + "<br />" + prijs;
            if( deletable ){
                td1.innerHTML = td1.innerHTML + '<form action="delete.php" method="get"><input type="button" value="verwijder deze order" onclick="window.open(\'delete_order.php?nummer=' + nummer + '&positie=' + positie + '&product=<?php echo $order_nummer ?>\',\'_self\');"></form>' ;
            }

            aantal_cellen += 1 ;
        }
     </script>
    

    
    <table id="ordertabel" class="orderlijst" width="100%" border="0">

    </table>
    <script type="text/javascript">
        <?php
            $orderquery = mysql_query("SELECT * FROM account INNER JOIN orders ON account.account_number=orders.account_number INNER JOIN products ON orders.product_number=products.product_number ORDER BY orders.order_number");
            while( $order = mysql_fetch_array($orderquery) ) {               
    echo "voeg_cel_toe( \"" . $order['order_number'] . "\", \"" . $deletable. "\", \"" . $orderpositie . "\", \"" . $order['photo'] . "\", \"" . $order['first_name'] . "\", \"" . mysql_real_escape_string(htmlentities($order['last_name'])) . "\", \"" . mysql_real_escape_string(htmlentities($order['amount'])) . "\", \"" . mysql_real_escape_string(htmlentities($order['date_order'])) . "\", \"" . mysql_real_escape_string(htmlentities($order['product_name'])) . "\", \"" . $order['price'] . "\" );\n";
            }
        ?>
    </script>
 <?php include("footer.php"); ?>
