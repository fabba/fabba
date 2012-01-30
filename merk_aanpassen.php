<?php
include("header.php");

if($rechten==2){
        include("connect.php");
	if (!empty($_POST)) {
		
		if (mysql_query("UPDATE brands SET brand_name='" . mysql_real_escape_string(htmlentities($_POST['naam'])) . "' WHERE brand_number='" . mysql_real_escape_string(htmlentities($_POST['nummer'])) . "'")) {
?>
        <script type="text/javascript">
            alert("Merk veranderd");
            
        </script>
            
        <?php
        
            }
        }
	
	if (!empty($_GET)) {
			if(!empty($_GET['num']))
				{
				mysql_query("DELETE FROM brands WHERE brand_number= '" . mysql_real_escape_string(htmlentities($_GET['num'])) ."'");
				?>
				<script type="text/javascript">
				alert("Merk verwijderd");
				window.location="merk_aanpassen.php"; 
				</script>
				<?php
				}
				$categor = mysql_query("SELECT * FROM brands WHERE brand_number='" . mysql_real_escape_string(htmlentities($_GET['categor'])) ."'");
			 $categorarray = mysql_fetch_array($categor) ;
	

       ?>                 
         <form name="toevoegen" method="post" action="merk_aanpassen.php">
        <table width="100%" border="0">
          
            <tr>
                <td/>
                <td colspan="2" style="background-color:transparent">
                    
                    
                        <h1>Merk aanpassen</h1>
                    
                </td>
            </tr>
			<?php
			echo'
			<input name="nummer" style="display:none;" value="'.$categorarray['brand_number'].'" />';
			?>
            <tr valign="top">
                <td style="background-color:transparent;width:30%;height:60%;text-align:right;">
                    

                  <?php  echo'<b>Merknaam</b>:<textarea name="naam" style="resize: none;" rows="1" cols="40">' . $categorarray['brand_name'] .'				  </textarea>'?> <br />                   
                </td>
                <td style="width:30%;text-align:right;">
                    <input type="submit" value="Pas aan" />
					 <input type="button" value="VERWIJDER merk" onclick="window.open('merk_aanpassen.php?num=<?php echo  $categorarray['brand_number']?>','_self');">
                    

                    

                </td>
            </tr>

        </table>
        </form>
		<?php
     }                   
    else
			{
			?>
			<form name="toevoegen" method="get" action="merk_aanpassen.php">
			<h1>Kies uw merk dat u wil aanpassen</h1><br/><br/>
			<select type="text" name="categor" value=""/>
                            
					<?php
					$category = mysql_query("SELECT * FROM brands ORDER BY brand_name");
					while ( $catearray = mysql_fetch_array($category) )
					{ 
					echo'
						<option value=" '. $catearray['brand_number'] . '">' . $catearray['brand_name'] .'</option>
					';
					} 
					?></select>
			 <input type="submit" value="Pas aan" />
			 </form>
			 
			 

        </table>
       
                        
    <?php
	
	}
	
}
else{
?>
<div id="midden">
	U bent niet bevoegd deze pagina te bekijken. <a href="index.php">Terug naar FABBA.nl</a>
</div>
<?php
}
include("footer.php");
?>
