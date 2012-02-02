<?php include("header.php"); ?>

<style>
    DIV.movable { position:absolute; }
</style>

<div id="plaatje0" class="movable">
    <a  class="coverflow"  id="link0" ><img id="img0" /></a>
</div>
<div id="plaatje1" class="movable">
    <a  class="coverflow"  id="link1" ><img id="img1" /></a>
</div>
<div id="plaatje5" class="movable">
    <a  class="coverflow"  id="link5" ><img id="img5" /></a>
</div>
<div id="plaatje2" class="movable">
    <a  class="coverflow"  id="link2" ><img id="img2" /></a>
</div>
<div id="plaatje4" class="movable">
    <a  class="coverflow"  id="link4" ><img id="img4" /></a>
</div>
<div id="plaatje3" class="movable">
    <a  class="coverflow"  id="link3" ><img id="img3" /></a>
</div>

<div id="balk" onclick="beweeg_naar_muis();" class="movable">
  <img src="afbeeldingen/coverflowbalk.jpg" />  
</div>
<div id="sleep" class="movable">
  <img src="afbeeldingen/flowknop.jpg" />  
</div>
<div id="knoppen" >
    
    <button type="button" onclick="beweeg_naar_begin();" class="flowknop" >|<</button>
    <button type="button" onclick="beweeg_naar_links(3);" class="flowknop" ><<</button>
    <button type="button" onclick="beweeg_naar_links(1);" class="flowknop" ><</button>
     <button type="button" onclick="beweeg_automatisch();" id="autoknop" class="flowknop" >auto</button> 
    <button type="button" onclick="beweeg_naar_rechts(1);" class="flowknop" >></button> 
    <button type="button" onclick="beweeg_naar_rechts(3);" class="flowknop" >>></button>
    <button type="button" onclick="beweeg_naar_eind();" class="flowknop" >>|</button>
    
</div>

<div id="beschrijving" class="movable" >Naam<br/>Prijs</div>

