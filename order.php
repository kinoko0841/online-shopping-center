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
</head>

<script>
function order1(a){
//alert(a);
htmlobj=$.ajax({url: "order1.php",type: "POST",async:false,
	data:{orderid:a,},
	datatype: 'json',
	});
$("#formshow").html(htmlobj.responseText);
}
</script>

<?php
/* Report all errors except E_NOTICE */
error_reporting(E_ALL ^ E_NOTICE ^E_DEPRECATED);
$username=$_SESSION["adminname"];
$con=mysql_connect("cs-server.usc.edu:4844","root","");
if (!$con)
 {
 die('Could not connect: ' . mysql_error());
 }

mysql_select_db("user", $con);
$sql1="select userindex from user WHERE username='$username'";
$res1=mysql_query($sql1);
$row1 = mysql_fetch_assoc($res1);
$userid=$row1['userindex'];
//echo $userid;
$sql2="SELECT orderid FROM `order` WHERE userid='$userid'";
$res2=mysql_query($sql2);
echo "<div id='formshow'>";
while($row2 = mysql_fetch_assoc($res2)){
 	foreach($row2 as $value){
		echo "<table border='1'>";
		$sql21="SELECT * FROM `order` WHERE orderid='$value'";
		$res21=mysql_query($sql21);
		$row21 = mysql_fetch_assoc($res21);
		echo "<tr><td colspan='3'>order date:$row21[orderdate]<input type='button' value='show this order detail' style='background-color:Transparent ;border:0px;font:icon;color:Blue;' onclick='order1($value)'></td></tr>";
	echo "</table>";
	echo "<br>";
	} 
}
echo "table show here</div>";
?>