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
}?>
<head>
<script type="text/javascript" src="jquery-1.11.1.js">
</script></head>
<script>
function changeprofile(a){
if($("#u1").val()==""){
	alert("Input Username!");
	return;
}
if($("#p1").val()==""){
	alert("Input password!");
	return;
}
if($("#p1").val()!=$("#c1").val()){
	alert("Confirm password!");
	return;
}
if($("#l1")==""){
	alert("Input lastname!");
	return;
}
if($("#f1")==""){
	alert("Input firstname!");
	return;
}
if($("#a1")==""){
	alert("Input age!");
	return;
}
if($("#t1")==""){
	alert("Input telephone!");
	return;
}
if($("#e1")==""){
	alert("Input email!");
	return;
}else{
	htmlobj=$.ajax({url: "changeprofile.php",type: "POST",async:false,
		data:{
		userindex:a,
		username:$("#u1").val(),
		password:$("#p1").val(),
		usertype:$("#usertype").val(),
		lastname:$("#l1").val(),
		firstname:$("#f1").val(),
		age:$("#a1").val(),
		telephone:$("#t1").val(),
		email:$("#e1").val(),},
	});
	$("#description").html(htmlobj.responseText); 
}
}



</script>
<?php
$con=mysql_connect("cs-server.usc.edu:4844","root","");
if (!$con)
 {
 die('Could not connect: ' . mysql_error());
 }

mysql_select_db("user", $con);

$username=$_SESSION["adminname"];
$sql="select * from user where username='$username'";
$res=mysql_query($sql);
$row = mysql_fetch_assoc($res);
$userid=$row[userindex];

echo "<div name='register'style='text-align:right' >";
echo "<p style='text-align:left'>Customer Register(*:required):";
echo "<p><span style='color:red'>Username*</span>:<input id='u1' type='text' value='$row[username]'></p>";
echo "<p><span style='color:red'>Password*</span>:<input id='p1' type='password' value='$row[password]'></p>";
echo "<p><span style='color:red'>Confirm Password*</span>:<input id='c1' type='password'value='$row[password]'></p>";
echo "<p>Usertype:<select name='usertype' id='usertype'>";
?>
<option <?php if($row[usertype]=='administrator') echo('selected');?> id='administrator'>administrator</option>
<option <?php if($row[usertype]=='customer') echo('selected');?> id='customer'>customer</option>
<option <?php if($row[usertype]=='manager') echo('selected');?> id='manager'>manager</option>
<option <?php if($row[usertype]=='salesmanager') echo('selected');?> id='salesmanager'>salesmanager</option></select>
<?php
echo "<p>Lastname:<input type='text' id='l1' value='$row[lastname]'></p>";
echo "<p>Firstname:<input type='text' id='f1' value='$row[firstname]'></p>";
echo "<p>Age:<input type='text' id='a1' value='$row[age]'></p>";
echo "<p>Telephone:<input type='text' id='t1' value='$row[telephone]'></p>";
echo "<p>Email:<input type='email' id='e1' value='$row[email]'></p>";
echo "<p><input type='button' value='submit' onclick='changeprofile($row[userindex])'></p>";

?>