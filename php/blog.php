<?php
function getBlogsFromDb($year, $month){
    $result = array("head" => array(), "body" => array() );
    $head = array("status" => "", "message" => "" );
    $body = array();
    $blog = array("articleId" => "", "title" => "", "timeStamp" => "", "author" => "", "data" => "");
    $month = mysql_real_escape_string($month);
    $year = mysql_real_escape_string($year);
    $query = "SELECT * FROM `blogs` WHERE  YEAR(`timeStamp`) = '$year' AND MONTH(`timeStamp`) = '$month'  ";
    if($query_run = mysql_query($query)) {
        $query_num_rows = mysql_num_rows($query_run);
        if($query_num_rows == 0) {
            $head["status"] = 404;
        }
        else {
            for($i = 0; $i < $query_num_rows ; $i++){
                $blog["articleId"] = mysql_result($query_run, $i, 'articleId');
                $blog["title"] = mysql_result($query_run, $i, 'title');
                $blog["timeStamp"]= mysql_result($query_run, $i, 'timeStamp');
                $blog["author"] = mysql_result($query_run, $i, 'author');
                $blog["data"] = mysql_result($query_run, $i, 'data');

                $body[$i] = $blog;
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

function fetchBlogs(){
    $result = array("head" => array(), "body" => array() );
    $head = array("status" => "", "message" => "" );
    $body = array();

    if(isset($_POST['year']) && isset($_POST['month']) ) {
        $year = $_POST['year'];
        $month = $_POST['month'];
        if (!empty($year) ) {//no need to check empty on month
            if($month < 12){
                $result = getRecentBlogsFromDb($year, $month);
                return $result;
            }//else badRequest
        } //else badRequest
    }//else badRequest

    $head["status"] = 400;
    $result["head"] = $head;
    $result["body"] = $body;
    return $result;
}
function getRecentBlogsFromDb($year, $month){
	$result = array("head" => array(), "body" => array() );
	$head = array("status" => "", "message" => "" );
	$body = array();
	$blog = array("articleId" => "", "title" => "", "timeStamp" => "", "author" => "", "data" => "");
    $month = mysql_real_escape_string($month);
    $year = mysql_real_escape_string($year);
    
    //last three month
    if($month == 0){
	    $query = "SELECT * FROM `blogs` WHERE ( YEAR(`timeStamp`) = '$year' AND MONTH(`timeStamp`) = '$month' ) OR ( YEAR(`timeStamp`) = '".(string)($year-1)."'AND (MONTH(`timeStamp`) = '11' OR MONTH(`timeStamp`) =  '10') )";
    }else if($month == 1){
        $query = "SELECT * FROM `blogs` WHERE ( YEAR(`timeStamp`) = '$year' AND (MONTH(`timeStamp`) = '$month' OR MONTH(`timeStamp`) =  '".(string)($month-1)."' ) ) OR ( YEAR(`timeStamp`) = '".(string)($year-1)."'AND MONTH(`timeStamp`) = '11' )";
    }else{
        $query = "SELECT * FROM `blogs` WHERE YEAR(`timeStamp`) = '$year' AND ( MONTH(`timeStamp`) = '$month' OR MONTH(`timeStamp`) =  '".(string)($month-1)."' OR MONTH(`timeStamp`) =  '".(string)($month-2)."')";
    }
    if($query_run = mysql_query($query)) {
        $query_num_rows = mysql_num_rows($query_run);
        if($query_num_rows == 0) {
            $head["status"] = 404;
        }
        else {
        	for($i = 0; $i < $query_num_rows ; $i++){
        		$blog["articleId"] = mysql_result($query_run, $i, 'articleId');
                $blog["title"] = mysql_result($query_run, $i, 'title');
        		$blog["timeStamp"]= mysql_result($query_run, $i, 'timeStamp');
        		$blog["author"] = mysql_result($query_run, $i, 'author');
        		$blog["data"] = mysql_result($query_run, $i, 'data');

        		$body[$i] = $blog;
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

function fetchRecentBlogs(){
	$result = array("head" => array(), "body" => array() );
	$head = array("status" => "", "message" => "" );
	$body = array();

	if(isset($_POST['year']) && isset($_POST['month']) && !empty($year)) {
        $year = $_POST['year'];
        $month = $_POST['month'];
    } elseif(isset($_POST['year'])){
        if (!empty($_POST['year'])) {
            $year = $year = $_POST['year'];
        } else{
            $year = date('Y');
        }
        $month = date('m');
    } else {
        $year = date('Y');
        $month = date('m');
    }

    if($month < 12){
        $result = getRecentBlogsFromDb($year, $month);
        return $result;                
    }//else badRequest
    
    $head["status"] = 400;
    $result["head"] = $head;
    $result["body"] = $body;
    return $result;
}

?>