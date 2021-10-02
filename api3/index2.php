<?php
	header("Content-Type: application/json; charset=UTF-8");
	include ("../dbconnect.php");
	include ("../functions.php");


	// if(isset($_POST['monitor_name'])){		
		// $monitor_name = $_POST['monitor_name'];		
	// } else {
		// $monitor_name = "";
	// }		

	//https://www.datacamp.com/community/tutorials/making-http-requests-in-python

	////////////////////////////////////////////////
	
	if(isset($_POST['dht']))
	{
		$dht = $_POST['dht'];	
		$dht = substr($dht, 0, -1);			
		$dht_arr = explode("*", $dht);						
		
		//$i = 0;
		foreach ($dht_arr as $value) 
		{
			$dht_arr_arr = explode(",", $value);
			
			if(count($dht_arr_arr) == 3) {
				$bn = $dht_arr_arr[0];
				$temp = $dht_arr_arr[1];
				$hum = $dht_arr_arr[2];				
			} else {
				$bn = "sample";
				$temp = 0;
				$hum = 0;				
			}
			

			
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

	////////////////////////////////////////////////

	if(isset($_POST['monitor_name'])){		
		$monitor_name = $_POST['monitor_name'];	
		$sql = "SELECT board_name, pins FROM tbl_boards WHERE " . 
		" monitor_name = '$monitor_name' ";
		
		$result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($conn));
		$count = mysqli_num_rows($result);

		if($count > 0){		
			
			//create an array
			$data = array();
			while($row =mysqli_fetch_assoc($result))
			{
				$data[] = $row;
			}
			
			echo json_encode($data);
		} else {
			echo '[{"error":"1","err_desc":"no_board_found_link_to_monitor"}]';
		}
	} else {
		
		echo '[{"error":"1","err_desc":"no_board_found_link_to_monitor"}]';
		
	}		
		
		
    //close the db connection
    mysqli_close($conn);
?>



