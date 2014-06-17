<?php
session_start();
$array=array();
?>


<html>
<head>
<link rel="stylesheet" type="text/css" href="./css/main.css"/>
</head>
	<body>
	<?php include('header.php'); ?>
	<div id="main">
		<form method="post" action="AddProducts.php">
		<table class="t1">
			<tr>
				<th colspan=2>Enter Product Details</th>	
			</tr>
			
			<tr>
				<td>Product Name </td>
				<td><input type="text" name="item"/></td>
			</tr>
			
			<tr>
				<td>Price</td>
				<td><input type="text" name="price"/></td>
			</tr>
			<tr>
				<td>Color</td>
				<td><input type="text" name="color"/></td>
			</tr>
			<tr>
				<td>Number of pieces</td>
				<td><input type="text" name="quantt"/></td>
			</tr>
			<tr class="trborder">
				<td></td>
				<td><input type="submit" name="addprod" value="Add"/></td>
			</tr>
		</table>
		</form>
		
		<div id="bottom">
			<?php if(isset($_SESSION['error'])){
					print_r("<ul>");
					foreach($array as $err)
						print_r("<li>".$err."</li>");
					print_r("</ul>");
					$_SESSION['error']=NULL;
					unset($_SESSION['error']);
				}
			?>
			</div>
		</div>
	</body>
</html>
		
