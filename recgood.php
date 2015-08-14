<?php
/* Report all errors except E_NOTICE */
error_reporting(E_ALL ^ E_NOTICE ^E_DEPRECATED);
//check if timeout
session_start();
$t=time();
if($t-$_SESSION["time"]>2000){
echo "<script>alert('logout by system!');</script>";
//require"logput.php";
session_destroy();
}?>

<head>
<script type="text/javascript" src="jquery-1.11.1.js">
</script></head>

<script type="text/javascript" >
function detail(a){
htmlobj=$.ajax({url: "displayproduct.php",type: "POST",async:false,
data:{productname:$("#"+a).val()},
datatype: 'json',
});
$("#productdisplay").html(htmlobj.responseText);
} 
</script>
<?php
/* Report all errors except E_NOTICE */
error_reporting(E_ALL ^ E_NOTICE ^E_DEPRECATED);
$productid=$_POST["productid"];
$con=mysql_connect("cs-server.usc.edu:4844","root","");
if (!$con)
 {
 die('Could not connect: ' . mysql_error());
 }

mysql_select_db("user", $con);
$sql="SELECT DISTINCT `productid` FROM `orderdetail` WHERE `orderid` IN
(SELECT `orderid` FROM `orderdetail` WHERE `productid`='$productid')";
$result=mysql_query($sql);
echo "<h1>The customers buy this item also buy:</h1>";
while($row = mysql_fetch_assoc($result)){
			
			$sql1="SELECT `productname` FROM `product` WHERE `productid`='$row[productid]'";
			$res1=mysql_query("$sql1");
			$row1=mysql_fetch_array($res1);
			$name=$row1[productname].".jpg";
			echo "<div class='img'style='margin:3px;  border:2px solid #bebebe;  height:auto;  width:auto;  float:left;text-align:center;'>";
			echo"<img src='$name' alt='doge' width='130' height='130'>";
			echo"<div class='desc' style='text-align:center;font-weight:normal;width:150px;font-size:12px;margin:10px 5px 10px 5px;font-family:Georgia, serif;font-size:20px;'>";
			echo "<input type='submit' value='$row1[productname]' id='$row[productid]' name='productname' style='background-color:Transparent ;border:0px;font:icon;color:Blue;' onclick='detail(this.id)'>";
			$day=date("Y-m-d");
			$sql2="SELECT `salesprice` FROM `specialsales` WHERE `productid`='$row[productid]' AND `startdate`<='$day' AND `enddate`>='$day'";
			$res2=mysql_query("$sql2");
			
			$sql3="SELECT `productprice` FROM `product` WHERE `productid`='$row[productid]'";
			$res3=mysql_query("$sql3");
			$row3=mysql_fetch_assoc($res3);
			if($row2=mysql_fetch_assoc($res2)){echo "<br>price:$row2[salesprice]";}
			else{echo "<br>price:$row3[productprice]";}
			echo"</div>";
			echo "</div>";
		}
?>