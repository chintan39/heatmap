<?php

	$url = 'http://localhost/heatmap/Components%20%c2%b7%20Bootstrap.htm';

	//Get paths from path table where 
	require_once('sql.class.php');
	$sqlObj = new SQL();
	$sqlObj->connect('localhost','root','','heatmap');
	$query = "SELECT * FROM path AS PA LEFT JOIN clicks_count As CC ON PA.id=CC.path_id   WHERE code='twitter' AND page='".$url."' ORDER BY CC.clicks DESC ";
	$data =  $sqlObj->query($query);
	//print_r($data);
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Heatmap Preview</title>
 </head>
 <body id="preview">
 	
 </body>
 </html>
 <script type="text/javascript"  src="Components%20%C2%B7%20Bootstrap_files/jquery.js"></script>
<script type="text/javascript" >

	function _x(STR_XPATH) 
	{
		//alert("Function called");
	    var xresult = document.evaluate(STR_XPATH, document, null, XPathResult.ANY_TYPE, null);
	    var xnodes = [];
	    var xres;
	    while (xres = xresult.iterateNext()) 
	    {
	        xnodes.push(xres);
	    }
	    return xnodes;
	}

	$(function()
	{
        $('#preview').load('<?php echo $url; ?>');
    });

	$(document).ready(function(){

		$(document).ajaxStop(function () {
		      <?php 	
 			foreach($data as $path)
			{ ?>
				$(_x('<?php echo strtolower($path['path']);  ?>')).attr('class', 'modified-text');
 		<?php	
 			} 
 		?>
		  });
 		
	});

</script>