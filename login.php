<?php
session_start();
$_SESSION["adminname"]="";
$_SESSION["adminpwd"]="";
$_SESSION["time"]=time();
?>
<head>
<script type="text/javascript" src="jquery-1.11.1.js">
</script></head>
<script>
function register(){
htmlobj=$.ajax({url: "register.php",type: "POST",async:false,
});
$("#salesgoods").html(htmlobj.responseText); 
}

function logout(){
htmlobj=$.ajax({url: "logout.php",type: "POST",async:false,
});
$("#login").html(htmlobj.responseText); 
}

function shoppingcart(){
htmlobj=$.ajax({url: "shoplist.php",type: "POST",async:false,
});
$("#salesgoods").html(htmlobj.responseText); 
}
function order(){
htmlobj=$.ajax({url: "order.php",type: "POST",async:false,
});
$("#salesgoods").html(htmlobj.responseText); 
}
function editprofile(){
htmlobj=$.ajax({url: "editprofile.php",type: "POST",async:false,
});
$("#salesgoods").html(htmlobj.responseText); 
}
function viewsummary(){
htmlobj=$.ajax({url: "viewsummary.php",type: "POST",async:false,
});
$("#salesgoods").html(htmlobj.responseText); 
}
</script>

<?php
// Report all errors except E_NOTICE 
error_reporting(E_ALL ^ E_NOTICE ^E_DEPRECATED);

//login part
$username="";
$password="";
$username=$_POST["username"];
$password=$_POST["password"];
//$_SESSION["adminname"]=$_POST["username"];
//$_SESSION["adminpwd"]=$_POST["password"];
$errmsg="";

if(strlen($username)==0){
	$errmsg='Invalid Username! ';
}
if(strlen($password)==0){
	$errmsg='Invalid Password! ';
}
if((strlen($username)==0)&&(strlen($password)==0)){
	$errmsg='';
}
if((strlen($username)>0)&&(strlen($password)>0)){
	//connection to sql
	$con=mysql_connect("cs-server.usc.edu:4844","root","");
	//check if connection fail
	mysql_select_db("user",$con);
	$sql="select * from user where username='$username'and password='$password'";
	$res=mysql_query($sql)or trigger_error(mysql_error().$sql);;

	if(!($row=mysql_fetch_array($res))){
		//no rows retrieved
		$errmsg='Invalid Login!';
	}
}



if(strlen($errmsg)>0){
	//send back to login page with error
	echo"$errmsg";
	echo'username:<input type="text" id="username"/>&nbsp;
		password:<input type="text" id="password"/>&nbsp;
		<input type="submit" value="login" onclick="login()"/>&nbsp;
		<input type="submit" value="New Customer Register" onclick="register()">;';
}
elseif(!$res){
	//didn't talk to DB
	echo'username:<input type="text" id="username"/>&nbsp;
		password:<input type="text" id="password"/>&nbsp;
		<input type="submit" value="login" onclick="login()"/>&nbsp;
		<input type="submit" value="New Customer Register" onclick="register()">';
}
else{
	//valid username, display appropriate page
	//require 'edit.php';
	//session_start();
	$_SESSION["adminname"]=$username;
	$_SESSION["adminpwd"]=$password;
	$_SESSION["time"]=time();
	$usertype = $row['usertype'];
	echo "welcome,"."&nbsp&nbsp"."<span id='usr'>$username</span>"."&nbsp&nbsp"."<input type='submit' value='logout' onclick='logout()'>"."&nbsp&nbsp"
	."<input type='submit' value='Edit profile' onclick='editprofile()'>"."<input type='submit' value='shopping cart' onclick='shoppingcart()'>";
	echo"<input type='submit' id='vieworder' value='view orders' onclick='order()'>";
	$sql1="select * from user where username='$username'";
	$res1=mysql_query($sql1);
	$row1 = mysql_fetch_assoc($res1);
	if($row1['usertype']=='manager'){echo"<input type='button' value='order summary' onclick='viewsummary()'>";}
}

?>

