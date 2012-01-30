<?php 
session_start();
$accountnummer = $_SESSION['accountnummer'];
session_write_close();
include("header.php");
include("connect.php");
?>
<script type="text/javascript"> 
	function voeg_cel_toe( prijsaantal,foto,ordernummer,accountnummer,aantal ,date_order,productnaam, prijs, betaalt , betaaldatum , geleverd , leverdatum)
	{ 
		<!-- Voor elk product wordt een aparte rij toegevoegd -->
		var winkel = document.getElementById("Winkel");
		
		var tr = document.createElement("tr");
		tr.setAttribute("valign", "top");
		winkel.appendChild(tr);
		
		var tdimg = document.createElement("td");
		tdimg.setAttribute("style","height:100%;width:5%;text-align:top;");
		tr.appendChild(tdimg);
		var img = document.createElement("img");
		img.setAttribute("src", foto);
		img.setAttribute("width", "100");
		img.setAttribute("height", "100");
		tdimg.appendChild(img);
		
		var td = document.createElement("td");
		td.innerHTML = ordernummer;
		tr.appendChild(td);
		
		var td1 = document.createElement("td");
		td1.innerHTML = accountnummer;
		tr.appendChild(td1);
		
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
		td6.innerHTML = "&#8364; " + prijsaantal;
		tr.appendChild(td6);
	
		if ( betaalt == 'no')
		{
			var td7 = document.createElement("td");
			td7.innerHTML = "U heeft nog niet betaald!";
			tr.appendChild(td7);
		}
		else
		{
			var td7 = document.createElement("td");
			td7.innerHTML = "Betaalt op: <br/>"+ betaaldatum;
			tr.appendChild(td7);
		}
		
		if( geleverd == 'no')
		{
			var td9 = document.createElement("td");
			td9.innerHTML = "Het pakket is nog niet geleverd";
			tr.appendChild(td9);
		
		}
		else
		{
			var td9 = document.createElement("td");
			td9.innerHTML = "Geleverd op: <br/>"+ leverdatum;
			tr.appendChild(td9);
		}
	
		}
</script>
<table id= "Winkel" class="productlijst" width="100%" border="1" style="text-align:center;">
	<tr>
		<th colspan="9">
			<h2>Bestelgeschiedenis</h2><br/>
			 <form name="zoekbalk" id="oekbalk"> 
  <input type="text" name="search" /> 
  <input type="button" value="zoek" onclick="window.open('bestelgeschiedenis.php?search=' + document.forms['oekbalk']['search'].value ,'_self');" />
   </form>
		</th>
	</tr>
	<tr valign="top">
		<td >Foto</td>
		<td >Bestel-nummer</td>
		<td >Account-nummer</td>
		<td >Aantal</td>
		<td >Besteldatum</td>
		<td >Productnaam</td>
		<td >PrijsTotaal</td>
		<td >Betaling</td>
		<td >Levering</td>
	</tr>
</table>
<?php
	$zoek = "";
	if (isset($_GET['search']))
		$zoek = mysql_real_escape_string(htmlentities($_GET['search']));
	$orderquery = mysql_query("SELECT * FROM orders  INNER JOIN products ON orders.product_number = products.product_number WHERE account_number =".$accountnummer." AND( account.first_name LIKE '%" . $zoek . "%' OR account.extra_name LIKE '%" . $zoek . "%' OR account.last_name LIKE '%" . $zoek . "%' OR orders.date_delivered LIKE '%" . $zoek . "%' OR 
		orders.delivered LIKE '%" . $zoek . "%' OR orders.req_date_delivered LIKE '%" . $zoek . "%' OR orders.date_paid LIKE '%" . $zoek . "%' OR products.product_name LIKE '%" . $zoek . "%' OR 
		products.description LIKE '%" . $zoek . "%' OR orders.date_order LIKE '%" . $zoek . "%' OR orders.address_delivery LIKE '%" . $zoek . "%' OR orders.address_bill LIKE '%" . $zoek . "%' OR 
	    orders.account_number LIKE '%" . $zoek . "%') ");
    if(!empty($orderquery))
	{
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
			$prijsi =  $prijs . ',' . $prijskomma;
			$Prijsti = mysql_real_escape_string(htmlentities($order['price']));
			$prijsii = floor($Prijsti / 100); 
			$prijskommai =  ($Prijsti % 100);
			if( strlen($prijskommai)!= 2)
			{
				$prijskommai = "0".$prijskommai;
			}
			$prijsiii =  $prijsii . ',' . $prijskommai;
			echo " <script type='text/javascript'> voeg_cel_toe(  \"" . $prijsi. "\",\"" . mysql_real_escape_string(htmlentities($order['product_photo'])) . "\",\"" . mysql_real_escape_string(htmlentities($order['order_number']))			. "\", \"" . mysql_real_escape_string(htmlentities($order['account_number'])) . "\" , \"" . mysql_real_escape_string(htmlentities($order['amount'])) . "\", \"" . mysql_real_escape_string(htmlentities($order['date_order'])) . "\", \"" . mysql_real_escape_string(htmlentities($order['product_name'])) . "\", \"" . $prijsiii . "\", \"" . mysql_real_escape_string(htmlentities($order['paid'])) . "\" , \"" . mysql_real_escape_string(htmlentities($order['date_paid'])) . "\",  \"" . mysql_real_escape_string(htmlentities($order['delivered'])) . "\", \"" . mysql_real_escape_string(htmlentities($order['date_delivered'])) . "\");	</script>";
            
		}				
	}
	else
	{
		/* Als de array leeg was dan zijn er dus nog geen bestellingen gedaan*/
		echo "<p>U heeft nog geen bestellingen gemaakt. <br/><a href ='productlist.php' class='donker'>Bekijk ons geweldig aanbod eens!</a></p>";
	}	
mysql_close($con);
include("footer.php"); ?>
