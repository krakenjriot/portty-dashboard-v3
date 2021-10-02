<?php

	$app_path = "\\\conf\\\exe\\\xloader\\\XLoader.exe";
	//$app_path = "C:\\xampp\htdocs\\portty-dashboard\\exe\\xloader\\XLoader.exe";
	
  
	


	$command = "start /B $app_path  > NUL";
	pclose( popen( $command, 'r' ) );








?>