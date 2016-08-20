<?php
session_start();
	$conn = mysql_connect("localhost", "root", "");
    if(!$conn){
		die('Could not connect' . mysql_error());
	}
	mysql_select_db("testSF",$conn) or die('Error querying database' . mysql_error());

$TboxSearch = $_GET['searchBox'];
$Stats_Search = $_GET['stats_search'];


if ($Stats_Search == 'Pending' && $TboxSearch != NULL) {
	pendingSearch($TboxSearch);
}

function pendingSearch($username){

	if ($username != NULL) {
		$qry = mysql_query("select * from User where Uname='$username'");
		while ($row = mysql_fetch_array($qry)) {
			$userid = $row['user_id'];
		} 

		$qry2 = mysql_query("SELECT * FROM Tasks WHERE  update_date > DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())+6 DAY) AND start_date <= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-1 DAY)  AND status = 'Pending' AND userID = '$userid' ");
		while ($row2 = mysql_fetch_array($qry2)) {
			echo "<tr>";
			echo "<td>".$row2['task_name'] ."</td>";
			$qry3 = mysql_query("SELECT * from User where user_id = $row2[userID]");
			while ($row3 = mysql_fetch_array($qry3)) {
				echo "<td>".$row3['Fname'] .', ' . $row3['Lname'] ."</td>";
				echo "<td>".$row3['Uname'] ."</td>";
			}
			echo "<td>".$row2['status']."</td>";
			echo "<td>".$row2['description']."</td>";
			echo "<td>".$row2['start_date']."</td>";
			echo "<td>".$row2['update_date']."</td>";
			echo "<tr>";
		}
	}
}



    if (!(isset($_SESSION['userCount']) && $_SESSION['userCount'] == 1)) {
        session_destroy();
        header("location: login.html");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Search Task</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet" type="text/css">

    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <script src="https://use.fontawesome.com/0d0a485630.js"></script>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.html">System Admin</a>
            </div>
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> 
                        <?php if(isset($_SESSION['userNameSess']) && $_SESSION['userNameSess'] == NULL){} 
                            else {
                                    $qry = "SELECT * from admin where username = '$_SESSION[userNameSess]' ";
                                    $result = mysql_query($qry);
                                    while ($row = mysql_fetch_array($result)) {
                                        echo $row['username'];
                                    }}?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="dashboard.html"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="active">
                        <a href="Tasks.html"><i class="fa fa-tasks"></i> Tasks</a>
                    </li>
                    <li>
                        <a href="Users.html"><i class="fa fa-users"></i> Users</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-plus"></i> Add <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="Add.html"> <i class="fa fa-user-plus" aria-hidden="true"></i> Add User</a>
                            </li>
                            <li>
                                <a href="AddTask.html"> <i class="fa fa-tasks" aria-hidden="true"></i>Add Task</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

       <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Result Task
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="dashboard.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Result Task
                            </li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <h2>Tasks List</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Task Name</th>
                                        <th>Assignee</th>
                                        <th>Username</th>
                                        <th>Status</th>
                                        <th>Description</th>
                                        <th>Start Date</th>
                                        <th>Date Updated</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php
										if ($Stats_Search == 'Pending' && $TboxSearch != NULL) {
											pendingSearch($TboxSearch);
										}    
										?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


</body>

</html>