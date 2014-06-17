<?php
try{
session_start();
}
catch(Exception $e){}

include('autoload.php');

class AddProducts{

private $item,$price,$color,$quantity,$id;

function __construct($item='',$price='',$color='',$quantity=''){
$this->item=$item;
$this->price=$price;
$this->color=$color;
$this->quantity=$quantity;
}

function addProduct($dbh){
 $sth=$dbh->prepare("insert into products (item,price,color,quantity) values (?,?,?,?);");
 $resp=$sth->execute(array($this->item,$this->price,$this->color,$this->quantity));
 return $resp;
 }
 
function checkProduct($dbh){
 $sth=$dbh->prepare("select id,quantity from products where item=? and color=?");
 $sth->bindParam(1,$this->item,PDO::PARAM_STR);
 $sth->bindParam(2,$this->color,PDO::PARAM_STR);
 if($sth->execute()){
 	if($res=$sth->fetch(PDO::FETCH_ASSOC)){
	 $this->id=$res['id'];
	 return $res['quantity'];
	 }
	 else return false;
	 }
	else
	    return false;
   }
   
 function appendQuantity($dbh,$xquant){
 	//$nuquant=0;
 	$nquant=$xquant+($this->quantity);
	 $id=$this->id;
 	$sth=$dbh->prepare("update products set quantity=? where id=?");
	$resp=$sth->execute(array($nquant,$this->id));
	if($resp)
		return true;
	else
		return false;
   }

}

if(isset($_POST['addprod'])){
$item=$_POST['item'];
$price=$_POST['price'];
$color=$_POST['color'];
$quantity=$_POST['quantt'];

//validation required;

$array=array();
$i=0;

$addprod=new AddProducts($item,$price,$color,$quantity);
$dbh=(new NewCon('ecomm'))->getCon();
$pquant=$addprod->checkProduct($dbh);
var_dump($addprod);
var_dump($pquant);
if($pquant===false){
	if($addprod->addProduct($dbh))
		{echo "hello";}//header('Location:./addproduct.php');
	else
		$array[$i++]="DB Error";
	}
else
	{
		$array[$i++]="Product Already Exists,Quantity Appended";
		//check user opinion for append quantity needed;
		$addprod->appendQuantity($dbh,$pquant);
		
		
	}
	if($array!=NULL){
		$_SESSION['error']=json_encode($array);
		//header('Location:./addproduct.php');
		print_r($_SESSION['error']);
		}
		
	

}

?>
		