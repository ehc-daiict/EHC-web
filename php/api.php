<?php

require 'core.inc.php';
require 'connect.inc.php';
require 'login.php';

$value = "An error has occurred";
$result = array("head" => array(), "body" => array() );
if (isset($_POST["method"])){
	
	switch ($_POST["method"]) {
		
		case "login":
			$value = login();
			$head = array("status" => $value, "message" => getStatusCodeMessage($value) );
			$body = array();
			$result["head"] = $head;
			$result["body"] = $body;
			break;
		
		case "POST_user":
			if (isset($_POST["id"]))
			$value = POST_user_by_id($_POST["id"]);
			else
			$value = "Missing argument";
			break;
	}
}

exit(json_encode($result));

?>