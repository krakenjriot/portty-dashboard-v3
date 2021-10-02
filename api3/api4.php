<?php



	//$pins = '01234567890123456789';
	$pins = '00000000000000000000';
	$insert = '1';
	$location = 5;

	echo substr_replace($pins, $insert, $location, 1); // 
	
	
	if(isset($_POST['board_name'])){
		
		$board_name = $_POST['board_name']);
		
	} else {
		$board_name = "";
	}
	
	if(isset($_POST['pin_pos'])){
		
		$pin_pos = $_POST['pin_pos']);
		
	} else {
		$pin_pos = "";
	}	
	
	if(isset($_POST['pin_val'])){
		
		$pin_val = $_POST['pin_val']);
		
	} else {
		$pin_val = "";
	}	
	
	
	
	
	
?>	