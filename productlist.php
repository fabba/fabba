
<?php   include("header.php"); 
        include("connect.php");?>

   
       <script type="text/javascript"> 
        var aantal_cellen = 0 ; 
        function voeg_cel_toe( productnummer, fotopad, naam, prijs ){
             
            var table = document.getElementById("producttabel");
            var tr ;
            var aantal_in_rij = 6 ;
            var rij = 1 + Math.floor( aantal_cellen / aantal_in_rij ) ;
            if( aantal_cellen % aantal_in_rij == 0  ){
                tr = document.createElement("tr");
                tr.setAttribute("valign", "top");
                tr.setAttribute("id", "rij" + rij );
                table.appendChild(tr);
            } else {
                tr = document.getElementById(  "rij" + rij ) ;
            }
            
             var td = document.createElement("td");
             td.setAttribute("style", "width:" + Math.ceil( 100 / aantal_in_rij ) + "%;text-align:center;");
                    
             tr.appendChild(td);
                        
             var link = document.createElement("a");
             link.setAttribute("class", "donker");
             link.setAttribute("href", "productpagina.php?product_number=" + productnummer );
             link.setAttribute("class", "productinlijst" );
                        
             var plaat = document.createElement("img");
             plaat.setAttribute("src", fotopad );
             plaat.setAttribute("alt", "pic not found");
             plaat.setAttribute("width", "150");
             plaat.setAttribute("height", "150");
             
             td.appendChild(link);
             
             link.appendChild(plaat);
             link.innerHTML = link.innerHTML + "<br //> " + naam + " <br //> &#8364 " + prijs ;
            
            aantal_cellen += 1 ;
        }
     </script>
    

    
    <table id="producttabel" class="productlijst" width="100%" border="0">

    </table>
    <script type="text/javascript">
        <?php
            $productquery = mysql_query("SELECT * FROM products");
            while( $product = mysql_fetch_array($productquery) ) { 
                echo "voeg_cel_toe( \"" . $product['product_number']  .  "\", \"" . $product['product_photo']  .  "\", \"" .$product['product_name'] . "\", \"" . $product['price'] . "\" );" ;
                
            }
        ?>
    </script>
 <?php include("footer.php"); ?>
