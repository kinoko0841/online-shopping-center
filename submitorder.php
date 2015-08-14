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
$ba=$_POST['ba'];
$sa=$_POST['sa'];
$total=$_POST['total'];
$t=date('Y-m-d');
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
mysql_query("INSERT INTO `order`(`userid`, `totalcost`, `billingaddress`, `shippingaddress`, `orderdate`) 
VALUES ('$userid','$total','$ba','$sa','$t')");
$res2=mysql_query("select max(`orderid`) as max from `order`");
$orderid= mysql_fetch_array($res2);
$sql1="select * from shoppingcart where userid='$userid'";
$res1=mysql_query($sql1);
while($row1 = mysql_fetch_assoc($res1)){
	mysql_query("INSERT INTO `orderdetail`(`orderid`, `productid`, `productprice`, `productquantity`) 
	VALUES ('$orderid[max]','$row1[productid]','$row1[productprice]','$row1[productquantity]')");
}
mysql_query("DELETE FROM `shoppingcart` WHERE `shoppingcart`.`userid`='$userid'");
echo "order successful!";
?>