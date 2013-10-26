<?php

	$url = 'http://heatmap-demo.ap01.aws.af.cm/Components-Bootstrap.htm';

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
 	<style type="text/css">
 		.tooltipsy
 		{
 		    padding: 10px;
 		    max-width: 200px;
 		    color: #303030;
 		    background-color: #f5f5b5;
 		    border: 1px solid #deca7e;
 		}
 	</style>
 </head>
 <body id="preview">
 	
 </body>
 </html>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
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
        $('#heatmap').remove();
    });

	$(document).ready(function()
	{
		$(document).ajaxStop(function () 
		{
		      <?php 	
 			foreach($data as $key => $path)
			{ ?>
				$(_x('<?php echo strtolower($path['path']);  ?>')).addClass('highlight highlight<?php echo $key; ?>');
				$('.highlight<?php echo $key; ?>').hover( function() 
				{
					//$( this ).append( $( "<a class='hashtip' title='<?php echo $path['clicks']; ?> Clicks' ></a>" ) );
					$( this ).attr("title","<?php echo $path['clicks']; ?> Clicks");


				}, 
				function() 
				{
				});
 		<?php	
 			} 
 		?>
 			for (var i=0; i < $('.highlight').length ; i++) 
 			{
 				var r = 250;
 				var g = 42;
 				var b = 0;
 				//$('.highlight'+i+'').css('background' , color(r+(i*15),g+(i*30),b+(i*30)) );
 				$('.highlight'+i+'').css('background' , color(r+(i*40),g+(i*40),b+(i*40)) );
 			};
		});
	});

	function color(r,g,b)
	{
		return 'rgb('+r+','+g+','+b+')';
	}
</script>