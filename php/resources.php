<?php

function validateVar($var){
	return isset($var) && !empty($var);
}

function bookRoom(){
	$result = array("head" => array(), "body" => array() );
	$head = array("status" => "", "message" => "" );
	$body = array();
	
	
	if (  validateVar($_POST["userName"]) && validateVar($_POST["noOfPerson"]) && validateVar($_POST["date"]) && validateVar($_POST["timeFrom"]) && validateVar($_POST["duration"]) && validateVar($_POST["purpose"]) )
	{
		
		//open config file and see issuer no.
		$issuer = 1;
	
		$query = "INSERT INTO `roomissue` VALUES('".mysql_real_escape_string($_POST["userName"])."',".mysql_real_escape_string($_POST["noOfPerson"]).",'".mysql_real_escape_string($_POST["date"])."','".mysql_real_escape_string($_POST["timeFrom"])."','".mysql_real_escape_string($_POST["duration"])."','".mysql_real_escape_string($_POST["purpose"])."',NULL,NULL,NULL)";
		echo $query;
		if($query_run = mysql_query($query)) {
			//if_ok then send mail to ehc, room_issuer, user
			$head["status"] = 200;
		}else {
			$head["status"] = 400;
		}
	}else{
		$head["status"] = 206;
	}
	
    $result["head"] = $head;
    $result["body"] = $body;
    return $result;

}

function bookComponent(){
	$result = array("head" => array(), "body" => array() );
	$head = array("status" => "", "message" => "" );
	$body = array();
	
	
	if (  validateVar($_POST["userName"]) && validateVar($_POST["noOfPerson"]) && validateVar($_POST["date"]) && validateVar($_POST["timeFrom"]) && validateVar($_POST["duration"]) && validateVar($_POST["purpose"]) && validateVar($_POST["components"]))
	{
		
		//open config file and see issuer no.
		$issuer = 1;
		$comps = explode(',',$_POST['components']);
		$compsPair = array();
		foreach ($comps as $key => $value) {
			$temp = explode(':', $value);
			$compsPair["$temp[0]"] = $temp[1];
		}
		print_r($compsPair);
		foreach ($compsPair as $key => $value) {
			# code...
			
			$query = "INSERT INTO `componentrequest`(`userName`,`noOfPerson`,`date`,`timeFrom`,`duration`,`purpose`,`componentName`,`quantity`) VALUES('".mysql_real_escape_string($_POST["userName"])."','".mysql_real_escape_string($_POST["noOfPerson"])."','".mysql_real_escape_string($_POST["date"])."','".mysql_real_escape_string($_POST["timeFrom"])."','".mysql_real_escape_string($_POST["duration"])."','".mysql_real_escape_string($_POST["purpose"])."','".mysql_real_escape_string($key)."','".mysql_real_escape_string($value)."')";
			
			if($query_run = mysql_query($query)) {
				//if_ok then send mail to ehc, room_issuer, user
				$head["status"] = 200;
			}else {
				$head["status"] = 400;
			}
		}
	}else{
		$head["status"] = 206;
	}

	
    $result["head"] = $head;
    $result["body"] = $body;
    return $result;

}

function bookBook(){
	$result = array("head" => array(), "body" => array() );
	$head = array("status" => "", "message" => "" );
	$body = array();
	
	
	if (  validateVar($_POST["userName"]) && validateVar($_POST["noOfPerson"]) && validateVar($_POST["date"]) && validateVar($_POST["timeFrom"]) && validateVar($_POST["duration"]) && validateVar($_POST["purpose"]) && validateVar($_POST["bookName"]) )
	{
		
		//open config file and see issuer no.
		$issuer = 1;
	
		$query = "INSERT INTO `bookissue` VALUES('".mysql_real_escape_string($_POST["userName"])."','".mysql_real_escape_string($_POST["noOfPerson"])."','".mysql_real_escape_string($_POST["date"])."','".mysql_real_escape_string($_POST["timeFrom"])."','".mysql_real_escape_string($_POST["duration"])."','".mysql_real_escape_string($_POST["purpose"])."','".mysql_real_escape_string($_POST["bookName"])."',NULL,NULL,NULL)";
		if($query_run = mysql_query($query)) {
			//if_ok then send mail to ehc, room_issuer, user
			$head["status"] = 200;
		}else {
			$head["status"] = 400;
		}
	}else{
		$head["status"] = 206;
	}
	
    $result["head"] = $head;
    $result["body"] = $body;
    return $result;
}

?>