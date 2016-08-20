<?php
session_start();
	$conn = mysql_connect("localhost", "root", "");
    if(!$conn){
		die('Could not connect' . mysql_error());
	}
	mysql_select_db("testSF",$conn) or die('Error querying database' . mysql_error());

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$role_select = $_POST['role_select'];
$uname = $_POST['uname'];
$passWord = $_POST['passWord'];

$qry = "INSERT into User(role_id,Fname,Lname,Uname,Pword) values ('$role_select','$fname',
		'$lname','$uname','$passWord')";
$result = mysql_query($qry);

$_SESSION['result'] = $result;


if ($result == 1) {	
	header("location: Add.html");
}else {

	$qry = "select * from User where Fname='$fname' AND Lname='$lname'";
	$qry1 = "SELECT * from User where Uname='$uname'";
	$result = mysql_query($qry);
	$result2 = mysql_query($qry1);
		if (mysql_num_rows($result) > 0 || mysql_num_rows($result2) > 0) {
				$_SESSION['successErrorMSG'] = "<h3>User already exist!</h3>";
			}else {
				echo "/None";	
			}

	header("location: Add.html");
}

?>