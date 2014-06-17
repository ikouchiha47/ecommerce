<?php
session_start();
if(isset($_SESSION)){
foreach ($_SESSION as $key=>$sess){
$_SESSION[$key]=NULL;
unset($_SESSION[$key]);

}}
header('Location:./index.php');
?>

		