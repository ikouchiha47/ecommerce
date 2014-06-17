<?php
include('autoload.php');
try{
    session_start();
 }
 catch(Exception $e){}

$dbh=(new NewCon('ecomm'))->getCon();
$array=array();
?>
<html>
<head>
	<link rel="stylesheet" href="./css/main.css" type="text/css"/>
</head>

<body>
      <?php include('header.php'); ?>
      <div id="main">
      <form method="post" action="Transaction.php">
      <table class="t1">
      <tr>
      <?php
		if(isset($_GET['id'])){
			$prid=filter_var($_GET['id'],FILTER_SANITIZE_STRING);
			$sprod=new ShowProducts($dbh);
			
			$array=json_decode($sprod->displayproduct($dbh,$prid));
			$cartdetails=$array;
			if($array!=NULL){
				$item=$array['item']; $id=$array['id']; 
				$price=$array['price']; $color=$array['color'];
			}
			
	?>
		<th><?php print_r($item) ?>
		    <input type="hidden" name="itemid" value="<?php echo $id; ?>"/></th>
	</tr>
	<tr>
		<td>Specs</td>
		<td><?php echo $color; ?> <!--<input type="hidden" name="color" value="<?php echo $color; ?>"/>--> </td>
	<tr>
		<td>Price</td>
		<td> <?php echo $price; ?> <input type="hidden" name="price" value="<?php echo $price; ?>"/></td>
	</tr>
	<tr>
		<td>Items Available</td>
		<td><?php $q=$res['quantity'];
		 	  if($q==0)
		 		$qshow="Outta Stock";
		 	  else
		 		$qshow=$q;
				
			 print_r($qshow);
			 ?>
			 <input type="hidden" name="quantity" value="<?php echo $qshow;?>"/>
			 </td>
	</tr>
	<tr>
		<td>No of pieces</td>
		<td><input type="text" name="piece"/></td>
	</tr>
	<tr>
		<td>Address</td>
		<td> <?php
				$addr='';
				if(isset($_COOKIE['addr']))
				{
				  $addr=$_COOKIE['addr'];
				  }
				else if(isset($_SESSION['addr'])){
				  $addr=$_SESSION['addr'];
				  }
			?>
			<input type="text" name="address" <?php if($addr!='') print_r('value="'.$addr.'"');?>/>
			</td>
	</tr>
	<tr>
		<td>Card No(online payament only)</td>
		<td><input type="text" name="cardno"/></td>
	</tr>
									 }
	<tr>
		<td>
			<?php
				if(!isset($_SESSION['login'])){
					printf("Register Or");
					$_SESSION['from']='buy.php?id='.$id;
					$tstmp = (new DateTime())->getTimestamp();
					$SESSION['id']=$tstmp;
					
					 
				}
			?>
			</td>
		
		<td>
		        <?php
			  if(isset($_SESSION['login'])){ ?>
			<input type="hidden" name="usrid" value="<?php print_r($_SESSION['id']); ?>"/>
			<input type="hidden" name="address" value="<?php print_r($_SESSION['addr']); ?>"/>
			<?php }
			     if(isset($_SESSION['cart'])) {
			        $cart=$_SESSION['cart']+1;}
				else $_SESSION['cart']=1;
				  
				  if(isset($_SESSION['cart_details'])){
				  $temp=json_decode($_SESSION['cart_details']);
				  $nuarray=array_merge((array)$cartdetails,(array)$temp);
				  $_SESSION['cart_details']=json_encode($nuarray);
				  }
				  else
					  $_SESSION['cart_details']=json_encode($cartdetails);
				  
				    ?>
			<input type="submit" name="buy" value="Coninue"/></td>
	</tr>
	</table>
      </form>
      </div> 
      <?php } ?> 
</body>
</html>


		
