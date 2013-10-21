<?php


//Get input variables

if(!empty($_POST))
{
	require_once('sql.class.php');
	$sqlObj = new SQL();
	$sqlObj->connect('localhost','root','','heatmap');
	if(isset($_POST['code']) && !empty($_POST['code']))
	{
		$code = $_POST['code'];	
		$path = $_POST['path'];
		$url  = $_SERVER['HTTP_REFERER'];
		$hash = md5($code.$path.$url);

		$query = "SELECT * FROM path WHERE hash='".$hash."'";
		$data =  $sqlObj->query($query);
		if(empty($data))
		{
			$query = "INSERT INTO path 
						(
							page,
							code,
							path,
							hash
						) 
						VALUES 
						(
							'".$url."',
							'".$code."',
							'".$path."',
							'".$hash."'
						)";
			$url_id =  $sqlObj->query($query);
		}
		else
		{
			$url_id = $data[0]['id'];
		}

		//Update Click count
		
		//
		print_r($data);
	}
	$sqlObj->disconnect();
}
else
{

}


function getPathID($hash)
{
	$query = "SELECT * FROM path WHERE hash='".$hash."'";
	return $sqlObj->query($query);
}


 //print_r($_SERVER); print_r($_POST); print_r($_REQUEST); ?>