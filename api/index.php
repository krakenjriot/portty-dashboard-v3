<?php

	//include ("../session.php");
	include ("../dbconnect.php");
	include ("../functions.php");

	header("Content-Type: application/json; charset=UTF-8");
	$myObj = new \stdClass();
	$pins = "";
	$board_name = "";
	$passcode = "";
	//$dht = "";
	

if	(	isset($_GET['board_name']) && 
		isset($_GET['passcode']) && 
		isset($_GET['get'])
	){
		
	//echo "11000000000000000000";
	
	
	
	
	$board_name = $_GET['board_name'];
	$dht = $_GET['dht'];
	//echo $dht;
	//check output file exist
	
	//check dht file exist

	///////////////////////////////////////////////

	
	//$temp = "2";
	//$hum = "1";	
    
	$sql = "SELECT * FROM tbl_pins WHERE board_name = '$board_name' ORDER BY pin_num ASC";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0)
    {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result))
        {
            $pins .= $row['active'];
        }
    }

	
	
	
	
	$file_output = "../exe/conf/$board_name.output";
	if(!is_file($file_output)){
		//$contents = 'This is a test!';
		file_put_contents($file_output, "00000000000000000000");
	}
	
	$file_dht = "../exe/conf/$board_name.dht";
	if(!is_file($file_dht)){
		//$contents = 'This is a test!';
		file_put_contents($file_dht, $dht);
	}
	
	$file_tmp = "../exe/conf/$board_name.tmp";
	if(!is_file($file_tmp)){
		//$contents = 'This is a test!';
		file_put_contents($file_tmp, "0");
	}	
	
	//$board_name = $_GET['board_name'];
	//echo __DIR__ . " test";
	
	//save dht values
	file_put_contents("../exe/conf/$board_name.dht", $dht);
	file_put_contents("../exe/conf/$board_name.tmp", $dht);
	file_put_contents("../exe/conf/$board_name.output", $pins);
	
	
	
	///////////////////////////////////////////////
	//$dht_str = "1111,22333";
	//$dht_str = file_get_contents("../exe/conf/$board_name.dht");
	//$dht_arr = str_getcsv($dht_str);
	$dht_arr = str_getcsv($dht);
	//file_put_contents("../exe/conf/$board_name.dht_arr", $dht_arr[0]);
	$temp = $dht_arr[0];
	$hum = $dht_arr[1];	

	$sql = "INSERT INTO tbl_dht (temp, hum, board_name) VALUES ($temp, $hum, '$board_name')";
	$conn->query($sql);
	///////////////////////////////////////////////
	$sql = "UPDATE tbl_boards SET " . " temp = $temp, " . " hum = $hum " . " WHERE board_name = '$board_name' ";
	$conn->query($sql);
	/*
	$dht_str = file_get_contents("../exe/conf/$board_name.dht");
	$dht_arr = str_getcsv($dht_str);
	$temp = $dht_arr[0];
	$hum = $dht_arr[1];	
	*/
	
	//file_put_contents("../exe/conf/$board_name.temp", $temp);
	//file_put_contents("../exe/conf/$board_name.hum", $hum);
	/*
	$dht_arr = str_getcsv($dht_str);
	$temp = $dht_arr[0];
	$hum = $dht_arr[1];	
	
	//echo "temp " . $temp;
	//echo "</br>";
	//echo "hum " . $hum;
	*/
	/*
	$sql = "INSERT INTO tbl_dht (temp, hum, board_name) VALUES ($temp, $hum, '$board_name')";
	$conn->query($sql);
	///////////////////////////////////////////////
	$sql = "UPDATE tbl_boards SET " . " temp = $temp, " . " hum = $hum " . " WHERE board_name = '$board_name' ";
	$conn->query($sql);
	*/
	
	
	///////////////////////////////////////////////	
	//$dht_arr = "";
	
	//print_r($dht_arr);


	//read output pins
	//$pins = file_get_contents("../exe/conf/$board_name.output");
	
	$myObj->board_name = $board_name;
	$myObj->pins = $pins;
	
	$myJSON = json_encode($myObj);

	echo $myJSON;	
	
} 

else if	(	isset($_GET['board_name']) && 
			isset($_GET['passcode']) && 
			isset($_GET['pins']) && 
			isset($_GET['post'])
	){
		
		
	}




else {
	echo "porttyweb api link";
}



?>