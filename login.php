<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="./css/main.css"/>
	</head>
<body>
<?php
 if(isset($_GET['init'])){
    $disp=filter_var($_GET['init'],FILTER_SANITIZE_NUMBER_INT);
 if($disp==1)
    print_r("<h3> Registration Successfull. Login to continue</h3>");
}
$array=array();
session_start();

include('header.php');
?>

 <div id="main">
	     <form method="post" action="Loginin.php"/>
	     <table class="t1">
	     	<tr>
	   	    <th colspan=2>Login</th>
		</tr>
		<tr>
	   	    <td>Email</td>
	   	    <td><input type="text" name="email"/></td>
		</tr>
		<tr>
		    <td>Password</td>
	    	    <td><input type="password" name="usrpass"/></td>
		</tr>
		<tr>
	   	     <td colspan=2><input type="submit" name="login" value="LogIn"/></td>
	   	     <?php if(!isset($_SESSION['from']))
                     $_SESSION['from']='index.php';
              ?>

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