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
function addprofile(){
if($("#u2").val()==""){
	alert("Input Username!");
	return;
}
if($("#p2").val()==""){
	alert("Input password!");
	return;
}
if($("#p2").val()!=$("#c2").val()){
	alert("Confirm password!");
	return;
}
if($("#l2")==""){
	alert("Input lastname!");
	return;
}
if($("#f2")==""){
	alert("Input firstname!");
	return;
}
if($("#a2")==""||(isNaN($("#a2").val()))){
	alert("Input bad age!");
	return;
}
if(($("#t2")=="")||(isNaN($("#t2").val()))){
	alert("Input bad telephone!");
	return;
}
if($("#e2")==""){
	alert("Input email!");
	return;
}else{
alert("ok");
	htmlobj=$.ajax({url: "addprofile.php",type: "POST",async:false,
		data:{
		username:$("#u2").val(),
		password:$("#p2").val(),
		usertype:$("#usertype2").val(),
		lastname:$("#l2").val(),
		firstname:$("#f2").val(),
		age:$("#a2").val(),
		telephone:$("#t2").val(),
		email:$("#e2").val(),},
	});
	$("#description").html(htmlobj.responseText); 
}
}

</script>
<?php
echo "<div name='register'style='text-align:right' >";
echo "<p style='text-align:left'>Customer Register(*:required):";
echo "<p><span style='color:red'>Username*</span>:<input id='u2' type='text' ></p>";
echo "<p><span style='color:red'>Password*</span>:<input id='p2' type='password' ></p>";
echo "<p><span style='color:red'>Confirm Password*</span>:<input id='c2' type='password'></p>";
echo "<p>Usertype:<select name='usertype' id='usertype2'>";
echo "<option>administrator</option>";
echo "<option>customer</option>";
echo "<option>manager</option>";
echo "<option>salesmanager</option></select>";
echo "<p>Lastname:<input type='text' id='l2' ></p>";
echo "<p>Firstname:<input type='text' id='f2' ></p>";
echo "<p>Age:<input type='text' id='a2' ></p>";
echo "<p>Telephone:<input type='text' id='t2' ></p>";
echo "<p>Email:<input type='email' id='e2' ></p>";
echo "<p><input type='button' value='submit' onclick='addprofile()'></p>";
?>
