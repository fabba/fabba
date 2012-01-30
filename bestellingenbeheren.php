<?php
include("header.php");
include("connect.php");
if($rechten>1)
{
	if(!empty($_GET))
	{ 
		/* Als er bestelling zijn veranderd dan update de website het op dezelfde pagina */
		if(!empty($_GET['betaalt']))
		{
		$orderquery = mysql_query("UPDATE  orders SET  paid =  'yes',date_paid = NOW( ) WHERE order_number =".$_GET['ordernummer'] . " AND product_number = ".mysql_real_escape_string(htmlentities($_GET['productnaam'])));
		}
		if(!empty($_GET['geleverd']))
		{
		$orderquery = mysql_query("UPDATE  orders SET  delivered =  'yes',date_delivered = NOW( ) WHERE order_number =".$_GET['ordernummer'] . " AND product_number = ".mysql_real_escape_string(htmlentities($_GET['productnaam'])));
		}
	}
?>
<script type="text/javascript"> 
	var positie = 0;
    function voeg_cel_toe( ordernummer,accountnummer,voornaam, tussenvoegsel, achternaam,aantal ,date_order,productnaam, prijs, betaalt , betaaldatum , geleverd , leverdatum, productnummer)
	{ 
		<!-- Voor elk product wordt een aparte rij toegevoegd -->
		var winkel = document.getElementById("Winkel");	
		
		positie = positie + 1;
		var posnew = positie;
		var anchor = document.createElement("a");
		anchor.setAttribute("name","pos" + posnew);
		winkel.appendChild(anchor);
		
		var tr = document.createElement("tr");
		tr.setAttribute("valign", "top");
		winkel.appendChild(tr);
		
		var td = document.createElement("td");
		td.innerHTML = ordernummer;
		tr.appendChild(td);
		
		var td1 = document.createElement("td");
		td1.innerHTML = accountnummer;
		tr.appendChild(td1);
		
		var td2 = document.createElement("td");
		td2.innerHTML = voornaam + " " + tussenvoegsel + " " + achternaam;
		tr.appendChild(td2);
		
		var td3 = document.createElement("td");
		td3.innerHTML = aantal;
		tr.appendChild(td3);
		
		var td4 = document.createElement("td");
		td4.innerHTML = date_order;
		tr.appendChild(td4);
		
		var td5 = document.createElement("td");
		td5.innerHTML = productnaam;
		tr.appendChild(td5);
		
		var td6 = document.createElement("td");
		td6.innerHTML = "&#8364 " + prijs;
		tr.appendChild(td6);
		
		if ( betaalt == 'no')
		{
			var td10 = document.createElement("td");
			var td7 = document.createElement("input");
			td7.setAttribute("type","button");
			td7.setAttribute("onClick","window.open('bestellingenbeheren.php?ordernummer=" + ordernummer + "&productnaam=" + productnummer +"&betaalt=1#pos"+posnew+  "','_self')");
			td7.setAttribute("value","Betaalt");
			tr.appendChild(td10);
			td10.appendChild(td7);
			
		}
		else
		{
			var td7 = document.createElement("td");
			td7.innerHTML = "Betaald op: " + betaaldatum;
			tr.appendChild(td7);
		}
		
		if( geleverd == 'no')
		{
			var td11 = document.createElement("td");
			var td9 = document.createElement("input");
			td9.setAttribute("type","button");
			td9.setAttribute("onClick","window.open('bestellingenbeheren.php?ordernummer=" + ordernummer + "&productnaam=" + productnummer +"&geleverd=1#pos"+posnew+  "','_self')");
			td9.setAttribute("value","Geleverd");
			tr.appendChild(td11);
			td11.appendChild(td9);
		}
		else
		{
			var td9 = document.createElement("td");
			td9.innerHTML = "Geleverd op: " + leverdatum;
			tr.appendChild(td9);
		}
	
	}
</script>
<table id= "Winkel" class="productlijst" width="100%" border="1" style="text-align:center;">

	<tr>
		<th colspan="9">
			<h2>Bestellingen beheren </h2><br/>

   <form name="zoekbalk" id="oekbalk"> 
  <input type="text" name="search" /> 
  <input type="button" value="zoek" onclick="window.open('bestellingenbeheren.php?search=' + document.forms['oekbalk']['search'].value ,'_self');" />
   </form>
 </th>
  </tr>
 
	<tr valign="top">
		<td >Bestel-nummer</td>
		<td >Account-nummer</td>
		<td >Naam</td>
		<td >Aantal</td>
		<td >Besteldatum</td>
		<td >Productnaam</td>
		<td >PrijsTotaal</td>
		<td >Betaald</td>
		<td >Geleverd</td>
	</tr>
</table>
<script type="text/javascript"> 
	<?php
	$zoek = "";
	if (isset($_GET['search']))
		$zoek = mysql_real_escape_string(htmlentities($_GET['search']));
		$orderquery = mysql_query("SELECT * FROM orders INNER JOIN account ON orders.account_number=account.account_number INNER JOIN products ON orders.product_number=products.product_number 
		WHERE ( account.first_name LIKE '%" . $zoek . "%' OR account.extra_name LIKE '%" . $zoek . "%' OR account.last_name LIKE '%" . $zoek . "%' OR orders.date_delivered LIKE '%" . $zoek . "%' OR 
		orders.delivered LIKE '%" . $zoek . "%' OR orders.req_date_delivered LIKE '%" . $zoek . "%' OR orders.date_paid LIKE '%" . $zoek . "%' OR products.product_name LIKE '%" . $zoek . "%' OR 
		products.description LIKE '%" . $zoek . "%' OR orders.date_order LIKE '%" . $zoek . "%' OR orders.address_delivery LIKE '%" . $zoek . "%' OR orders.address_bill LIKE '%" . $zoek . "%' OR 
	    orders.account_number LIKE '%" . $zoek . "%') ");
        while( $order = mysql_fetch_array($orderquery) ) 
		{   
			/* Als de array er is dan voeg de functie de hele tijd een rij toe met een product */
			$Prijst = mysql_real_escape_string(htmlentities($order['price']))* mysql_real_escape_string(htmlentities($order['amount']));
			$prijs = floor($Prijst / 100); 
			$prijskomma =  ($Prijst % 100);
			if( strlen($prijskomma)!= 2) 
			{
				$prijskomma = "0".$prijskomma;
			}
			$prijsi =  $prijs . '.' . $prijskomma;
			echo "voeg_cel_toe( \"" . mysql_real_escape_string(htmlentities($order['order_number'])) . "\", \"" . mysql_real_escape_string(htmlentities($order['account_number'])) . "\", \"" . mysql_real_escape_string(htmlentities($order['first_name'])) . "\", \"" . mysql_real_escape_string(htmlentities($order['extra_name'])) . "\", \"" . mysql_real_escape_string(htmlentities($order['last_name'])) . "\", \"" . mysql_real_escape_string(htmlentities($order['amount'])) . "\", \"" . mysql_real_escape_string(htmlentities($order['date_order'])) . "\", \"" . mysql_real_escape_string(htmlentities($order['product_name'])) . "\", \"" . $prijsi . "\", \"" . mysql_real_escape_string(htmlentities($order['paid'])) . "\" , \"" . mysql_real_escape_string(htmlentities($order['date_paid'])) . "\",  \"" . mysql_real_escape_string(htmlentities($order['delivered'])) . "\", \"" . mysql_real_escape_string(htmlentities($order['date_delivered'])) . "\", \"" . mysql_real_escape_string(htmlentities($order['product_number'])) . "\" );";
            
		}
	}// Haak sluiten van if($rechten>1) 
    ?>
</script>        
<?php include("footer.php"); ?>