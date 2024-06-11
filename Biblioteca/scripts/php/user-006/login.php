<?php
function login ( $usr, $psw ) {
    echo "login";
}

function regis ( $mail ) {
    echo "regis";
}




if ( isset ( $_POST [ 'mail'] ) ) {
    if ( isset ( $_POST [ 'pass' ] ) ) 
    { login ( $_POST [ 'mail'], $_POST [ 'pass' ] ); } 
    else 
    { regis ( $_POST [ 'mail' ] ); }
}
?>