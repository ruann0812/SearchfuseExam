<?php
session_start();
	$conn = mysql_connect("localhost", "root", "");
    if(!$conn){
		die('Could not connect' . mysql_error());
	}
	mysql_select_db("practiceDB1",$conn) or die('Error querying database' . mysql_error());

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$emaildd = $_POST['eadd'];
$aDDress = $_POST['add'];
$gender = $_POST['gender'];

$qry = "INSERT into customer(Fname,Lname,emailAdd,Address,Gender) values ('$fname',
		'$lname','$emaildd','$aDDress', '$gender')";
$result = mysql_query($qry);

$_SESSION['result'] = $result;


if ($result == 1) {	
	header("location: Add.html");
}else {

	$qry = "select * from customer where Fname='$fname' AND Lname='$lname' AND emailAdd='$emaildd' ";
	$result = mysql_query($qry);
		if (mysql_num_rows($result) > 0) {
				$_SESSION['successErrorMSG'] = "<h3>Customer already exist!</h3>";
			}else {
				echo "/None";	
			}
	header("location: Add.html");
}

?>