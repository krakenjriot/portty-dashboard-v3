<?php	
	if(isset($_GET['p'])) { 
		$p = $_GET['p']; 
	} else {
		$p = "1";
	} 
	
	switch ($p) {
    case '0': include('404.php'); break;    	
    case '1': include('login.php'); break;
    case '2': include('register2.php'); break;
    case '3': include('forgot-password.php'); break;
    case '4': include('home.php'); break;
    case '5': include('setpass.php'); break;
    case '6': include('settings.php'); break;	
    case '7': include('logout.php'); break;	
    case '8': include('set-pass.php'); break;	
    case '9': include('settings.php'); break;	
    case '10': include('delete-server-modal.php'); break;	
    case '11': include('delete-server-exec.php'); break;
    case '12': include('delete-board-modal.php'); break;	
    case '13': include('delete-board-exec.php'); break;		
    case '14': include('worker.php'); break;		
    case '15': include('worker.exec.php'); break;		
    case '16': include('get_data.php'); break;		
    case '17': include('start-xloader.php'); break;		
	default : include('404.php'); break;    
	}
	
?>

