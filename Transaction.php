<?php
try{
session_start();
}
catch(Exception $e){}

include('autoload.php');

class Transaction{

private $itmid,$usrid,$addr,$cardno,$amount;

 function __construct($itmid,$usrid,$addr,$card='',$amt){
 	$this->itmid=$itmid;
	$this->usrid=$usrid;
	$this->addr=$addr;
	$this->cardno=$card;
	$this->amount=$amt;
}

 function transact($dbh){
 	$sth=$dbh->prepare("insert into transactions (itmid,usrid,address,cardno,ammount,date) values(?,?,?,?,?,?)");
	$k=$sth->execute(array($this->itmid,$this->usrid,$this->addr,$this->cardno,$this->amount,time()));
	return $k;
}
}



if(isset($_POST['buy'])){
	$array=array();
	$i=0;
	//validation of empty input fields required
	$itmid=$_POST['itemid'];
	$price=$_POST['price'];
	
	$pieces=$_POST['piece'];
	$amt=$price*$pieces;
	
	$cardno=$_POST['cardno'];
	$addr=$_POST['addr'];
	$usrid=$_POST['usrid'];
	
	$dbh=(new NewCon('ecomm'))->getCon();
	$pattern='/^(?:4[0-9]{12}(?:[0-9]{3})? |  5[1-5][0-9]{14} |  3[47][0-9]{13} | 3(?:0[0-5]|[68][0-9])[0-9]{11} | 6(?:011|5[0-9]{2})[0-9]{12} | (?:2131|1800|35\d{3})\d{11})$/';
	if($cardno!=''){
	 $resp=preg_match($pattern,$cardno);
	 if($resp===true){
	  $assert=Verhoeff::validate($cardno);
	 }
	 else
	  $array[$i++]="invalid card number";
	 }
	 
	 if($assert === true && $array!=NULL)
         	{
		 
		 $trans=new Transaction($itmid,$usrid,$addr,$card,$amt);
		 $resp1=true;
		 }
	else
	       { 
	            if($cardno==''){
	        		$trans=new Transaction($itmid,$usrid,$addr,'xxxx-xxxx-xxxx',$amt);
				}
		 if($assert !== true)
		      $array[$i++]="invalid card number";
		}
	if($resp1===true){
		$resp2=$trans->transact($dbh);
		if($resp2===true){
		$sth=$dbh->prepare("update products set quantity=? where id=?");
		$resp3=$sth->execute(array($quantity-$pieces,$itemid));
		if($resp3===true)
		header('Location:./thankyou.php');
		else
		print_r("error in transaction");
		}
	}
	
	

}
?>

		