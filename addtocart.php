<?php
/* Report all errors except E_NOTICE */
error_reporting(E_ALL ^ E_NOTICE ^E_DEPRECATED);
//check if timeout
session_start();
$t=time();
if($t-$_SESSION["time"]>2000){
echo "<script>alert('logout by system!')</script>";
//echo "<script><script>";
session_destroy();
}?>
<?php 
//echo "hello0";
/* Report all errors except E_NOTICE */
error_reporting(E_ALL ^ E_NOTICE ^E_DEPRECATED);
$productid=$_POST[productid];
$quantity=$_POST[quantity];
$username=$_SESSION["adminname"];
$con=mysql_connect("cs-server.usc.edu:4844","root","");
if (!$con)
 {
 die('Could not connect: ' . mysql_error());
 }

mysql_select_db("user", $con);
$sql="select * from specialsales where productid='$productid'";
$res=mysql_query($sql);
$row=mysql_fetch_assoc($res);
$num=mysql_num_rows($res);
if($num!=0){
	$productprice=$row[salesprice];
}
else {
	$sql="select * from product where productid='$productid'";
	$res=mysql_query($sql);
	$row=mysql_fetch_assoc($res);
	$productprice=$row[productprice];
	}
$sql1="select * from user where username='$username'";
$res1=mysql_query($sql1);
$row1 = mysql_fetch_assoc($res1);
$userid=$row1["userindex"];
$d=date('Y-m-d');
//echo "<br>".$userid.$d.$productprice;
mysql_query("INSERT INTO `user`.`shoppingcart` (`productid`, `productquantity`, `productprice`, `userid`, `orderdate`) VALUES ('$productid','$quantity','$productprice','$userid', '$d')");
//$orderid="select last(orderid) from user";
//mysql_query("INSERT INTO `user`.`orderdetail` (`orderid`, `productid`,`productprice`,`productquantity`) VALUES ('$orderid', '$productid','$productprice','$quantity')");
?>