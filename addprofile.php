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
$con=mysql_connect("cs-server.usc.edu:4844","root","");
if (!$con)
 {
 die('Could not connect: ' . mysql_error());
 }

$username=$_POST["username"];
$password=$_POST["password"];
$usertype=$_POST["usertype"];
$lastname=$_POST["lastname"];
$firstname=$_POST["firstname"];
$age=$_POST["age"];
$telephone=$_POST["telephone"];
$email=$_POST["email"];
mysql_query("INSERT INTO `user`.`user`(`username`, `password`, `usertype`, `lastname`, `firstname`, `age`, `telephone`, `email`) 
VALUES ('$username','$password','$usertype','$lastname','$firstname','$age','$telephone','$email')");

?>