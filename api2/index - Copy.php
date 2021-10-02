<?php
	header("Content-Type: application/json; charset=UTF-8");
	//include ("../session.php");
	include ("../dbconnect.php");
	include ("../functions.php");
	
	$sensord = "";
	$dht = "";	
	
	echo "[";
	
	
	if(isset($_POST['dht']) && isset($_POST['sensord'])){
		$dht = $_POST['dht'];	
		$dht = substr($dht, 0, -1);			
		$dht_arr = explode("*", $dht);						
		////////////////////////////////////////////////
		$i = 0;
		foreach ($dht_arr as $value) {
			$dht_arr_arr = explode(",", $value);
			$bn = $dht_arr_arr[0];
			$temp = $dht_arr_arr[1];
			$hum = $dht_arr_arr[2];
			
			//echo $bn;
			//echo $temp;
			//echo $hum;
			
			//file_put_contents("sample1.txt", $bn);
			
			$sql = "INSERT INTO tbl_dht (board_name, temp, hum)
			VALUES ('$bn', $temp, $hum )";

			if ($conn->query($sql) === TRUE) {
			  //echo "New record created successfully";
			} else {
			  echo "Error: " . $sql . "<br>" . $conn->error;
			}
			
			
			$sql = "UPDATE tbl_boards SET temp = $temp, hum = $hum WHERE board_name  = '$bn' ";

			if ($conn->query($sql) === TRUE) {
			  //echo "Record updated successfully";
			} else {
			  echo "Error updating record: " . $conn->error;
			}	

			//$conn->close();				
			
			$i = $i + 1;
		}
		
		$sensord = $_POST['sensord'];
		file_put_contents("sensord.txt", $sensord);		
		////////////////////////////////////////////////				
	} else {
		echo "[{'board_name': 'sample', 'pins': '00000000000000000000'}]";
	}
	
	
	
	
		////////////////////////////////////////////////
		
		
		
		$pins = "";
		$pinx = "";		
		
		$sql1 = "SELECT * FROM tbl_boards ORDER BY board_name ASC";
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
					
					if($row_count > 1) $pinx .= '{"board_name":"' . $board_name . '","pins":"' . $pins . '"},';					
					if($row_count == 1) $pinx .= '{"board_name":"' . $board_name . '","pins":"' . $pins . '"}';						
				}		
				$row_count = $row_count - 1;
			}
		}
		
		echo $pinx;				
		////////////////////////////////////////////////		
	
	
	






	

		
		
		
	

	echo "]";	
	
	$conn->close();
	
	
	
	
	//echo '{"d":"00000000000000000000"}';
	
?>