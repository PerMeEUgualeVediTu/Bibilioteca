<?php
function wrap ( $link = "" ) {
    if ( isset($_GET['SESSION_TOKEN']) ) {
	    return $link . "?SESSION_TOKEN=" . $_GET['SESSION_TOKEN']; 
    }
    return $link;
}

function get_token () {
    $TOKEN = NULL;
    if ( isset($_COOKIE['coockie_usage']) && isset($_COOKIE['SESSION_TOKEN']) ) 
	{ $TOKEN = $_COOKIE['SESSION_TOKEN']; 
	} elseif ( isset($_GET['SESSION_TOKEN']) ) 
	{ $TOKEN = $_GET['SESSION_TOKEN']; }

    if ( isset($_COOKIE['coockie_usage']) && $TOKEN != NULL ) 
    { setcookie ( "SESSION_TOKEN", $TOKEN, [
        'path' => '/',
        'samesite' => 'Lax',
    ]); }
    
    return $TOKEN;
}
?>