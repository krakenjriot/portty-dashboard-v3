<?php 
	//include ("functions.php");
	
	
	include ("session.php");
	
	$config = include 'config';		
	$server_refresh_sec = $config['server_refresh_sec'] * 1000;	
	$server_refresh_sec =  (int) $server_refresh_sec;
	
	
	/*$sql = "SELECT * FROM tbl_servers";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0)
	{
		// output data of each row
		while ($row = mysqli_fetch_assoc($result))
		{
			$refresh_sec = $row['refresh_sec'];
		}
	}*/
			
	
	echo "<h1>";
	echo "<tt>";
	echo "page refresh: ". $server_refresh_sec/1000 ." sec</br>";	
	echo "</tt>";	
	echo "</h1>";	
	
	

	
	
	
	
	

?>

<!DOCTYPE html>
<html>
	<head><title></title>
		<script src="https://code.jquery.com/jquery-1.12.4.js"	integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU="	crossorigin="anonymous"></script>
		<script>
			$(document).ready(function() {
				var refresh = function () {
				//$('#worker').load('worker.exec.php');
				$('#worker').load('?p=15');
				 }
				 //setInterval(refresh, 1 * 60 * 1000); //minute interval				 
				 setInterval(refresh, <?php echo $server_refresh_sec; ?>); //minute interval				 
				 refresh();
			});
		</script>
		
		<meta http-equiv="refresh" content="30"> <!-- Refresh every  minutes -->
	</head>
	<body>
		<div id="worker">Loading...</div>
	</body>
</html>