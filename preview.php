<?php

	$url = 'http://localhost/heatmap/Components%20%c2%b7%20Bootstrap.htm';

	//Get paths from path table where 
	require_once('sql.class.php');
	$sqlObj = new SQL();
	$sqlObj->connect('localhost','root','','heatmap');
	$query = "SELECT * FROM path AS PA LEFT JOIN clicks_count As CC ON PA.id=CC.path_id   WHERE code='twitter' AND page='".$url."' ORDER BY CC.clicks DESC ";
	$data =  $sqlObj->query($query);
	print_r($data);
 ?>
 <script src="Components%20%C2%B7%20Bootstrap_files/jquery.js"></script>
 <iframe name="I1" id="if1" width="100%" height="100%" style="visibility:visible" src="<?php echo $url;  ?>">
 </iframe>
<script>
	var currentIFrame = $('#if1');
 		<?php 	foreach($data as $path)
 				{ ?>

 					//currentIFrame.contents().find("html body <?php echo strtolower($path['path']);  ?>").addClass( "foo" );
 					//$( " #if1 html body <?php echo strtolower($path['path']);  ?>" ).html("Test");
 					//alert();
 					$( "iframe <?php echo $path['path'];  ?>" ).css("backgroundColor", "#ff0").addClass( "heat39" );
 					// $( "iframe" ).find('<?php echo strtolower($path['path']);  ?>').addClass( "foo" );
 					//$( "iframe <?php echo strtolower($path['path']);  ?> " ).addClass( "foo" );
 					//alert('<?php echo strtolower($path['path']);  ?>');
 		<?php	} 
 		?>
 	</script>