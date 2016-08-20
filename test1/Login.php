<?php
session_start();
	$conn = mysql_connect("localhost", "root", "");
    if(!$conn){
		die('Could not connect' . mysql_error());
	}
	echo 'Connected successfully';
	mysql_select_db("testSF",$conn) or die('Error querying database' . mysql_error());

$UserName = $_POST['uname'];
$PassWord = $_POST['pword'];

$sqlQuery = "SELECT * from admin WHERE username= '$UserName' and password= '$PassWord' ";
$result = mysql_query($sqlQuery);
$count = mysql_num_rows($result);

$_SESSION['userNameSess'] = $UserName;
$_SESSION['userCount'] = $count;

if($count == 1){
	$admin = mysql_fetch_assoc($result);
	session_write_close();
	header("location: dashboard.html");
}else {
	$_SESSION['count'] = $_SESSION['count']+1;
	if($_SESSION['count']==1){
		$_SESSION['errorlogin'] = "Username or Password Incorrect!";
		$_SESSION['loginattemp']= "4 Attempt Left Out of 5";
		$_SESSION['checkRec'] = 1;
	}
	if($_SESSION['count']==2){
		$_SESSION['errorlogin'] = "Username or Password Incorrect";
		$_SESSION['loginattemp']= "3 Attempt Left Out of 5";
		$_SESSION['checkRec'] = 1;
	}
	if($_SESSION['count']==3){
		$_SESSION['errorlogin'] = "Username or Password Incorrect";
		$_SESSION['loginattemp']= "2 Attempt Left Out of 5";
		$_SESSION['checkRec'] = 1;
	}
	if($_SESSION['count']==4){
		$_SESSION['errorlogin'] = "Username or Password Incorrect";
		$_SESSION['loginattemp']= "1 Attempt Left Out of 5";
		$_SESSION['checkRec'] = 1;
	}
	if($_SESSION['count']>=5){
		$_SESSION['checkRec'] = 1;
	}
	header("location: login.html");
	}

?>