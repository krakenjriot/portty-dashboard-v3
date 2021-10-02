<?php	
	if(isset($_GET['p'])) { 
		$p = $_GET['p']; 
	} else {
		$p = "1";
	} 
	
	switch ($p) {
		case '0': include('404.php'); break;    	
		case '1': include('index1.php'); break;
		case '2': include('index2.php'); break;
		default : include('404.php'); break;    
	}
	
?>

