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
}
?>
<head>
<script type="text/javascript" src="jquery-1.11.1.js">
</script>


<?php
/* Report all errors except E_NOTICE */
error_reporting(E_ALL ^ E_NOTICE ^E_DEPRECATED);
$category=$_POST["category"];
$con=mysql_connect("cs-server.usc.edu:4844","root","");
if (!$con)
 {
 die('Could not connect: ' . mysql_error());
 }

mysql_select_db("user", $con);
if($_POST["startdate"]==""){$startdate="";}
if($_POST["startdate"]==1){$startdate="2014-07-01";}
if($_POST["startdate"]==2){$startdate="2014-07-10";}
if($_POST["startdate"]==3){$startdate="2014-07-20";}
if($_POST["enddate"]==""){$enddate="";}
if($_POST["enddate"]==1){$enddate="2014-07-10";}
if($_POST["enddate"]==2){$enddate="2014-07-20";}
if($_POST["enddate"]==3){$enddate="2014-08-01";}
$productcategory=$_POST["productcategory"];
$sales=$_POST["sales"];
$product=$_POST["product"];

$sql="SELECT `orderdetailid` FROM `orderdetail`";
$sql1="SELECT `orderdetailid` FROM `orderdetail` WHERE `orderid` IN (SELECT `orderid` FROM `order` WHERE `orderdate`>='$startdate' AND `orderdate`<='$enddate')";
$sql11="`orderid` IN (SELECT `orderid` FROM `order` WHERE `orderdate`>='$startdate' AND `orderdate`<='$enddate')";
$sql2="SELECT `orderdetailid` FROM `orderdetail` WHERE `productid`IN (SELECT `productid` FROM `product` WHERE `productname`='$sales') AND 
`productprice`IN (SELECT `salesprice` FROM `specialsales` WHERE (SELECT `productid` FROM `product` WHERE `productname`='$sales'))";
$sql22="`productid`IN (SELECT `productid` FROM `product` WHERE `productname`='$sales') AND 
`productprice`IN (SELECT `salesprice` FROM `specialsales` WHERE (SELECT `productid` FROM `product` WHERE `productname`='$sales'))";
$sql3="SELECT `orderdetailid` FROM `orderdetail` WHERE `productid`=(SELECT `productid` FROM `product` WHERE `productname`='$product')";
$sql33="`productid`=(SELECT `productid` FROM `product` WHERE `productname`='$product')";
$sql4="SELECT `orderdetailid` FROM `orderdetail` WHERE `productid`IN (SELECT `productid` FROM `product` WHERE `productcategoryid`='$productcategory')";
$sql44="`productid`IN (SELECT `productid` FROM `product` WHERE `productcategoryid`='$productcategory')";
$datecate=$sql1."AND".$sql44;

//Scheme to write sql script
if($startdate!=""||$productcategory!=""||$sales!=""||$product!=""){
	//echo "okgood";
	$sql.=" WHERE ";
}
$where='';
if($startdate!=""){
	if($where!=""){
		$where.=" AND ";
	}
	$where.=$sql11;
}
if($productcategory!=""){
	if($where!=""){
		$where.=" AND ";
	}
	$where.=$sql44;
}
if($sales!=""){
	if($where!=""){
		$where.=" AND ";
	}
	$where.=$sql22;
}
if($product!=""){
	if($where!=""){
		$where.=" AND ";
	}
	$where.=$sql33;
}
$sql.=$where;
$res=mysql_query($sql);
//$res2=mysql_query($sql2);
//$res3=mysql_query($sql3);
//$res4=mysql_query($sql4);
echo"<table>";
echo "<tr><th>Product</th><th>Price</th><th>Quantity</th><th>Orderdate</th><th>User</th></tr>";
while($row=mysql_fetch_assoc($res)){
echo "<tr>";
$sqla="SELECT `productname` FROM `product` WHERE `productid`=(SELECT `productid` FROM `orderdetail` WHERE `orderdetailid`='$row[orderdetailid]')";
$resa=mysql_query("$sqla");
$rowa=mysql_fetch_assoc($resa);
echo "<td>$rowa[productname]</td>";
$sqlb="SELECT `productprice` FROM `orderdetail` WHERE `orderdetailid`='$row[orderdetailid]'";
$resb=mysql_query("$sqlb");
$rowb=mysql_fetch_assoc($resb);
echo "<td>$rowb[productprice]</td>";
$sqlc="SELECT `productquantity` FROM `orderdetail` WHERE `orderdetailid`='$row[orderdetailid]'";
$resc=mysql_query("$sqlc");
$rowc=mysql_fetch_assoc($resc);
echo "<td>$rowc[productquantity]</td>";
$sqld="SELECT `orderdate` FROM `order` WHERE `orderid`=(SELECT `orderid` FROM `orderdetail` WHERE `orderdetailid`='$row[orderdetailid]')";
$resd=mysql_query("$sqld");
$rowd=mysql_fetch_assoc($resd);
echo "<td>$rowd[orderdate]</td>";
$sqle="SELECT `username` FROM `user` WHERE `userindex`=(SELECT `userid` FROM `order` WHERE `orderid`=(SELECT `orderid` FROM `orderdetail` WHERE `orderdetailid`='$row[orderdetailid]'))";
$rese=mysql_query("$sqle");
$rowe=mysql_fetch_assoc($rese);
echo "<td>$rowe[username]</td>";
echo "</tr>";
$value+=$rowb[productprice]*$rowc[productquantity];
}
echo "<tr><th colspan='4'>Total Sales</th><td>$value</td></tr>";
echo"</table>";
//echo "$sql";
?>