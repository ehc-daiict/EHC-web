<?php

require_once 'core.inc.php';
require_once 'connect.inc.php';

$value = "An error has occurred";
$result = array("head" => array(), "body" => array() );
if (isset($_POST["method"])){
	
	switch ($_POST["method"]) {
		
		case "login":
			require_once 'login.php';
			$value = login();
			$head = array("status" => $value, "message" => getStatusCodeMessage($value) );
			$body = array("username" => getUserField("username"), "fullname" => getUserField("name"));
			$result["head"] = $head;
			$result["body"] = $body;
			break;
		case "logout":
			require_once 'login.php';
			$value = logout();
			$head = array("status" => $value, "message" => getStatusCodeMessage($value) );
			$body = array();
			$result["head"] = $head;
			$result["body"] = $body;
			break;
		case "fetchEvents":
			require_once 'events.php';
			$result = fetchEvents();
			$result["head"]["message"] = getStatusCodeMessage( $result["head"]["status"] );
			break;
		case "fetchBlogs":
			require_once 'blog.php';
			$result = fetchBlogs();
			$result["head"]["message"] = getStatusCodeMessage( $result["head"]["status"] );
			break;
		case "fetchRecentBlogs":
			require_once 'blog.php';
			$result = fetchRecentBlogs();
			$result["head"]["message"] = getStatusCodeMessage( $result["head"]["status"] );
			break;
		case "fetchComingEvents":
			require_once 'events.php';
			$result = fetchComingEvents();
			$result["head"]["message"] = getStatusCodeMessage( $result["head"]["status"] );
			break;
		case "bookRoom":
			require_once 'resources.php';
			$result = bookRoom();
			$result["head"]["message"] = getStatusCodeMessage( $result["head"]["status"] );
			break;
		case "bookComponent":
			require_once 'resources.php';
			$result = bookComponent();
			$result["head"]["message"] = getStatusCodeMessage( $result["head"]["status"] );
			break;
		case "bookBook":
			require_once 'resources.php';
			$result = bookBook();
			$result["head"]["message"] = getStatusCodeMessage( $result["head"]["status"] );
			break;

	}
}

exit(json_encode($result));

?>