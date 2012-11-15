<?php

function loggedin()
{
    if(isset($_SESSION['user_id'])  &&  !empty($_SESSION['user_id']))
        return true;
    else
        return false;
}

function POSTuserfield($field)
{
    $query = "SELECT `$field` FROM `cg_users` WHERE `id`='".$_SESSION['user_id']."'";
    if($query_run=mysql_query($query))
    {
        if($query_result=mysql_result($query_run,0,$field))
        {
            return $query_result;
        }
    }
}

function login() {	
	if(isset($_POST['username']) && isset($_POST['password']) ) {
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        if (!empty($username)  && !empty($password)) {
            if(loggedin()){
                if($_SESSION['user_id'] == $username){
                    return 202;            
                } else {
                    logout();
                    return 401;
                }
            } else {
                $password_hash = md5($password);
                $query = "SELECT `username` FROM `users` WHERE `username` = '".mysql_real_escape_string($username)."'AND `password` = '".mysql_real_escape_string($password_hash)."'";
            
                if($query_run = mysql_query($query)) {
                    $query_num_rows = mysql_num_rows($query_run);
                    if($query_num_rows == 0) {
                        return 401;
                    }
                    else if($query_num_rows == 1) {
                        $user_id = mysql_result($query_run, 0, 'username');
                        $_SESSION['user_id'] = $user_id;
                        return 202;
                    }
                }
            }
        } else {
            return 400;
        }
    }
}
?>