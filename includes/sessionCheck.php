<?php 
session_start();
//login logic
if (!isset($_SESSION['loggedin'])) {
    $redirLocation = "Location: /login.php";
    header($redirLocation);
} 
?>