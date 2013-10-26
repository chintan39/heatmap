<?php


//Get input variables

if(!empty($_POST))
{
	require_once('sql.class.php');
	$sqlObj = new SQL();

	$services_json = json_decode(getenv("VCAP_SERVICES"),true);
	$mysql_config = $services_json["mysql-5.1"][0]["credentials"];
	$username = $mysql_config["username"];
	$password = $mysql_config["password"];
	$hostname = $mysql_config["hostname"];
	$port = $mysql_config["port"];
	$db = $mysql_config["name"];

	$sqlObj->connect($hostname,$username,$password,$db);
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
			$query = "INSERT INTO clicks_count 
						(
							path_id,
							clicks
						) 
						VALUES 
						(
							'".$url_id."',
							'1'
						)";
			$sqlObj->query($query);
		}
		else
		{
			$url_id = $data[0]['id'];
			$query = "UPDATE clicks_count SET clicks = clicks + 1 WHERE path_id = ".$url_id." ";
			$sqlObj->query($query);
		}
		$xpos = $_POST['xpos'];
		$ypos = $_POST['ypos'];
		//Update Click log
		$query = "INSERT INTO clicks_log 
						(
							path_id,
							xpos,
							ypos
						) 
						VALUES 
						(
							'".$url_id."',
							'".$xpos."',
							'".$ypos."'
						)";
			$sqlObj->query($query);		
		//
		//print_r($data);
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