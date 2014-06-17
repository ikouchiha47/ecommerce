<!DOCTYPE>
<?php
session_start();
include('autoload.php');
	?>
<html>
	<head>
	<link type="text/css" href="./css/main.css" rel="stylesheet"/>
	</head>
	
	<body>
	<?php include('header.php'); ?>      
	       <div id="main">
	       		<table class="t1" cellpadding=3>
			       <tr>
			       		<th colspan=5>Products</th>
				</tr>
				<tr>
					<td>Product Name</td>
					<td>Price</td>
					<td>Color</td>
					<td>Available Pieces</td>
				</tr>
				
				<?php
					$dbh=(new NewCon('ecomm'))->getCon();
					$sprod=new ShowProducts($dbh);
					$limit=10;
					$_SESSION['limit']=$limit;
					$pages=($sprod->getCount())/$limit;
		
				        $sprod->display($dbh,0,$limit);
			?>
			
		</table>
		<?php 
			for($i=0;$i<$pages;$i++){
				print_r("<span><a href='./Showproducts.php?p=".$i."'>".($i+1)."</a></span>");
				}
		?>
		
				
       </div>
       
       
       </script>
	</body>
</html>


