<?php
session_start();
$_SESSION["adminname"]="";
$_SESSION["adminpwd"]="";
$_SESSION["time"]=time();
?> 

<script type="text/javascript" src="jquery-1.11.1.js">
</script>

<script type="text/javascript" >
function detail(a){
htmlobj=$.ajax({url: "displayproduct.php",type: "POST",async:false,
data:{productname:$("#"+a).val()},
datatype: 'json',
});
$("#salesgoods").html(htmlobj.responseText);
}

</script>

<?php
/* Report all errors except E_NOTICE */
error_reporting(E_ALL ^ E_NOTICE ^E_DEPRECATED);
$con=mysql_connect("cs-server.usc.edu:4844","root","");
if (!$con)
 {
 die('Could not connect: ' . mysql_error());
 }
mysql_select_db("user", $con);
$t=date('Y-m-d');
echo"<h1>Today's Special!$t</br></h1>";
$sql="select productid from specialsales where startdate<'$t' and enddate>'$t'";
$result = mysql_query($sql);
while($row = mysql_fetch_assoc($result)){
	$sql1="select `productname` from product WHERE productid='$row[productid]'";
	$res1=mysql_query($sql1);
	$row1 = mysql_fetch_assoc($res1);
	$name=$row1[productname].".jpg";
	echo "<div class='img'style='margin:3px;  border:2px solid #bebebe;  height:auto;  width:auto;  float:left;text-align:center;'>";
	echo"<img src='$name' width='160' height='160'>";
	echo "<script>a:hover img{border:1px solid #333333;}</script>";
	echo"<div class='desc' style='text-align:center;font-weight:normal;width:150px;font-size:12px;margin:10px 5px 10px 5px;font-family:Georgia, serif;font-size:20px;'>";
	echo "<input type='submit' value='$row1[productname]' id='$row[productid]' name='productname' style='background-color:Transparent ;border:0px;font:icon;color:Blue;' onclick='detail(this.id)'>";
	$sql11="select `productprice` from product WHERE productid='$row[productid]'";
	$res11=mysql_query($sql11);
	$row11 = mysql_fetch_assoc($res11);
	echo "<br><span style='text-decoration:line-through;color:grey'>price:$row11[productprice]</span>";
	$sql2="select * from specialsales WHERE productid='$row[productid]'";
	$res2=mysql_query($sql2);
	$row2 = mysql_fetch_assoc($res2);
	echo "<br>salesprice:" . $row2[salesprice];
	echo"</div>";
	echo "</div>";
}
echo "<div id='showss'></div>";
mysql_close($con);
?>