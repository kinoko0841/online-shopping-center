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
$userindex=$_POST["userindex"];
$username=$_POST["username"];
$password=$_POST["password"];
$usertype=$_POST["usertype"];
$lastname=$_POST["lastname"];
$firstname=$_POST["firstname"];
$age=$_POST["age"];
$telephone=$_POST["telephone"];
$email=$_POST["email"];
$con=mysql_connect("cs-server.usc.edu:4844","root","");
if (!$con)
 {
 die('Could not connect: ' . mysql_error());
 }

mysql_select_db("user", $con);
mysql_query("UPDATE `user` SET `username`='$username',`password`='$password',
`usertype`='$usertype',`lastname`='$lastname',`firstname`='$firstname',
`age`='$age',`telephone`='$telephone',`email`='$email' WHERE `userindex`='$userindex'");
echo "change successful!";
?>