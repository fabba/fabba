<?php 
session_start();
$accountnummer = $_SESSION['accountnummer'];
session_write_close();
include("header.php"); 
include("connect.php");
?>

  <script type="text/javascript"> 
        function voeg_cel_toe( foto,aantal ,productnaam, prijs, omschrijving )
		{ 
		
		var prijsaantal = prijs * aantal;
		var winkel = document.getElementById("Winkel");
		var tr = document.createElement("tr");
		tr.setAttribute("valign", "top");
		winkel.appendChild(tr);
	
		var tdimg = document.createElement("td");
		tdimg.setAttribute("style","height:100%;width:20%;text-align:top;");
		tr.appendChild(tdimg);
		var img = document.createElement("img");
		img.setAttribute("src", foto);
		img.setAttribute("alt", omschrijving);
		img.setAttribute("width", "100");
		img.setAttribute("height", "100");
		tdimg.appendChild(img);
		var td = document.createElement("td");
		td.setAttribute("style","width:20%;text-align:top;");
		td.innerHTML = productnaam;
		tr.appendChild(td);
		var td1 = document.createElement("td");
		td1.setAttribute("style","width:20%;text-align:top;");
		td1.innerHTML = aantal;
		tr.appendChild(td1);
		var td2 = document.createElement("td");
		td2.setAttribute("style","width:20%;text-align:top;");
		td2.innerHTML = prijs;
		tr.appendChild(td2);
		var td3 = document.createElement("td");
		td3.setAttribute("style","width:20%;text-align:top;");
		td3.innerHTML = prijsaantal;
		tr.appendChild(td3);
	
	
	
	
		}
		function voeg_total_toe( aantal,prijs , totaal )
		{ 
		var winkel = document.getElementById("totaal");
		var tr = document.createElement("tr");
		tr.setAttribute("valign", "top");
		winkel.appendChild(tr);
		var tdimg = document.createElement("td");
		tdimg.setAttribute("style","height:100%;width:20%;text-align:top;");
		tdimg.innerHTML = "Totaal";
		tr.appendChild(tdimg);
		var td = document.createElement("td");
		td.setAttribute("style","width:20%;text-align:top;");
		tr.appendChild(td);
		var td1 = document.createElement("td");
		td1.setAttribute("style","width:20%;text-align:top;");
		td1.innerHTML = aantal;
		tr.appendChild(td1);
		var td2 = document.createElement("td");
		td2.setAttribute("style","width:20%;text-align:top;");
		td2.innerHTML = prijs;
		tr.appendChild(td2);
		var td3 = document.createElement("td");
		td3.setAttribute("style","width:20%;text-align:top;");
		td3.innerHTML = totaal;
		tr.appendChild(td3);
	
		}
		
	
		</script>
		
            

	<table id= "Winkel" class="productlijst" width="100%" border="1">
	
		<tr valign="top">
		<td style="height:100%;width:20%;text-align:top;"></td>
		<td style="width:20%;text-align:top;"> </td>
		<td style="width:20%;text-align:top;"><h2>WinkelWagentje </h2></td>
		<td style="width:20%;text-align:top;"> </td>
		<td style="width:20%;text-align:top;"> </td>
		</tr>
		<tr valign="top">
		<td style="height:100%;width:20%;text-align:top;"></td>
		<td style="width:20%;text-align:top;">Naam </td>
		<td style="width:20%;text-align:top;">Aantal </td>
		<td style="width:20%;text-align:top;">Prijs </td>
		<td style="width:20%;text-align:top;">Prijs x Aantal </td>
		</tr>
		</table>
		<table id= "totaal" class="productlijst" width="100%" border="1">
		
		
		</table>
		<table id= "afrekenen" class="productlijst" width="100%" border="1">
		<tr>
		<td style="height:100%;width:20%;text-align:top;"> </td>
		<td style="width:20%;text-align:top;"> </td>
		<td style="width:20%;text-align:top;"> <a class="donker" href="succesvol.php" ><b>Afrekenen</b></a></td>
		<td style="width:20%;text-align:top;"></td>
		<td style="width:20%;text-align:top;"><a class="donker" href="winkelwagen_leegmaken.php">Winkelwagentje leegmaken</a></td>
		</tr>
	</table>
	  <script type="text/javascript"> 
	
	 <?php
		     $totalamount = 0;
			 $totalprice = 0;
			 $total = 0;
            $winkelquery = mysql_query("SELECT * FROM temp_order WHERE account_number = '". $accountnummer . "'");
            while( $winkel = mysql_fetch_array($winkelquery) ) { 
			 $productquery = mysql_query("SELECT * FROM products WHERE product_number= '" . $winkel['product_number'] . "'" );
			 $product = mysql_fetch_array($productquery);
			 $totalamount = $totalamount + $winkel['amount'];
			 $totalprice = $totalprice + $product['price'];
			 $total = $total + $winkel['amount'] * $product['price'] ;
                echo "voeg_cel_toe( \"" . $product['product_photo']  .  "\", \"" . $winkel['amount']  .  "\", \"" . $product['product_name']  .  "\", \"" . $product['price']  .  "\", \"" . $product['description']  .  "\");" ;
                
            }
			echo "voeg_total_toe( \"" . $totalamount .  "\",\"" . $totalprice  .  "\",\"" . $total  .  "\")";
			
        ?>
		</script>

            
<?php include("footer.php"); ?>