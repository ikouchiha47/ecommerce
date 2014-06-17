<html>
<body>
<h2>"Regular Expression Tester"</h2>
<form method="post" action="RxTester.php">
<table>
<tr>
<td>
Expression
</td>
<td>
<input type="text" name="expr" value="<?php if(isset($_SESSION['regular'])) echo $_SESSION['regular']; unset($_SESSION);?>"/></td>
</tr>
<tr>
<td> String </td>
<td>
<input type="text" name="string"/></td>
</tr>
<tr>
<td>
<input type="submit" name="test" value="Test"/>
</td>
</tr>
</table>
</form>

<?php
  if(isset($_POST['test'])){
    $expr=$_POST['expr'];
    $str=$_POST['string'];
    if($expr !=NULL && $expr !=" " && $str !=" "){
      $resp=preg_match($expr,$str);
      $_SESSION['regular']=$expr;
      print_r($resp);
    }
  }
?>
