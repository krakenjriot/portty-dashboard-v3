<?php 
session_start();

if( !isset($_SESSION['id']) ){
	header("location: ?p=1&session=session-invalid");
	exit();	
} else {
			
			
			$fullname = $_SESSION['fullname'];	
			$fname = $_SESSION['fname'];	
			$email = $_SESSION['email'];		
			$mobile_number = $_SESSION['mobile_number'];		
	
} 



if ( !file_exists('config') ) {
	header("location: ?p=1&config=notset");
	exit();	
}




