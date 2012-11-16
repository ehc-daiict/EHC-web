<?php

function getEventsFromDb($year, $month){
	$result = array("head" => array(), "body" => array() );
	$head = array("status" => "", "message" => "" );
	$body = array();
	$event = array("title" => "", "time" => "", "duration" => "", "venue" => "", "host" => "", "audience" => "", "registration" => "", "regLink" => "", "prerequisite" => "", "tools" => "", "desc" => "" );
	$query = "SELECT * FROM `events` WHERE `year` = '".mysql_real_escape_string($year)."'AND `month` = '".mysql_real_escape_string($month)."'";
	echo $query;
    if($query_run = mysql_query($query)) {
        $query_num_rows = mysql_num_rows($query_run);
        if($query_num_rows == 0) {
            $head["status"] = 404;
        }
        else {
        	for($i = 0; $i < $query_num_rows ; $i++){
        		$event["title"] = mysql_result($query_run, $i, 'Name');
        		$event["time"]= mysql_result($query_run, $i, 'Time');
        		$event["duration"] = mysql_result($query_run, $i, 'Duration');
        		$event["venue"] = mysql_result($query_run, $i, 'Venue');
        		$event["host"] = mysql_result($query_run, $i, 'Host');
        		$event["audience"] = mysql_result($query_run, $i, 'Target_Audience');
        		$event["registration"] = mysql_result($query_run, $i, 'Registration_Status');
        		$event["regLink"] = mysql_result($query_run, $i, 'Registration_Link');
        		$event["prerequisite"] = mysql_result($query_run, $i, 'Prerequisite');
        		$event["tools"] = mysql_result($query_run, $i, 'Tools_Needed');
        		$event["desc"] = mysql_result($query_run, $i, 'Description');

        		$body[$i] = $event;
        	}

    	    $head["status"] = 200;

        }
    }else {
    $head["status"] = 400;
    }

    $result["head"] = $head;
    $result["body"] = $body;
    return $result;
}

function fetchEvents(){
	$result = array("head" => array(), "body" => array() );
	$head = array("status" => "", "message" => "" );
	$body = array();

	if(isset($_GET['year']) && isset($_GET['month']) ) {
        $year = $_GET['year'];
        $month = $_GET['month'];
        if (!empty($year)  && !empty($month + 1)) {//this + 1 is very important
        	if($month < 12){
	            $result = getEventsFromDb($year, $month);
	            return $result;
	        }//else badRequest
        } //else badRequest
    }//else badRequest

    $head["status"] = 400;
    $result["head"] = $head;
    $result["body"] = $body;
    return $result;
}

?>