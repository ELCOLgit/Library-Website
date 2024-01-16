<?php 
//Start or resume the session
session_start();

//Unset all session variables, destroying the current session data
session_unset();

//Destory the session
session_destroy();

//Redirect the user to login page
header("Location: Login.php");

?>
