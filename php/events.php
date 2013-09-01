<?php

function getEventsFromDb($year, $month){
	$result = array("head" => array(), "body" => array() );
	$head = array("status" => "", "message" => "" );
	$body = array();
	$event = array("eventId" => "", "eventTitle" => "", "time" => "", "duration" => "", "venue" => "", "host" => "", "audience" => "", "registration" => "", "regLink" => "", "prerequisite" => "", "tools" => "", "desc" => "" );
	$query = "SELECT * FROM `events` WHERE YEAR(`timeStamp`) = '".mysql_real_escape_string($year)."'AND MONTH(`timeStamp`) = '".mysql_real_escape_string($month)."'";
    if($query_run = mysql_query($query)) {
        $query_num_rows = mysql_num_rows($query_run);
        if($query_num_rows == 0) {
            $head["status"] = 404;
        }
        else {
        	for($i = 0; $i < $query_num_rows ; $i++){
                $event["eventId"] = mysql_result($query_run, $i, 'eventId');
        		$event["eventTitle"] = mysql_result($query_run, $i, 'eventTitle');
        		$event["timeStamp"]= mysql_result($query_run, $i, 'timeStamp');
        		$event["duration"] = mysql_result($query_run, $i, 'duration');
        		$event["venue"] = mysql_result($query_run, $i, 'venue');
        		$event["host"] = mysql_result($query_run, $i, 'host');
        		$event["targetAudience"] = mysql_result($query_run, $i, 'targetAudience');
        		$event["registration"] = mysql_result($query_run, $i, 'registrationStatus');
        		$event["registrationLink"] = mysql_result($query_run, $i, 'registrationLink');
        		$event["prerequisite"] = mysql_result($query_run, $i, 'prerequisite');
        		$event["toolsNeeded"] = mysql_result($query_run, $i, 'toolsNeeded');
        		$event["description"] = mysql_result($query_run, $i, 'description');

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

	if(isset($_POST['year']) && isset($_POST['month']) ) {
        $year = $_POST['year'];
        $month = $_POST['month'];
        if (!empty($year) ) {//no need to check empty on month
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

function getComingEventsFromDb($year, $month){
    $result = array("head" => array(), "body" => array() );
    $head = array("status" => "", "message" => "" );
    $body = array();
    $event = array("eventId" => "", "eventTitle" => "", "time" => "", "venue" => "", "desc" => "" , "year" => "", "month" => "");
    $query = "SELECT events.eventId,eventTitle,timeStamp,venue,shortDescription,YEAR(timeStamp) as Year, MONTH(timeStamp) as Month FROM `events` WHERE YEAR(`timeStamp`) >= '".mysql_real_escape_string($year)."'AND MONTH(`timeStamp`) >= '".mysql_real_escape_string($month)."'";
    if($query_run = mysql_query($query)) {
        $query_num_rows = mysql_num_rows($query_run);
        if($query_num_rows == 0) {
            $head["status"] = 404;
        }
        else {
            for($i = 0; $i < $query_num_rows ; $i++){
                $event["eventId"] = mysql_result($query_run, $i, 'eventId');
                $event["eventTitle"] = mysql_result($query_run, $i, 'eventTitle');
                $event["timeStamp"]= mysql_result($query_run, $i, 'timeStamp');
                $event["venue"] = mysql_result($query_run, $i, 'Venue');
                $event["shortDescription"] = mysql_result($query_run, $i, 'shortDescription');
                $event["year"] = mysql_result($query_run, $i, 'Year');
                $event["month"] = mysql_result($query_run, $i, 'Month');

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

function fetchComingEvents(){
    $result = array("head" => array(), "body" => array() );
    $head = array("status" => "", "message" => "" );
    $body = array();
    if(isset($_POST['year']) && isset($_POST['month']) ) {
        $year = $_POST['year'];
        $month = $_POST['month'];
        if (!empty($year) ) {//no need to check empty on month
            if($month < 12){
                $result = getComingEventsFromDb($year, $month);
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