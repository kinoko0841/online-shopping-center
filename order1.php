<?php 
/* Report all errors except E_NOTICE */
error_reporting(E_ALL ^ E_NOTICE ^E_DEPRECATED);
//check if timeout
session_start();
$t=time();
if($t-$_SESSION["time"]>200){
echo "<script>alert('logout by system!')</script>";
//require"logput.php";
session_destroy();
}
?>
<head>
<script type="text/javascript" src="jquery-1.11.1.js">
</script>

<?php 
$orderid=$_POST["orderid"];
//echo $orderid;
$con=mysql_connect("cs-server.usc.edu:4844","root","");
if (!$con)
 {
 die('Could not connect: ' . mysql_error());
 }

mysql_select_db("user", $con);
		echo "<table border='1'>";
		$sql21="SELECT * FROM `order` WHERE orderid='$orderid'";
		$res21=mysql_query($sql21);
		$row21 = mysql_fetch_assoc($res21);
		echo "<tr><td colspan='3'>order date:$row21[orderdate]</td></tr>";
 		echo "<tr><td colspan='3'>billing address:$row21[billingaddress]</td></tr>";
		echo "<tr><td colspan='3'>shipping address:$row21[shippingaddress]</td></tr>";
		echo "<tr><td colspan='3'>Total Cost:$row21[totalcost]</td></tr>";
		echo "<th>productid</th><th>productprice</th><th>productquantity</th>";
		$sql3="select * from orderdetail WHERE orderid='$orderid'";
		$res3=mysql_query($sql3);
		while($row3 = mysql_fetch_assoc($res3)){
		echo "<tr>";
		$sql22="SELECT * FROM `product` WHERE productid='$row3[productid]'";
		$res22=mysql_query($sql22);
		$row22 = mysql_fetch_assoc($res22);
		echo "<td>$row22[productname]</td>";
		echo "<td>$row3[productprice]</td>";
		echo "<td>$row3[productquantity]</td>"; 
		echo "</tr>";
		}
	echo "</table>";
	echo "<br>";

?>