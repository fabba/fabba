<?php
include("header.php");

if($rechten==2){
	if (!empty($_POST)) {
		include("connect.php");
		if (mysql_query("INSERT INTO brands (brand_name)
            VALUES('" . mysql_real_escape_string(htmlentities($_POST['naam'])) . "')")) {
?>
        <script type="text/javascript">
            alert("Merk toegevoegd");
            
        </script>
        <?php
		} 	
		else {
			die('Connectiefout: ' . mysql_error());
			?>
			doet niet :c
			<?php
		}
		mysql_close($con);
	} 

	

       ?>                 
         <form name="toevoegen" method="post" action="merk_toevoegen.php">
        <table width="100%" border="0">
          
            <tr>
                <td/>
                <td colspan="2" style="background-color:transparent">
                    
                    
                        <h1>Merk Toevoegen</h1>
                    
                </td>
            </tr>

            <tr valign="top">
                <td style="background-color:transparent;width:30%;height:60%;text-align:right;">
                    

                    <b>Merknaam</b>:<textarea name="naam" style="resize: none;" rows="1" cols="40"></textarea> <br />                   
                </td>
                <td style="width:30%;text-align:right;">
                    <input type="submit" value="voeg toe" />
                    

                    

                </td>
            </tr>

        </table>
        </form>
                        
    <?php
	
}
else{
?>
<div id="midden">
	U bent niet bevoegd deze pagina te bekijken. <a href="index.html">Terug naar FABBA.nl</a>
</div>
<?php
}
include("footer.php");
?>
