<?php
/* Report all errors except E_NOTICE */
error_reporting(E_ALL ^ E_NOTICE ^E_DEPRECATED);
//check if timeout
session_start();
$t=time();
if($t-$_SESSION["time"]>2000){
echo "<script>alert('logout by system!')</script>";
//require"logput.php";
session_destroy();
}?>
<?php 
$username=$_SESSION["adminname"];
$con=mysql_connect("cs-server.usc.edu:4844","root","");
if (!$con)
 {
 die('Could not connect: ' . mysql_error());
 }

mysql_select_db("user", $con);

$con=mysql_connect("cs-server.usc.edu:4844","root","");
if (!$con)
 {
 die('Could not connect: ' . mysql_error());
 }
 mysql_select_db("user", $con);
$sql="select * from user where username='$username'";
$res=mysql_query($sql);
$row = mysql_fetch_assoc($res);
$userid=$row[userindex];
mysql_query("DELETE FROM `shoppingcart` WHERE `userid`='$userid'");
echo "Shopping Cart is Empty!";
?>