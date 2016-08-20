<?php
session_start();
	$conn = mysql_connect("localhost", "root", "");
    if(!$conn){
		die('Could not connect' . mysql_error());
	}
	mysql_select_db("testSF",$conn) or die('Error querying database' . mysql_error());

$Tname = $_POST['taskName'];
$U_select = $_POST['user_select'];
$status_sel = $_POST['stats_select'];
$TDescrip = $_POST['task_descrip'];

$qry = "INSERT into Tasks(userID, task_name,status,start_date,update_date,description) values ('$U_select','$Tname',
		'$status_sel',NOW(),NOW(),'$TDescrip')";
$result = mysql_query($qry);

$_SESSION['result'] = $result;


if ($result == 1) {	
	header("location: AddTask.html");
}else {

	$qry = "select * from Tasks where task_name='$Tname'";
	$result = mysql_query($qry);
		if (mysql_num_rows($result) > 0) {
				$_SESSION['successErrorMSG'] = "<h3>Task already exist!</h3>";
			}else {
				echo "/None";	
			}

	header("location: AddTask.html");
}

?>