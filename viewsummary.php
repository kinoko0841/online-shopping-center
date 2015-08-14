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
?>

<script type="text/javascript" >
 function searchorder(){
 	if($("#startdate").val()>$("#enddate").val()){
		alert("Invalid date!");
		return false;
	}
htmlobj=$.ajax({url: "searchorder.php",type: "POST",async:false,
data:{startdate:$("#startdate").val(),
	  enddate:$("#enddate").val(),
	  productcategory:$("#pcategory").val(),
	  sales:$("#ss").val(),
	  product:$("#pp").val(),
	 },
datatype: 'json',
});
$("#orderlist").html(htmlobj.responseText);
}  
function formreset(){
	document.getElementById("myform").reset();
	//document.getElementById("description").reset();
}

</script>

<html>
<h1>search option</h1>
<div align="left">
<form id='myform'>
Start date:<select id='startdate' >
<option value=''></option>
<option value='1'>14-07-01</option>
<option value='2'>14-07-10</option>
<option value='3'>14-07-20</option>
</select>
End date:<select id='enddate'>
<option></option>
<option value='1'>14-07-10</option>
<option value='2'>14-07-20</option>
<option value='3'>14-08-01</option>
</select>
<br>Product Category:<select id='pcategory'>
<option></option>
<option value='1'>fruits</option>
<option value='2'>vegetables</option>
<option value='3'>grains</option>
<option value='5'>proteinfoods</option>
<option value='7'>dairy</option>
<option value='11'>drinks</option>
</select>
Special sales product:<input type='text'id='ss'/>
product:<input type='text' id='pp'/>
<input type='button' value='search' id='search' onclick='searchorder()'/>
<input type='button' value='reset' id='reset1' onclick='formreset()'/>
</form>
</div>
<div id='orderlist' style='text-align:center;'></div>
</html>
