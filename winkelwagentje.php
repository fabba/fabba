<?php 
session_start();
$accountnummer = $_SESSION['accountnummer'];
session_write_close();
include("header.php"); 
include("connect.php");
if(!empty($_GET))
{	
	$orderquery = mysql_query("DELETE FROM temp_order WHERE account_number='" . $accountnummer ."' AND product_number='" . mysql_real_escape_string(htmlentities($_GET['productnaam'])) ."'");
	/* Als men op verwijderen drukt wordt een specifiek product uit het winkelwagentje verwijderd, dat gebeurt met deze query */
}
?>
<script type="text/javascript"> 
	var positie = 0;
    function voeg_cel_toe( prijsaantal,foto,aantal ,productnaam, prijs, omschrijving,productnummer )
	{ 
		<!-- Er wordt voor elk product een aparte rij toegevoegd -->
		var winkel = document.getElementById("Winkel");
		
		positie = positie + 1;
		var posnew = positie;
		var anchor = document.createElement("a");
		anchor.setAttribute("name","pos" + posnew);
		winkel.appendChild(anchor);
		
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
		td2.innerHTML = "&#8364; "+ prijs;
		tr.appendChild(td2);
		
		
		var td3 = document.createElement("td");
		td3.setAttribute("style","width:20%;text-align:top;");
		td3.innerHTML = "&#8364; "+ prijsaantal;
		tr.appendChild(td3);
		
		var td11 = document.createElement("td");
		var td9 = document.createElement("input");
		td9.setAttribute("type","button");
		td9.setAttribute("onClick","window.open('winkelwagentje.php?productnaam=" + productnummer +"#pos"+posnew+  "','_self')");
		td9.setAttribute("value","Verwijder");
		tr.appendChild(td11);
		td11.appendChild(td9);
	
	}
	function voeg_total_toe( aantal,prijs , totaal )
	{ 
		<!-- Op het laatst wordt het totaal verkregen en in de laatste rij gezet -->	
		var winkel = document.getElementById("Winkel");
		
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
		tr.appendChild(td2);
	
		var td3 = document.createElement("td");
		td3.setAttribute("style","width:20%;text-align:top;");
		td3.innerHTML = "&#8364; "+ totaal;
		tr.appendChild(td3);
		
		var td4 = document.createElement("td");
		tr.appendChild(td4);
		
		var tr1 = document.createElement("tr");
		tr1.setAttribute("valign", "top");
		winkel.appendChild(tr1);
		
		var th = document.createElement("th");
		th.setAttribute("colspan", "5");
	    tr1.appendChild(th);
		
		var a1 = document.createElement("a");
		a1.setAttribute("class","donker");
		a1.setAttribute("href","succesvol.php");
		a1.innerHTML = "Afrekenen";
		th.appendChild(a1);
		
		var td6 = document.createElement("td");
		tr1.appendChild(td6);
		var a = document.createElement("a");
		a.setAttribute("class","donker");
		a.setAttribute("href","winkelwagen_leegmaken.php");
		a.innerHTML = "Winkelwagentje leegmaken";
		td6.appendChild(a);
	}	
</script>
<table id= "Winkel" class="productlijst" width="100%" border="1">
	<tr>
		<th colspan="6">
			<h2>winkelwagentje </h2>
		</th>
	</tr>
	<tr valign="top">
		<td style="height:100%;width:20%;text-align:top;"></td>
		<td style="width:20%;text-align:top;">Naam </td>
		<td style="width:20%;text-align:top;">Aantal </td>
		<td style="width:20%;text-align:top;">Prijs </td>
		<td style="width:20%;text-align:top;">Prijs x Aantal </td>
		<td style="width:20%;text-align:top;">Verwijder uit winkelwagentje </td>
	</tr>
</table>
<script type="text/javascript"> 
	<?php
	function toekomst($datum) {
				$vandaagdatum = date("Y-m-d");
				$vandaag = strtotime($vandaagdatum);
				$anderedatum = strtotime($datum);
				return ($vandaag <= $anderedatum);
				}
		    $totalamount = 0;
			$totalprice1 = 0;
			$totalprice2 = 0;
			$total1 = 0;
			$total2 = 0;
            $winkelquery = mysql_query("SELECT * FROM temp_order WHERE account_number = '". $accountnummer . "'");
            while( $winkel = mysql_fetch_array($winkelquery) ) 
			{ 
				/* Alle producten worden uit temp_order gehaald en in een array gezet zolang die array producten bevat blijft de functie rijen toevoegen */
				$productquery = mysql_query("SELECT * FROM products WHERE product_number= '" . mysql_real_escape_string(htmlentities($winkel['product_number'])) . "'" );
				$product = mysql_fetch_array($productquery);
				
				$Prijsti = mysql_real_escape_string(htmlentities($product['price']));
				$aanbieding_query = mysql_query("SELECT * FROM bargains WHERE product_number='" . mysql_real_escape_string(htmlentities($winkel['product_number'])) . "'");
				$aanbiedingarr = mysql_fetch_array($aanbieding_query);
				

				if($aanbiedingarr) {
				$geldigtot = $aanbiedingarr['to_date'];
				if (toekomst($geldigtot)) {
					$aanbieding = true;
					$Prijsti = $aanbiedingarr['temp_price'];
			}
    // Als de aanbieding niet meer geldig is, moet deze uit de aanbiedingdatabase worden verwijderd.
    else {
        mysql_query("DELETE from bargains where product_number=$product_nummer");
    }
}
				$Prijst = $Prijsti* mysql_real_escape_string(htmlentities($winkel['amount']));
				$prijs = floor($Prijst / 100); 
				$prijskomma =  ($Prijst % 100);
				if( strlen($prijskomma)!= 2)
				{
					$prijskomma = "0".$prijskomma;
				}
				$prijsi =  $prijs . '.' . $prijskomma;
				
				$prijsii = floor($Prijsti / 100); 
				$prijskommai =  ($Prijsti % 100);
				if( strlen($prijskommai)!= 2)
				{
					$prijskommai = "0".$prijskommai;
				}
				$prijsiii =  $prijsii . '.' . $prijskommai;
				
				$totalamount = $totalamount + mysql_real_escape_string(htmlentities($winkel['amount']));
				$totalprice1 = $totalprice1 + $prijsii;
				$totalprice2 = $totalprice2 + $prijskommai;
				$total1 = $total1 + $prijs;
				$total2 = $total2 + $prijskomma;
                echo "voeg_cel_toe(  \"" . $prijsi .  "\",\"" . mysql_real_escape_string(htmlentities($product['product_photo']))  .  "\", \"" . mysql_real_escape_string(htmlentities($winkel['amount']))  .  "\", \"" . mysql_real_escape_string(htmlentities($product['product_name']))  .  "\", \"" . $prijsiii  .  "\", \"" . mysql_real_escape_string(htmlentities($product['description']))  .  "\", \"" . mysql_real_escape_string(htmlentities($product['product_number']))  .  "\");" ;
                
            }
			$totalprice = (($totalprice1 ."00")+$totalprice2)/100;
			$total =(($total1 . "00")+$total2)/100;
			echo "voeg_total_toe( \"" . $totalamount .  "\",\"" . $totalprice  .  "\",\"" . $total  .  "\");";
			/* Als de array is afgelopen wordt het totaal weergeven */
			
    ?>
</script>
<?php include("footer.php"); ?>