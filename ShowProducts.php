<?php
if(!isset($_SESSION))session_start();
include('autoload.php');

class ShowProducts{

 private $count=0;
 
 function __construct($dbh){
 	$this->count=$dbh->exec("select count(*) from products");
 }
 
 public function getCount(){
   	return $this->count;
   }   

function display($dbh,$start=0,$limit=5){ 	    	  	   	  	
 $sth=$dbh->prepare("select * from products limit ".$start.",".$limit);
 $sth->execute();
 while($res=$sth->fetch(PDO::FETCH_ASSOC)){
 print_r("<tr>");
 print_r("<td>".$res['item']."</td>");
 print_r("<td>".$res['price']."</td>");
 print_r("<td>".$res['color']."</td>");
 $q=$res['quantity'];
 if($q==0)
 $qshow="Outta Stock";
 else
 $qshow=$q;
 print_r("<td>".$qshow."</td>");
 print_r("<td><a href='./buy.php?id=".$res['id']."'>Buy</a></td></tr>");
 }
}

function displayproduct($dbh,$id){
$pth=$sth->prepare("select * from products where id=?");
$pth->bindParam(1,$id,PDO::PARAM_INT);
if($pth->execute()){
	if($res=$pth->fetch(PDO::FETCH_ASSOC))
	return json_encode($res);
	else return false;
}
else return false;
} 
}

if(isset($_GET['p']))
	$page=$_GET['p'];
else 
	$page=0;

if(isset($_SESSION['limit']))
	$limit=$_SESSION['limit'];
else
	$limit=5;
	
if($page!=0 && $limit!=0){
$dbh=(new NewCon('ecomm'))->getCon();
$sprod=new ShowProducts($dbh);
$sprod->display($dbh,$page-1,$limit);
}
?>

		