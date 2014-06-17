<?php
session_start();
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="./css/main.css"/>
	</head>
	
	<body>
	<?php include('header.php'); ?>
	<div id="main">
	     <form method="post" action="Register.php"/>
	     <table class="t1">
	     	<tr>
	   	    <th class="f" colspan=2>Signup</th>
		</tr>
		<tr>
	   	    <td>Email</td>
	   	    <td><input type="text" name="email"/></td>
		</tr>
		<tr>
		    <td>Name</td>
	    	    <td><input type="text" name="usrname"/></td>
		</tr>
		<tr>
		    <td>Password</td>
	    	    <td><input type="password" name="usrpass"/></td>
		</tr>
		<tr>
		    <td>Shipping Address</td>
	   	    <td><textarea name="address" rows="8" cols="18"></textarea></td>
		</tr>
		<tr>
	   	     <td colspan=2><input type="submit" name="signup" value="SignUp"/></td>
		</tr>
	    </table>
	    </form>
	 <div id="bottom">
	      <?php
	      	   
	           if(isset($_SESSION["error"])){
				print_r("<ul>");
				$array=json_decode($_SESSION['error']);
				foreach($array as $elem){
						   print_r("<li>".$elem."</li>");
					}
				print_r("</ul>");
				
				unset($_SESSION['error']); 
				$_SESSION['error']=NULL;
		   }
	      
	      ?>
	  </div>
	</div>
</body>
</html>
 
