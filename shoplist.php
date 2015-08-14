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
function changelist(a,b){
	//alert(b);
	//alert(a);
	var total=$("#total").html();
	//alert(b);
	htmlobj=$.ajax({url: "changelist.php",type: "POST",async:false,
	data:{item:b,quantity:a,total:total,},
	});
$("#total").html(htmlobj.responseText);
}

function checkout(a){
	htmlobj=$.ajax({url: "checkout.php",type: "POST",async:false,
	//data:{userid:a,},
	//datatype: 'json',
	});
$("#salesgoods").html(htmlobj.responseText);
}

function deletelist(a,b){
	var b="p"+a;
	alert(b);
	$("#"+b).hide();
	htmlobj=$.ajax({url: "deletelist.php",type: "POST",async:false,
	data:{item:a,},
	datatype: 'json',
	});
$("#total").html(htmlobj.responseText);
}

function reset(){
	htmlobj=$.ajax({url: "resetlist.php",type: "POST",async:false,
	});
$("#salesgoods").html(htmlobj.responseText);
}
</script>
<?php 
//echo $_SESSION['adminname'];
$username=$_SESSION['adminname'];
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
echo "<table id='shoptable'>";
echo "<th>product</th><th>quantity</th><th>price</th><th>delete</th>";
while($row1= mysql_fetch_assoc($res1)){
	$item1="p".$row1[item];
	echo "<tr id='$item1'>";
	$sql11="select * from product where productid='$row1[productid]'";
	$res11=mysql_query($sql11);
	$row11= mysql_fetch_assoc($res11);
	echo "<td>$row11[productname]</td>";
	echo "<td><input type='text' value='$row1[productquantity]' onchange='changelist(this.value,$row1[item])'></td>";
	echo "<td>$row1[productprice]</td>";
	echo "<td><input type='button' value='delete this item' onclick='deletelist($row1[item])' style='background-color:transparent;'></td>";
	echo "</tr>";
	$total+=$row1[productquantity]*$row1[productprice];
}
echo "<th colspan='2'>Total Price</th><td colspan='2' align='center' id='total'>$total</td>";
echo "</table>";
echo "<input type='button' value='reset shopping cart' onclick='reset()'>";
echo "<input type='button' value='checkout' onclick='checkout()'>";
?>