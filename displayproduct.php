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

<script type="text/javascript">
function addtocart(a){
//alert(a);
//alert("<?php echo $_SESSION["adminname"];?>");

var admin=$("#usr").html();
var quantity=$("#quantity").val();
//alert(quantity);
if(quantity==""||isNaN(quantity)){
	alert("Invalid quantity!");
	return false;
}
if(admin==null){
	alert("please register or login!");
	return false;
}
else{
	htmlobj=$.ajax({url: "addtocart.php",type: "POST",async:false,
	data:{productid:a,quantity:$("#quantity").val(),},
	datatype: 'json',
	});
$("#productdisplay").html(htmlobj.responseText);

}
}

function recgood(a){
//alert("god");
htmlobj=$.ajax({url:"recgood.php",type: "POST",async:false,
	data:{productid:a,},
	datatype: 'json',
	});
$("#recommand").html(htmlobj.responseText);
} 
</script>
<?php
/* Report all errors except E_NOTICE */
error_reporting(E_ALL ^ E_NOTICE ^E_DEPRECATED);
$productname=$_POST["productname"];
$con=mysql_connect("cs-server.usc.edu:4844","root","");
if (!$con)
 {
 die('Could not connect: ' . mysql_error());
 }

mysql_select_db("user", $con);

$sql="select * from product where productname='$productname'";
$res=mysql_query($sql);
$row = mysql_fetch_assoc($res);
if($row!=""){
$name=$row[productname].".jpg";
echo"<img src='$name' width='160' height='160'>";
echo "<br>Product:".$row['productname'];
$pid=$row['productid'];
//echo "<span id='$pid' value='$pid'>$pid</span>";
echo "<br>About this product:".$row['productdescription'];
$day=date("Y-m-d");
$sql2="SELECT `salesprice` FROM `specialsales` WHERE `productid`='$row[productid]' AND `startdate`<='$day' AND `enddate`>='$day'";
$res2=mysql_query("$sql2");
if($row2=mysql_fetch_assoc($res2)){echo "<br>price:$row2[salesprice]";}
			else{echo "<br>price:$row[productprice]";}
echo "<br>Quantity:<input type='text' id='quantity'>";
echo "<br><input type='submit' value='add to shopping cart' onclick='{addtocart($pid);recgood($pid)}'>";
}
?>