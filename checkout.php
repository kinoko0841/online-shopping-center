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
<head>
<script type="text/javascript" src="jquery-1.11.1.js">
</script></head>
<script>
function submitorder(a){
if(($("#billingad").val()!="")&&($("#shippingad").val()!="")){
	htmlobj=$.ajax({url: "submitorder.php",type: "POST",async:false,
	data:{ba:$("#billingad").val(),sa:$("#shippingad").val(),total:a,},
	});
$("#salesgoods").html(htmlobj.responseText);
}
else{
	alert("Input Address!");
	return false;
}
}
</script>
<?php 
$username=$_SESSION["adminname"];
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
$sql1="select * from shoppingcart where userid='$userid'";
$res1=mysql_query($sql1);
echo "<table id='shoptable1'>";
echo "<th>product</th><th>quantity</th><th>price</th>";
while($row1= mysql_fetch_assoc($res1)){
	echo "<tr>";
	$sql11="select * from product where productid='$row1[productid]'";
	$res11=mysql_query($sql11);
	$row11= mysql_fetch_assoc($res11);
	echo "<td>$row11[productname]</td>";
	echo "<td>$row1[productquantity]</td>";
	echo "<td>$row1[productprice]</td>";
	echo "</tr>";
	$total+=$row1[productquantity]*$row1[productprice];
}
echo "<th colspan='2'>Total Price</th><td colspan='2' align='center' id='total'>$total</td>";
echo "</table>";
echo "Billing address:<input id='billingad' type='text'><br>";
echo "Shipping address:<input id='shippingad' type='text'><br>";
echo "<input type='button' value='submit' onclick='submitorder($total)'>";
?>