<script type="text/javascript"  >
    
    var positie = 1 ;
    var sleepx = 0;
    var sleepbeweeg = false ;
    
    var coverflowx =  -590;
    var coverflowy = 200;
    
    var balkx = 35 ;
    var balky = 425 ;
    
    var knoppenx = 298 ;
    var knoppeny = 460 ;
    
    var beschrijvingx = 40 ;
    var beschrijvingy = 280 ;

    var plaatjex = new Array(6) ;
    var plaatjey = new Array(6) ;
    var plaatjesize = new Array(6) ;
    var plaatjesrc = new Array(6) ;
    
    var productnummer = new Array(100) ;
    var productimage = new Array(100) ;
    var productnaam = new Array(100) ;
    var productprijs = new Array(100) ;
    var productaanbieding = new Array(100) ;
    var aantal_producten = 0 ;
   
    
    var defaultx = new Array(6);
    var defaulty = new Array(6);
    var defaultsize = new Array(6);

    var buffer = new Array(5);
    var richting = "rechts" ;
    var bufferlengte = 0 ;
    var beweging = false ;

    function updatePlaatje( nummer ) {
        var totx = Math.round(window.innerWidth / 2 ) + coverflowx + plaatjex[nummer] ;
        var toty = coverflowy + plaatjey[nummer]  ;
        if( plaatjesrc[nummer] != "" && plaatjesrc[nummer] > 0 && plaatjesrc[nummer] <= aantal_producten ){
            document.getElementById("link" + nummer ).setAttribute("href", "productpagina.php?product_number=" + productnummer[plaatjesrc[nummer]]);
            document.getElementById("img" + nummer ).removeAttribute("src");
            document.getElementById("img" + nummer ).setAttribute("src", productimage[plaatjesrc[nummer]]);
            document.getElementById("img" + nummer ).setAttribute("width", plaatjesize[nummer]);
            document.getElementById("img" + nummer ).setAttribute("height", plaatjesize[nummer]);
            
            
        } else {
             document.getElementById("link" + nummer ).removeAttribute("href");
             document.getElementById("img" + nummer ).removeAttribute("src");
        }
        document.getElementById("plaatje" + nummer ).style.top  = toty+'px';
        document.getElementById("plaatje" + nummer ).style.left = totx+'px';
    }
    function updateAlles(){
        var totx = Math.round(window.innerWidth / 2 ) + coverflowx ;
        var toty = coverflowy ;
        document.getElementById("knoppen").style.top  = (toty + knoppeny)+'px';
        document.getElementById("knoppen").style.left = (totx + knoppenx)+'px';
        document.getElementById("balk").style.top  = (toty + balky)+'px';
        document.getElementById("balk").style.left = (totx + balkx)+'px';
        document.getElementById("beschrijving").style.top  = (toty + beschrijvingy)+'px';
        document.getElementById("beschrijving").style.left = (totx + beschrijvingx)+'px';
        if( plaatjesrc[3] != "" && plaatjesrc[3] > 0 && plaatjesrc[3] <= aantal_producten ){
            if(productaanbieding[plaatjesrc[3]] == "-1")
                document.getElementById("beschrijving").innerHTML = '<a class="coverflow" href="productpagina.php?product_number='
                    + productnummer[plaatjesrc[3]] + '">' + productnaam[plaatjesrc[3]]
                    + "<br /> &#8364;" + productprijs[plaatjesrc[3]] + "</a>"  ;
            else
                document.getElementById("beschrijving").innerHTML = '<a class="coverflow" href="productpagina.php?product_number='
                    + productnummer[plaatjesrc[3]] + '">' + productnaam[plaatjesrc[3]]
                    + "<br /><strike style='color:red;font-size:30px;'>&#8364;" + productprijs[plaatjesrc[3]] + "</strike>     &#8364;" + productaanbieding[plaatjesrc[3]] +"</a>"  ;
        } else {
             document.getElementById("beschrijving").innerHTML = "" ;
        
        }
        document.getElementById("sleep").style.left = sleepx +'px';
       for( var teller = 0; teller < 6; teller += 1 ){
            updatePlaatje( teller );
        }
    }
    function plaats_sleep(){
        var totx = Math.round(window.innerWidth / 2 ) + coverflowx ;
        var toty = coverflowy ;
        document.getElementById("sleep").style.top  = (toty + balky - 5)+'px';
        
        sleepx = totx + balkx + (((positie - 1)/(aantal_producten-1)) * 1030) ;
        
        document.getElementById("sleep").style.left = sleepx +'px';
    }
    
    function beweeg_sleep(){
        sleepbeweeg = true ;
        var totx = Math.round(window.innerWidth / 2 ) + coverflowx ;
        if(sleepx < totx + balkx + (((positie - 1)/(aantal_producten-1)) * 1030) ){
            sleepx += 4;
            if(sleepx >= totx + balkx + (((positie - 1)/(aantal_producten-1)) * 1030) ){
                sleepx = totx + balkx + (((positie - 1)/(aantal_producten-1)) * 1030);
                sleepbeweeg = false ;
            } else {
                var s = setTimeout("beweeg_sleep();", 15 );
            }
        } else if(sleepx > totx + balkx + (((positie - 1)/(aantal_producten-1)) * 1030) ){
            sleepx -= 4;
            if(sleepx <= totx + balkx + (((positie - 1)/(aantal_producten-1)) * 1030) ){
                sleepx = totx + balkx + (((positie - 1)/(aantal_producten-1)) * 1030);
                sleepbeweeg = false ;
            } else {
                var s = setTimeout("beweeg_sleep();", 15 );
            }
        } else {
            sleepbeweeg = false ;
        }
         document.getElementById("sleep").style.left = sleepx +'px';
        
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
    stelPlaatje(1, 0, 32, "", 200 ) ;
    stelPlaatje(2, 205, 25, "", 230 ) ;
    stelPlaatje(3, 440, 0, 1, 280 ) ;
    stelPlaatje(4, 725, 25, 2, 230 ) ;
    stelPlaatje(5, 960, 32, 3, 200 ) ;
    stelPlaatje(6, 960, 32, "", 200 ) ;

   function zet_in_lijst( nummer, imagesrc, naam, prijs, aanbiedingsprijs ){
        if(aantal_producten < 100){
            productnummer[aantal_producten + 1] = nummer ;
            productimage[aantal_producten+ 1] = imagesrc ;
            productnaam[aantal_producten+ 1] = naam ;
            productprijs[aantal_producten+ 1] = prijs ;
            productaanbieding[aantal_producten + 1] = aanbiedingsprijs ;
            aantal_producten += 1 ;
        }
    }
    <?php
    function toekomst($datum) {
            $vandaagdatum = date("Y-m-d");
            $vandaag = strtotime($vandaagdatum);
            $anderedatum = strtotime($datum);
            return ($vandaag <= $anderedatum);
    }
    
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
    $aanbieding_query = mysql_query("SELECT * FROM bargains WHERE product_number=" . $product['product_number']);
        $aanbiedingarr = mysql_fetch_array($aanbieding_query);
        $aanbieding = false;

        
        if ($aanbiedingarr) {
            $geldigtot = $aanbiedingarr['to_date'];
            if (toekomst($geldigtot)) {
                $aanbieding = true;
                $aanbiedingsprijs = $aanbiedingarr['temp_price'];
            }
// Als de aanbieding niet meer geldig is, moet deze uit de aanbiedingdatabase worden verwijderd.
            else {
                mysql_query("DELETE from bargains WHERE product_number=" . $product['product_number']);
            }
        }
        if ($aanbieding) {
            $nul = "";
            if (strlen($aanbiedingsprijs % 100) < 2) {
                $nul = "0" . $nul;
            }
    ?>zet_in_lijst( <?php echo $product['product_number'] ; ?>, "<?php echo $product['product_photo'] ; ?>", "<?php echo $product['product_name'] ; ?>", "<?php  echo $prijstotal  ?>", "<?php echo floor($aanbiedingsprijs / 100) . "," . $nul . ($aanbiedingsprijs % 100)?>" );
    <?php } else { ?>
        zet_in_lijst( <?php echo $product['product_number'] ; ?>, "<?php echo $product['product_photo'] ; ?>", "<?php echo $product['product_name'] ; ?>", "<?php  echo $prijstotal  ?>", "-1" );
    <?php
    }
        $teller += 1 ;
    }
    
    ?>
        positie = 1 ;
        updateAlles();
        plaatsAlles();
        
        positie = 1 ;
        plaats_sleep();
        
    
    function verplaats_naar_positie( newpos ){
        
        if(newpos > aantal_producten )
            newpos = aantal_producten  ;
        if(newpos < 1)
            newpos = 1;
        if( positie < newpos ){
            if( newpos - positie < 5 )
                while( newpos - positie < 5 && newpos - positie > 0 ){
                    bufferPlaatje( positie + 3, "links" );
                    positie += 1 ;
                    
                }
            else {
                bufferPlaatje( newpos -2, "links" ) ;
                bufferPlaatje( newpos - 1 , "links" ) ;
                bufferPlaatje( newpos, "links" ) ;
                bufferPlaatje( newpos + 1 , "links" ) ;
                bufferPlaatje( newpos + 2 , "links" ) ;
                positie = newpos ;
            }
            
        } else if ( positie > newpos ){
            if( positie - newpos < 5 ){
                while( positie - newpos < 5 && positie - newpos > 0 ){
                    
                    bufferPlaatje( positie - 3, "rechts" );
                    positie -= 1 ;
                }
            } else {
                
                bufferPlaatje( newpos + 2 , "rechts" ) ;
                bufferPlaatje( newpos + 1 , "rechts" ) ;
                bufferPlaatje( newpos  , "rechts" ) ;
                bufferPlaatje( newpos - 1 , "rechts" ) ;
                bufferPlaatje( newpos - 2, "rechts" ) ;
                positie = newpos ;
            }
            
           
        }
        if(sleepbeweeg == false)
            beweeg_sleep();
        haalUitBuffer();
    }
    
   function beweeg_naar_rechts( aantal ){
       verplaats_naar_positie( positie + aantal );
   }
   function beweeg_naar_links( aantal ){
      verplaats_naar_positie( positie - aantal );
   }
   function beweeg_naar_begin(  ){
       auto = false ;
      verplaats_naar_positie( 0 );
   }
   function beweeg_naar_eind(  ){
       auto = false ;
      verplaats_naar_positie( aantal_producten );
   }
   var auto = false ;
   function beweeg_automatisch(){
       if( auto == true ){
           auto = false ;
           document.getElementById("autoknop").innerHTML = "auto" ;
       } else {
           auto = true ;
           document.getElementById("autoknop").innerHTML = "stop" ;
           auto_beweeg() ;
       }
   }
   function auto_beweeg(){
       if( auto == true ){
            if(positie == aantal_producten){
                    verplaats_naar_positie(0);
                } else {
                        verplaats_naar_positie( positie + 1 );
                }
                var t = setTimeout("auto_beweeg();", 4000 ); 
       }
   }
   
   
   
   window.onresize = function() {
       updateAlles();
       plaats_sleep();
    }
    
    verplaats_naar_positie(3);
    


   
   
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
<h2> Aanbiedingen </h2>
<?php
include("aanbiedingen.php");
include("footer.php");
?>
     
