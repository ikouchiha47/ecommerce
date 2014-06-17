<?php
//session_start();
 include('autoload.php');
 try{
 //$db=new SQLite3('./database/ecomm.db');
 $dbh=(new NewCon('ecomm'))->getCon();
 //$qth=$dbh->exec("drop table users");
 //$rth=$dbh->exec("drop table products");
 //$tth=$dbh->exec('drop table transactions');
 $sth=$dbh->exec('create table if not exists users (id INTEGER PRIMARY KEY AUTOINCREMENT,
 			name STRING (200),
			email STRING (200),
			password STRING (200),
			address TEXT, 
			sesid STRING (100));');
			

 $pth=$dbh->exec('create table if not exists products(
 			id INTEGER PRIMARY KEY AUTOINCREMENT,
	                item STRING (200),
			price NUMBER (11),
			color STRING (10),
			quantity INTEGER (11));');

 $qth=$dbh->exec('create table if not exists transactions(
 			 id INTEGER PRIMARY KEY AUTOINCREMENT,
			 itmid INTEGER(11),
			 usrid INTEGER(11),
			 address TEXT,
			 cardno STRING(16),
			 amount NUMBER(11),
			 time TEXT ) ;');
			 //print_r( $dbh->errorInfo());
			 var_dump($qth);	    
 }
catch(Exception $e){
  print($e->getMessage());
}

?>
