<?php
// Logout pagina
// De sessie wordt vernietigd en de gebruiker wordt doorverwezen naar de homepagina.

$doorschrijven = true ;
include("legeheader.php"); 
session_destroy(); 

?>
         
<script type="text/javascript">
window.open("index.php",'_self','',true);
</script>
<?php 
include("legefooter.php"); 
?>
     
