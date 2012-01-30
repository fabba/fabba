<hr />
<script type="text/javascript">
           
    var aantal_subs = 0 ; 
    function voeg_sub_toe( subnummer, subfoto, subnaam ){
             
        var table = document.getElementById("subtabel");
        var subtr ;
        var aantal_rij = 6 ;
        var rij = 1 + Math.floor( aantal_subs / aantal_rij ) ;
        if( aantal_subs % aantal_rij == 0  ){
            subtr = document.createElement("tr");
            subtr.setAttribute("valign", "top");
            subtr.setAttribute("id", "subrij" + rij );
            table.appendChild(subtr);
        } else {
            subtr = document.getElementById(  "subrij" + rij ) ;
        }
            
        var subtd = document.createElement("td");
        subtd.setAttribute("style", "width:" + Math.ceil( 100 / aantal_rij ) + "%;text-align:center;");
                    
        subtr.appendChild(subtd);
                        
        var sublink = document.createElement("a");
        sublink.setAttribute("class", "donker");
        sublink.setAttribute("href", "productlist.php?category=" + subnummer );
        sublink.setAttribute("class", "productinlijst" );
                        
        var subplaat = document.createElement("img");
        subplaat.setAttribute("src", subfoto );
        subplaat.setAttribute("alt", "pic not found");
        subplaat.setAttribute("width", "150");
        subplaat.setAttribute("height", "150");
             
        subtd.appendChild(sublink);
             
        sublink.appendChild(subplaat);
        sublink.innerHTML = sublink.innerHTML + "<br //> " + subnaam ;
            
        aantal_subs += 1 ;
    }
        
</script>

<table id="subtabel" class="productlijst" width="100%" border="0">
</table> <br />

<script type="text/javascript">
<?php
$subquery = mysql_query("SELECT * FROM categories WHERE parent_category=" . $categorie);
while ($sub = mysql_fetch_array($subquery)) {
    echo "voeg_sub_toe( \"" . mysql_real_escape_string(htmlentities($sub['category_number'])) . "\", \"" . mysql_real_escape_string(htmlentities($sub['photo'])) . "\", \"" . mysql_real_escape_string(htmlentities($sub['category_name'])) . "\" );";
}
?>
       
</script>

