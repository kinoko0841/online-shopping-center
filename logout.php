<?php
echo '<script><link rel="stylesheet" type="text/css" href="module.css" /></script>';
echo '<span style="float:left;">Welcome to the food shop!</span>
username:<input type="text" id="username"/>&nbsp;
password:<input type="text" id="password"/>&nbsp;
<input type="submit" value="login" onclick="login()"/>&nbsp;
<input type="submit" value="New Customer Register" onclick="register()"/>&nbsp;';
session_destroy();
?>