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
<script type="text/javascript" src="jquery-1.11.1.js">
</script>

<script>
function todaysale(a){
htmlobj=$.ajax({url: "displayproduct.php",type: "POST",async:false,
data:{productname:a},
datatype: 'json',
});
$("#salesgoods").html(htmlobj.responseText);
}
</script>


<?php
$category=$_POST['category'];
error_reporting(E_ALL ^ E_NOTICE ^E_DEPRECATED);
$category=$_POST["category"];
$con=mysql_connect("cs-server.usc.edu:4844","root","");
if (!$con)
 {
 die('Could not connect: ' . mysql_error());
 }
 mysql_select_db("user", $con);
$day=date("Y-m-d");
$sql="SELECT `productid` FROM `specialsales` WHERE `productid` IN (SELECT `productid` FROM `product` WHERE `productcategoryid`=(SELECT `productcategoryid` FROM `productcategory` WHERE `productcategoryname`='$category'))
 AND `startdate`<='$day' AND `enddate`>='$day'";
$res=mysql_query("$sql");
echo "<caption>Today's Sale Message!</caption>";
echo "<table>";
echo "<tr><th>item</th><th>sales</th></tr>";
while($row=mysql_fetch_assoc($res)){
echo "<tr>";
$sql1="SELECT `productname` FROM `product` WHERE `productid`='$row[productid]'";
$res1=mysql_query("$sql1");
$row1=mysql_fetch_assoc($res1);
echo "<td><input type='button' class='link' value='$row1[productname]' onclick='todaysale(this.value)'/></td>";
$sql2="SELECT `salesprice` FROM `specialsales` WHERE `productid`='$row[productid]'";
$res2=mysql_query("$sql2");
$row2=mysql_fetch_assoc($res2);
echo "<td>".$row2[salesprice]."</td>";
echo "</tr>";
}
echo "</table>";
?>