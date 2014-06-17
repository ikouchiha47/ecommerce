<?php
include('autoload.php');
try{
session_start();
}
catch(Exception $e){};
class Register {
  private $count=array();
  public $k=0;
  private $name,$email,$address,$pass;
  //private $tablename;
  function __construct($name='',$pass='',$email='',$address=''){
  $this->name=$name;
  $this->pass=$pass;
  $this->email=$email;
  $this->address=$address;
  //$this->tablename=$tablename;
  }

  function setCount($v){
    $this->count[$this->k++]=$v;
  }
  function getCount() {
    return $this->count;
  }
  function validatename($name,$len=100){
    if(preg_match('/^[\w{'.$len.',}\s]+$/', $name && strlen($name)<=$len && strlen($name)>=10))
       return true;
    else
       $this->setCount(0);
  }
  function validatePass($pass){
    if(preg_match('/^[a-zA-Z0-9\$\@\_]+$/', $pass)&& strlen($pass)>=6)
    	return true;
    else
    	$this->setCount(1);
  }
  function validateEmail($email){
    $b=filter_var($email,FILTER_VALIDATE_EMAIL);
    if($b)
    	return true;
    else	    
    	$this->setCount(2);
  }
  function validateAddr($address) {
    if(preg_match('/^([0-9]+)?[a-zA-Z\/\.\,\-\: ]|\s+$/',$address)&& strlen($address)>=10)
    	return true;
    else
    	$this->setCount(3);
  }
  
  function init_user($dbh,$tablename){
     //Encrypt $enc=new Encrypt($this->pass);
     $size=mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
     $options = [
     	    'cost' => 11,
     	    'salt' => mcrypt_create_iv($size, MCRYPT_DEV_URANDOM),
     	];
	$hash=password_hash($this->pass,PASSWORD_BCRYPT,$options);
      $sth=$dbh->prepare("insert into ".$tablename."(name,email,password,address,sesid) values (?,?,?,?,?)");
      $resp=$sth->execute(array($this->name,$this->email,$hash,$this->address,session_id()));
      if($resp)
         return true;
      else
         return false;
     
  }
  function checkAccount($dbh,$tablename){
      
      try{
        $sth=$dbh->prepare("select id,name from ".$tablename." where email=?");
        $sth->bindParam(1,$this->email,PDO::PARAM_STR);
        if($sth->execute()){
	if($sth->fetch(PDO::FETCH_ASSOC)){
		return true;
	}
	else return false;
	}
	else
		return false;
		}
	catch(Exception $e){ print_r($e->getMessage()); }
		}
}

if(isset($_POST['signup'])){
  $reg=new Register();
  $usrname=$_POST['usrname'];
  $usrpass=$_POST['usrpass'];
  $email=$_POST['email'] ;
  $address=$_POST['address'];
  
  $i=0;
  $array=array();
  
  $reg->validatename($usrname,40);
  $reg->validatePass($usrpass);
  $reg->validateEmail($email);
  $reg->validateAddr($address);
  foreach($reg->getCount() as $count)
  switch($count){
    case 0:
           $array[$i++]='invalid or too short name. use alphanumerics,_';
           break;
    case 1:
           $array[$i++]='invalid or too short password,use alphanumerics,_,@ ,$';
           break;
    case 2:
            $array[$i++]="invalid email address";
            break;
    case 3:
            $array[$i++]="invalid or too short address, use alphanumerics,-,_,:";
            break;
    default:
            $array[$i++]="undefined error";
               break;

          }
	  //print_r("  k".$reg->k);
	  if($reg->k==0){
	  $regg=new Register($usrname,$usrpass,$email,$address);
	  $dbh=(new NewCon('ecomm'))->getCon();
	  //$check=new Loginin($email,$usrpass);
	  //var_dump($regg->checkAccount($dbh,'users'));
	  if($regg->checkAccount($dbh,'users')===false){
	       $comit=$regg->init_user($dbh,'users');
	       if($comit===false){
	           $array[$i++]='DB Connection Error';
	              }
		else
		setcookie('sessionid',session_id());
	        }
		else
		$array[$i++]='Email Already Exists';
			              
		}
		

if($array!=NULL){
  $_SESSION['error']=json_encode($array);
  header('Location:./signup.php');
  //print_r($_SESSION['error']);
}
else
{
header('Location:./login.php?init=1');
}
}
?>