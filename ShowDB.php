<html>
<head>
<link rel="stylesheet" type="text/css" href="./css/main.css"/>
</head>
<body>
<h2>DataBase Entries</h2>

<?php
include('autoload.php');
?>
<div id="main">
<?php
$db=new SQLite3('./database/ecomm.db');
$temp=$temp1=$ct=$db;
$tablesquery = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name != 'sqlite_sequence' ;");
    while ($table = $tablesquery->fetchArray(SQLITE3_ASSOC)) {
	echo "<table class='t1'><tr><td><b>";
	print_r($table['name']);
	echo "</b></td></tr>";
	echo "<tr>";
	$result = $temp->query("PRAGMA table_info(" . $table['name'] . ")");
	while($res=$result->fetchArray(SQLITE3_ASSOC)){
		//print_r($res);
		echo "<td>";
		foreach($res as $key=>$val){
		 if(!preg_match('/^[0-9]+$/',$val) && $val !='')
		 print_r($val." ");}
		 echo "</td>";
		 
	}
	echo "</tr><tr>";
	$result1=$temp1->query("select * from ".$table['name']);
		while($res1=$result1->fetchArray(SQLITE3_ASSOC)){
		        
		 	foreach($res1 as $key1=>$val1){
			 $vall=(strlen($val)>30) ? $val1 : substr($val1,0,15);
			 print_r("<td>".$vall."</td>");}
			 
		}
	print_r("</tr></table>");
	
		
    }


?>
</div>
</body>
</html>		
