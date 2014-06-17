<?php
try{
session_start();
}
catch(Exception $e){}
include('autoload.php');

class Loginin{
  private $email,$pass;
  private $name,$address,$sesid,$id;
  
  function __construct($email='',$pass=''){
    $this->email=$email;
    $this->pass=$pass;
  }
  function checkAccount($dbh,$tablename){
    $conf=false;
    try{
      $sth=$dbh->prepare("select id,name,email,password,address,sesid from ".$tablename." where email=? ");
      $sth->bindParam(1,$this->email,PDO::PARAM_STR);
      //$sth->bindParam(2,$this->pass,PDO::PARAM_STR);
      if($sth->execute()){
         $res=$sth->fetch( PDO::FETCH_ASSOC);
	 if(password_verify($this->pass,$res['password'])){
         $this->name=$res['name'];
         $this->address=$res['address'];
         $this->sesid=$res['sesid'];
         $this->id=$res['id'];
         $conf=true;
	 }
       }
     }
     catch(Exception $e){
       print_r($e->getMessage());

     }
     finally{
       return $conf;
     }

  }
   public function getEmail(){
     return $this->email;
   }
   public function getAddr(){
     return $this->address;
   }
   public function getName(){
     return $this->name;
   }
   public function getSessID(){
     return $this->sesid;
   }
   public function getId(){
     return $this->id;
   }
   function update_sesID($sessionid,$dbh,$id,$tablename){
     $sth=$dbh->prepare("update ".$tablename." set sesid=:sesid where id=:id");
     $sth->execute(array(":sesid"=>$sessionid ,":id"=>$id ));
   }
 }


 if(isset($_POST['login'])){
 
  $email=$_POST['email'];
  $pass=$_POST['usrpass'];
  
  $i=0;
  $array=array();
  
  $validator=new Register($email,$pass);
  $validator->validateEmail($email);
  $validator->validatePass($pass);
    
  foreach($validator->getCount() as $count){
  switch($count){
    case 0:
         $array[$i++]="invalid email address";
         break;
    case 1:
         $array[$i++]="invalid or too short password";
         break;
    default:
        break;
    }
  }
    
    if($validator->k==0){
       $login=new Loginin($email,$pass);
       
       $dbh=(new NewCon('ecomm'))->getCon();
       $resp=$login->checkAccount($dbh,'users');
       if($resp===false)
	$array[$i++]="Invalid Combination";
      }

    if($array !=NULL){
      $_SESSION['error']=json_encode($array);
      header("Location:./login.php");
      //print_r($_SESSION['error']);
    }
    else
    {
      $seemail=$login->getEmail();
      $sename=$login->getName();
      $seaddr=$login->getAddr();
      $sesid=$login->getSessId();
      $id=$login->getId();
      if($sessid!=$_COOKIE['sessionid']){
        $_SESSION['report']=true;
      }
      session_regenerate_id();
        $_SESSION['login']=true;
        $_SESSION['email']= $seemail;
        $_SESSION['name']=$sename;
        $_SESSION['addr']=$seaddr;
        $_SESSION['id']=$id;
	setcookie('addr',$seaddr);
        $login->update_sesID(session_id(),$dbh,$id,'users');
        $url=$_SESSION['from'];
        unset($_SESSION['from']);
        $_SESSION['from']=NULL;
        header('Location:./'.$url);
       }
           
  }
?>
