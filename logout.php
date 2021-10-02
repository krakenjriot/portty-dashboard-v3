<?php
// Initialize the session.
session_start();
// Unset all of the session variables.
unset($_SESSION['id']);
// Finally, destroy the session.    
session_destroy();


			$s_file = "start.ts";
			if (file_exists($s_file))
			{				
				unlink($s_file);
			} 
		
			$c_file = "current.ts";
			if (file_exists($c_file))
			{				
				unlink($c_file);
			}




// Include URL for Login page to login again.
header("location: ?p=1&msg=logout-success");
exit;
?>