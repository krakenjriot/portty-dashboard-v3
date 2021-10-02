<?php
	header("Content-Type: application/json; charset=UTF-8");
	//include ("../session.php");
	include ("../dbconnect.php");
	include ("../functions.php");
	
	$sensord = "";
	$dht = "";	
	
	
	
	if(isset($_POST['dht'])){
		$dht = $_POST['dht'];
		file_put_contents("dht.txt", $dht);	
	}	
	if(isset($_POST['sensord'])){
		$sensord = $_POST['sensord'];	
		file_put_contents("sensord.txt", $sensord);		
	}
	if(isset($_POST['server_type'])){
		$server_type = $_POST['server_type'];	
		file_put_contents("server_type.txt", $server_type);		
	} else {
		$server_type = "";	
	}
	
	if(isset($_POST['monitor_name'])){
		$monitor_name = $_POST['monitor_name'];	
		file_put_contents("monitor_name.txt", $monitor_name);		
	} else {
		$monitor_name = "x";
	}
	
	if(isset($_POST['passcode'])){
		$passcode = $_POST['passcode'];	
		file_put_contents("passcode.txt", $passcode);		
	} else {
		$passcode = "";
	}	
	
	
	

	////////////////////////////////////////////////
	//check server name exist
	$sql_check_svr = "SELECT monitor_name FROM tbl_servers WHERE monitor_name = '$monitor_name' ";
	$sql_check_svr_res = mysqli_query($conn, $sql_check_svr);	
	$sql_check_svr_res_row_count = mysqli_num_rows($sql_check_svr_res);	
	
	//file_put_contents("count.txt", $sql_check_svr_res_row_count);	
	
	if($sql_check_svr_res_row_count > 0){
		//file_put_contents("check_server.txt", "server exist");		
		//do nothing!
		$proceed = true;
		
	} else {
		//file_put_contents("check_server.txt", "server does not exist");	
		//file_put_contents("xxx.txt", "count is greater");	
		
		$sql = "INSERT INTO tbl_servers (monitor_name, server_desc, server_location, server_timezone, refresh_sec, passcode, server_type)
		VALUES ('$monitor_name', 'default', 'Manila/Philippines', 'Asia/Manila', 3 , '$passcode' , '$server_type')";
		
		//$sql = "INSERT INTO tbl_servers (monitor_name) VALUES ('$monitor_name')";		

		if ($conn->query($sql) === TRUE) {
			//echo "New record created successfully";
			
		} else {
			//echo "Error: " . $sql . "<br>" . $conn->error;
			
		}
		
		$proceed = false;
	}
	////////////////////////////////////////////////
	
	////////////////////////////////////////////////
	//share the output files to porttymon
	if($proceed){		
		$pins = "";
		$data = "";		
		
		$sql1 = "SELECT * FROM tbl_boards WHERE monitor_name = '$monitor_name' ORDER BY board_name ASC";
		$result1 = mysqli_query($conn, $sql1);	
		$row_count = mysqli_num_rows($result1);
		
		if (mysqli_num_rows($result1) > 0)
		{					
			// output data of each row
			while ($row1 = mysqli_fetch_assoc($result1))
			{    
				$board_name = $row1['board_name'];
				
				/*
				$lim_a = $row1['lim_low'];
				$lim_b = $row1['lim_hi'];
				$lim_c = $row1['lim_trig_low'];
				$lim_d = $row1['lim_trig_range'];
				$lim_e = $row1['lim_trig_hi'];				
				$lim = "$lim_a,$lim_b,$lim_c,$lim_d,$lim_e";				
				*/					
				
				///////////////////////////////////////////////////////
				$sql2 = "SELECT * FROM tbl_pins WHERE board_name = '$board_name' ORDER BY pin_num ASC";
				$result2 = mysqli_query($conn, $sql2);
				
				//reset the pins for next board
				$pins = "";
				if (mysqli_num_rows($result2) > 0)
				{
					// output data of each row
					while ($row2 = mysqli_fetch_assoc($result2))
					{			
						$pins .= $row2['active'];
					}	
					
					if($row_count > 1) $data .= '{"board_name":"' . $board_name . '","pins":"' . $pins . '"},';					
					if($row_count == 1) $data .= '{"board_name":"' . $board_name . '","pins":"' . $pins . '"}';						
				}		
				$row_count = $row_count - 1;
			}
		} else {
			
			$data = '{"board_name": "sample", "pins": "00000000000000000000"}';
		}	
				
	} else {
		
		$data = '{"board_name": "sample", "pins": "00000000000000000000"}';
		
	}//if($proceed)	
	
		echo "[";
		echo $data;		
		echo "]";
	////////////////////////////////////////////////
	
	////////////////////////////////////////////////
	/*
	if(isset($_POST['dht']))
	{
		$dht = $_POST['dht'];	
		$dht = substr($dht, 0, -1);			
		$dht_arr = explode("*", $dht);						
		
		//$i = 0;
		foreach ($dht_arr as $value) 
		{
			$dht_arr_arr = explode(",", $value);
			$bn = $dht_arr_arr[0];
			$temp = $dht_arr_arr[1];
			$hum = $dht_arr_arr[2];
			
			$sql = "INSERT INTO tbl_dht (board_name, temp, hum)
			VALUES ('$bn', $temp, $hum )";

			if ($conn->query($sql) === TRUE) {
			  //echo "New record created successfully";
			} else {
			  //echo "Error: " . $sql . "<br>" . $conn->error;
			}			
			
			$sql = "UPDATE tbl_boards SET temp = $temp, hum = $hum WHERE board_name  = '$bn' ";

			if ($conn->query($sql) === TRUE) {
			  //echo "Record updated successfully";
			} else {
			  //echo "Error updating record: " . $conn->error;
			}	
		}			
	}
	*/
	////////////////////////////////////////////////
	
	/*
	////////////////////////////////////////////////
	if(isset($_POST['sensord']))
	{
		$sensord = $_POST['sensord'];	
		$sensord = substr($sensord, 0, -1);			
		$sensord_arr = explode("*", $sensord);						
	
		foreach ($sensord_arr as $value) 
		{
			$sensord_arr_arr = explode(",", $value);
			$bn = $sensord_arr_arr[0];
			$val1 = $sensord_arr_arr[1];
			$val2 = $sensord_arr_arr[2];
			$val3 = $sensord_arr_arr[3];
			$val4 = $sensord_arr_arr[4];
			$val5 = $sensord_arr_arr[5];
			$val6 = $sensord_arr_arr[6];
			$val7 = $sensord_arr_arr[7];
			$val8 = $sensord_arr_arr[8];
			$val9 = $sensord_arr_arr[9];
			$val10 = $sensord_arr_arr[10];
			$val11 = $sensord_arr_arr[11];
			$val12 = $sensord_arr_arr[12];
			$val13 = $sensord_arr_arr[13];
			$val14 = $sensord_arr_arr[14];
			$val15 = $sensord_arr_arr[15];
			$val16 = $sensord_arr_arr[16];
			$val17 = $sensord_arr_arr[17];
			$val18 = $sensord_arr_arr[18];
			$val19 = $sensord_arr_arr[19];
			$val20 = $sensord_arr_arr[20];
			
			
			$sql = "INSERT INTO tbl_sensord (board_name, 
			val1,val2,val3,val4,val5, 
			val6,val7,val8,val9,val10, 
			val11,val12,val13,val14,val15, 
			val16,val17,val18,val19,val20)
			
			VALUES ('$bn', 
			$val1,$val2,$val3,$val4,$val5, 
			$val6,$val7,$val8,$val9,$val10, 
			$val11,$val12,$val13,$val14,$val15, 
			$val16,$val17,$val18,$val19,$val20)";

			if ($conn->query($sql) === TRUE) {
			  //echo "New record created successfully";
			} else {
			  //echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}			
	}
	////////////////////////////////////////////////	
	*/

	
	
	$conn->close();

	
?>