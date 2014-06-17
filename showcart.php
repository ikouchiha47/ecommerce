<?php
include('autoload.php')
try{
session_start();
}
catch(Exception $e){}

if(isset($_SESSION['id']) && $_SESSION['cart']){{
if(isset($_SESSION['cart_deails'])){
$array=array();

$array=json_decode($_SESSION['cart_details']);
foreach($array as $key=>$value){
print_r($array);
}
//use a buy option for each item, for each buy make an object NewCon and Transaction and call Transact::transact.
// for each transaction decrease $_SESSION['cart'] by 1;

//HAPPYCODING
?>


		