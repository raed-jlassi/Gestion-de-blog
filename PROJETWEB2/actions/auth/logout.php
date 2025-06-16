<?php
session_start(); // Must start before destroying
$_SESSION = array();  // Clear all session data
session_destroy();
header("Location:http://localhost/app/page.php");
?>