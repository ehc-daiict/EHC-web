<?php

require 'core.inc.php';
require 'connect.inc.php';
require 'login.php';
require 'events.php';

$value = "An error has occurred";
$result = array("head" => array(), "body" => array() );
if (isset($_GET["method"])){
	
	switch ($_GET["method"]) {
		
		case "login":
			$value = login();
			$head = array("status" => $value, "message" => getStatusCodeMessage($value) );
			$body = array("username" => getUserField("username"), "fullname" => getUserField("fullname"));
			$result["head"] = $head;
			$result["body"] = $body;
			break;
		case "logout":
			$value = logout();
			$head = array("status" => $value, "message" => getStatusCodeMessage($value) );
			$body = array();
			$result["head"] = $head;
			$result["body"] = $body;
			break;
		case "fetchEvents":
			$result = fetchEvents();
			$result["head"]["message"] = getStatusCodeMessage( $result["head"]["status"] );
			break;
	}
}

exit(json_encode($result));

?>