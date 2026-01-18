<?php
session_start();

session_unset();  //removes all the session variables

session_destroy();  //destroys the session

echo "You are logged out";
?>