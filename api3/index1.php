<?php
	header("Content-Type: application/json; charset=UTF-8");
	include ("../dbconnect.php");
	include ("../functions.php");
		
	if(isset($_POST['monitor_name'])){		
		$monitor_name = $_POST['monitor_name'];		
	} else {
		$monitor_name = "";
	}	
	
	if(isset($_POST['passcode'])){		
		$passcode = $_POST['passcode'];		
	} else {
		$passcode = "";
	}
	
	if(isset($_POST['monitor_type'])){		
		$monitor_type = $_POST['monitor_type'];		
	} else {
		$monitor_type = "";
	}	
	
		
	/********************************************************************************/
	$count0 = 0;
	$count1 = 0;
	$count2 = 0;
	
	//authenticate passcode_hash	
	$sql = "SELECT * FROM tbl_monitors WHERE monitor_name = '$monitor_name' ";
	$result = mysqli_query($conn, $sql);	
	$count1 = mysqli_num_rows($result);	
	if($count1 == 0) $monitor_name_found = "monitor_not_found";
	else $monitor_name_found = "monitor_found";
	
	$sql = "SELECT * FROM tbl_monitors WHERE passcode = '$passcode' ";
	$result = mysqli_query($conn, $sql);	
	$count2 = mysqli_num_rows($result);
	if($count2 == 0) $passcode_found = "passcode_not_found";
	else $passcode_found = "passcode_found";

	if($count1 > 0 && $count2 > 0){
		$sql = "SELECT * FROM tbl_monitors WHERE monitor_name = '$monitor_name' AND passcode = '$passcode' ";
		$result = mysqli_query($conn, $sql);	
		//$count0 = mysqli_num_rows($result);
		
		//update monitor type			
        $sqlx = "UPDATE tbl_monitors SET " . 		 
		" monitor_type = '$monitor_type' " . 
		" WHERE monitor_name = '$monitor_name' ";
        if ($conn->query($sqlx) === true){}			
	
		
		echo '[{"error":"0","err_desc":"auth-success"}]';	
		
	} else {
		echo '[{"error":"1","err_desc":"'.$monitor_name_found.' | '.$passcode_found.'"}]';
	}
	
	

	
    //close the db connection
    mysqli_close($conn);
	
?>



