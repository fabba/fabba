<?php include("header.php"); ?>

<style>
    DIV.movable { position:absolute; }
</style>

<div id="plaatje0" class="movable">

</div>
<div id="plaatje6" class="movable">

</div>
<div id="plaatje1" class="movable">
</div>
<div id="plaatje5" class="movable">
</div>
<div id="plaatje2" class="movable">
</div>
<div id="plaatje4" class="movable">
</div>
<div id="plaatje3" class="movable">

</div>

<div id="knoppen" >
<button type="button" onclick="beweeg_naar_begin();" >|<</button>
<button type="button" onclick="beweeg_naar_links(2);" ><<</button>
<button type="button" onclick="beweeg_naar_links(1);" ><</button>
<button type="button" onclick="beweeg_naar_rechts(1);" >></button> 
<button type="button" onclick="beweeg_naar_rechts(2);" >>></button>
<button type="button" onclick="beweeg_naar_eind();" >>|</button>
</div>


<script type="text/javascript"  >

    
    var coverflowx =  -590;
    var coverflowy = 200; 

    var plaatjex = new Array(6) ;
    var plaatjey = new Array(6) ;
    var plaatjesize = new Array(6) ;
    var plaatjesrc = new Array(6) ;
    
    var productnummer = new Array(100) ;
    var productimage = new Array(100) ;
    var productnaam = new Array(100) ;
    var productprijs = new Array(100) ;
    var aantal_producten = 0 ;
   
    
    var defaultx = new Array(6);
    var defaulty = new Array(6);
    var defaultsize = new Array(6);

    var buffer = new Array(5);
    var richting = "rechts" ;
    var bufferlengte = 0 ;
    var beweging = false ;

    function updatePlaatje( nummer ) {
        var totx = Math.round(window.innerWidth / 2 ) + coverflowx + plaatjex[nummer] * 1 ;
        var toty = coverflowy + plaatjey[nummer] * 1 ;
        if( plaatjesrc[nummer] != ""  ){
            document.getElementById("plaatje" + nummer ).innerHTML =  "<a  class=\"coverflow\" href=\"productpagina.php?product_number=" + productnummer[plaatjesrc[nummer]] + "\" > <img id=\"img" + nummer + "\" src=\"" + productimage[plaatjesrc[nummer]] + "\" /><br/>" + productnaam[plaatjesrc[nummer]] + "<br /> &#8364;" + productprijs[plaatjesrc[nummer]] + "</a>";
            document.getElementById("img" + nummer ).setAttribute("width", plaatjesize[nummer]);
            document.getElementById("img" + nummer ).setAttribute("height", plaatjesize[nummer]);
            
            
        } else {
            document.getElementById("plaatje" + nummer ).innerHTML = "";
        }
        document.getElementById("plaatje" + nummer ).style.top  = toty+'px';
        document.getElementById("plaatje" + nummer ).style.left = totx+'px';
    }
    function updateAlles(){
        var totx = Math.round(window.innerWidth / 2 ) + coverflowx + 462 ;
        var toty = coverflowy + 350 ;
        document.getElementById("knoppen").style.top  = toty+'px';
        document.getElementById("knoppen").style.left = totx+'px';
       for( var teller = 0; teller < 6; teller += 1 ){
            updatePlaatje( teller );
        }
    }
    function plaatsPlaatje( nummer ) {
        var totx = Math.round(window.innerWidth / 2 ) + coverflowx + plaatjex[nummer] * 1 ;
        var toty = coverflowy + plaatjey[nummer] * 1 ;
        document.getElementById("plaatje" + nummer ).style.top  = toty+'px';
        document.getElementById("plaatje" + nummer ).style.left = totx+'px';
        if(plaatjesrc[nummer] != ""){
                document.getElementById("img" + nummer ).setAttribute("width", plaatjesize[nummer]);
                document.getElementById("img" + nummer ).setAttribute("height", plaatjesize[nummer]);
        }
    }

    function plaatsAlles(){
        for( var teller = 0; teller < 6; teller += 1 ){
            plaatsPlaatje( teller );
        }
    }
    function zetPlaatje( nummer, x, y ) {
        plaatjex[nummer] = x ;
        plaatjey[nummer] = y ;
    }
    function veranderPlaatje( nummer, newsrc ){
        plaatjesrc[nummer] = newsrc ;
        
    }
    function vergrootPlaatje( nummer, grootte ){
        plaatjesize[nummer] = grootte ;
    }
    function stelPlaatje(nummer, x, y, src, size){
        zetPlaatje( nummer, x, y) ;
        veranderPlaatje( nummer, src ) ;
        vergrootPlaatje( nummer, size ) ;
        
    }
    function stelDefault( nummer, x, y, size ){
        defaultx[nummer] = x ;
        defaulty[nummer] = y ;
        defaultsize[nummer] = size ;
    }
    function vervangPlaatje( nummer, plek){
        stelPlaatje( nummer, plaatjex[plek], plaatjey[plek], plaatjesrc[plek], plaatjesize[plek] );
        updatePlaatje( nummer );
    }
    function beweegPlaatjesRechts(){
        vervangPlaatje( 0, 5);
        vervangPlaatje( 5, 4);
        vervangPlaatje( 4, 3);
        vervangPlaatje( 3, 2);
        vervangPlaatje( 2, 1);
    
    }
    function beweegPlaatjesLinks(){
        vervangPlaatje( 0, 1);
        vervangPlaatje( 1, 2);
        vervangPlaatje( 2, 3);
        vervangPlaatje( 3, 4);
        vervangPlaatje( 4, 5);
    
    }
    function stapPlaatje( nummer ){
        var stap = 8 ;
        var sizestap = 2 ;
        var stapgezet = false ;
        if( nummer > 0 ){
            if( plaatjex[nummer] < defaultx[nummer] ){
                plaatjex[nummer] += stap ;
                if( plaatjex[nummer] > defaultx[nummer] ){
                    plaatjex[nummer] = defaultx[nummer] ;
                } else {
                    stapgezet = true;
                }
            } else if (plaatjex[nummer] > defaultx[nummer] ){
                plaatjex[nummer] -= stap ;
                if( plaatjex[nummer] < defaultx[nummer] ){
                    plaatjex[nummer] = defaultx[nummer] ;
                } else {
                    stapgezet = true;
                }
            }
            if( plaatjey[nummer] > defaulty[nummer] ){
                plaatjey[nummer] -= stap ;
                if( plaatjey[nummer] < defaulty[nummer] ){
                    plaatjey[nummer] = defaulty[nummer] ;
                } else {
                    stapgezet = true;
                }
            } else if (plaatjey[nummer] < defaulty[nummer] ){
                plaatjey[nummer] += stap ;
                if( plaatjey[nummer] > defaulty[nummer] ){
                    plaatjey[nummer] = defaulty[nummer] ;
                } else {
                    stapgezet = true;
                }
            }
    
            if(plaatjesize[nummer] < defaultsize[nummer]){
                plaatjesize[nummer] += sizestap  ;
                if( plaatjesize[nummer] > defaultsize[nummer] ){
                    plaatjesize[nummer] = defaultsize[nummer] ;
                } else {
                    stapgezet = true;
                }
            } else if(plaatjesize[nummer] > defaultsize[nummer]){
                plaatjesize[nummer] -= sizestap  ;
                if( plaatjesize[nummer] < defaultsize[nummer] ){
                    plaatjesize[nummer] = defaultsize[nummer] ;
                } else {
                    stapgezet = true;
                }
            }
        } else {
            if(plaatjesize[nummer] < defaultsize[nummer]){
                plaatjesize[nummer] += sizestap * 2  ;
                if( plaatjesize[nummer] > defaultsize[nummer] ){
                    plaatjesize[nummer] = defaultsize[nummer] ;
                } else {
                    stapgezet = true;
                }
            } else if(plaatjesize[nummer] > defaultsize[nummer]){
                plaatjesize[nummer] -= sizestap * 2 ;
                if( plaatjesize[nummer] < defaultsize[nummer] ){
                    plaatjesize[nummer] = defaultsize[nummer] ;
                } else {
                    stapgezet = true;
                }
            }
        }
        return( stapgezet );
    }
    function beweegPlaatjes(){
        beweging = true ;
        var doorgaan = false ;
        for( var teller = 0 ; teller < 6 ; teller++){
            if(stapPlaatje(teller) == true)
                doorgaan = true;
        }
        plaatsAlles();
        if( doorgaan == true ){
            var t = setTimeout("beweegPlaatjes();", 15 );
        } else {
            veranderPlaatje(0, "");
            updateAlles();
            beweging = false;
            haalUitBuffer();
        }
    }

    function bufferPlaatje( src, bufferrichting ){
    
        if( bufferrichting != richting ){
            richting = bufferrichting ;
            bufferlengte = 0 ;
        } else if( bufferlengte == 5 ){
            haalBufferWeg();
        }
        buffer[bufferlengte] = src ;
        bufferlengte += 1 ;
    }

    function haalBufferWeg(){
        if(bufferlengte > 0){
            for( var teller = 0; teller < bufferlengte ; teller++ ){
                buffer[teller] = buffer[teller + 1] ;
            }
            bufferlengte -= 1 ;
        }
    
    }

    function haalUitBuffer(){
        if( bufferlengte > 0 && beweging == false) {
            if( richting == "rechts" ){
                beweegPlaatjesRechts();
                veranderPlaatje(1, buffer[0]);
            } else {
                beweegPlaatjesLinks();
                veranderPlaatje(5, buffer[0]);
            }
            haalBufferWeg();
            updateAlles();
            beweegPlaatjes();
        } else {
            updateAlles();
        }
    
    }

    stelDefault( 0, 0, 32, 100);
    stelDefault( 1, 0, 32, 200);
    stelDefault( 2, 205, 25, 230);
    stelDefault( 3, 440, 0, 280);
    stelDefault( 4, 725, 25, 230);
    stelDefault( 5, 960, 32, 200 );
    
    stelPlaatje(0, 0, 32, "", 200 ) ;
    stelPlaatje(1, 0, 32, 1, 200 ) ;
    stelPlaatje(2, 205, 25, 2, 230 ) ;
    stelPlaatje(3, 440, 0, 3, 280 ) ;
    stelPlaatje(4, 725, 25, 4, 230 ) ;
    stelPlaatje(5, 960, 32, 5, 200 ) ;
    stelPlaatje(6, 960, 32, "", 200 ) ;

   function zet_in_lijst( nummer, imagesrc, naam, prijs){
        if(aantal_producten < 100){
            productnummer[aantal_producten + 1] = nummer ;
            productimage[aantal_producten+ 1] = imagesrc ;
            productnaam[aantal_producten+ 1] = naam ;
            productprijs[aantal_producten+ 1] = prijs ;
            aantal_producten += 1 ;
        }
    }
    <?php
    include("connect.php");
    $product_query = mysql_query("SELECT * FROM products ORDER BY likes DESC");
    $teller = 0 ;
    while(($product = mysql_fetch_array($product_query)) && $teller < 100){
    $Prijst = mysql_real_escape_string(htmlentities($product['price']));
    $prijs = floor($Prijst / 100); 
    $prijskomma =  ($Prijst % 100);
	if( strlen($prijskomma)!= 2)
	{
		$prijskomma = "0".$prijskomma;
	}
	$prijstotal = ($prijs . ',' . $prijskomma);
    ?>zet_in_lijst( <?php echo $product['product_number'] ; ?>, "<?php echo $product['product_photo'] ; ?>", "<?php echo $product['product_name'] ; ?>", "<?php  echo $prijstotal  ?>");
    <?php
        $teller += 1 ;
    }
    
    ?>
        updateAlles();
        plaatsAlles();
     var positie = 1;
    function verplaats_naar_positie( newpos ){
        
        if(newpos > aantal_producten - 4)
            newpos = aantal_producten - 4 ;
        if(newpos < 1)
            newpos = 1;
        if( positie < newpos ){
            if( newpos - positie <= 5 )
                while( newpos - positie <= 5 && newpos - positie > 0 ){
                    bufferPlaatje( positie + 5, "links" );
                    positie += 1 ;
                    
                }
            else {
                bufferPlaatje( newpos, "links" ) ;
                bufferPlaatje( newpos + 1 , "links" ) ;
                bufferPlaatje( newpos + 2 , "links" ) ;
                bufferPlaatje( newpos + 3 , "links" ) ;
                bufferPlaatje( newpos + 4 , "links" ) ;
                positie = newpos ;
            }
            
        } else if ( positie > newpos ){
            if( positie - newpos < 5 ){
                while( positie - newpos < 5 && positie - newpos > 0 ){
                    
                    bufferPlaatje( positie - 1, "rechts" );
                    positie -= 1 ;
                }
            } else {
                
                bufferPlaatje( newpos + 4 , "rechts" ) ;
                bufferPlaatje( newpos + 3 , "rechts" ) ;
                bufferPlaatje( newpos + 2 , "rechts" ) ;
                bufferPlaatje( newpos + 1 , "rechts" ) ;
                bufferPlaatje( newpos, "rechts" ) ;
                positie = newpos ;
            }
            
           
        }
        
        haalUitBuffer();
    }
    function beweeg_automatisch(){
       verplaats_naar_positie( positie + 6 );
       var t = setTimeout("beweeg_automatisch();", 8000  ) ;
    }
   function beweeg_naar_rechts( aantal ){
       verplaats_naar_positie( positie + aantal );
   }
   function beweeg_naar_links( aantal ){
      verplaats_naar_positie( positie - aantal );
   }
   function beweeg_naar_begin(  ){
      verplaats_naar_positie( 0 );
   }
   function beweeg_naar_eind(  ){
      verplaats_naar_positie( aantal_producten - 4 );
   }
   
   
</script>

<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<?php include("footer.php"); ?>
     
