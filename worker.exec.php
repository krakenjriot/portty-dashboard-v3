<?php
include ("session.php");
include ("functions.php");
include ("dbconnect.php");

echo "<h1>";
echo "<tt>";
//echo "<pre>";

//echo "</pre>";

$server_ip = "";
$url = "";
$parse = "";
$root_url = "";
$web_service_s = "";
$web_page_s = "";
$monitor_msg = "";

$sql = "SELECT * FROM tbl_servers WHERE active = 1 ";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0)
{
    // output data of each row
    while ($row = mysqli_fetch_assoc($result))
    {
        $server_ip = $row['server_ip'];
        $server_name = $row['server_name'];
        $url = "http://$server_ip/portty/";
        $parse = parse_url($url);
        $root_url = "http://" . $parse['host'];

        //echo $row['server_ip']."</br>";
        //echo $server_name."</br>";
        //echo $root_url."</br>";
        //echo "check_root_url_reachable ".check_root_url_reachable($root_url)."</br>";
        //echo "check_root_url_reachable ".check_root_url_reachable("http://192.168.100.55")."</br>";       

        if (check_root_url_reachable($root_url))
        {
            $sql = "UPDATE tbl_servers SET  active = 1 , web_service = 1 WHERE server_ip = '$server_ip' ";
            $conn->query($sql);

            if (check_url_page_reachable($root_url))
            {
                $sql = "UPDATE tbl_servers SET  web_page = 1 WHERE server_ip = '$server_ip' ";
                $conn->query($sql);				
				check_monitor();
            }
            else
            {
                $sql = "UPDATE tbl_servers SET  web_page = 0 WHERE server_ip = '$server_ip' ";
                $conn->query($sql);
            }
        }
        else
        {            
            $sql = "UPDATE tbl_servers SET  active = 0 , web_service = 0, web_page = 0 WHERE server_ip = '$server_ip' ";
            $conn->query($sql);
        }

    } //while    
}

else

{
    //echo "<pre>";
    echo "no active servers available</br>";
    //echo "</pre>";
}



			$s_file = "start.ts";
			if (file_exists($s_file))
			{				
				$start = file_get_contents($s_file);
			} 
		
			$c_file = "current.ts";
			if (file_exists($c_file))
			{				
				$end = file_get_contents($c_file);
			}
			
			
			//$uptime_sec = $end - $start;
			//$c_file = "current.ts";
			if (file_exists($c_file))
			{				
				file_put_contents($c_file, strtotime('now'));
			}			
			


echo "current date/time: " . date('Y-m-d H:i:s') . "</br>";

//secondsToTimeInterval(intval($end - $start));


echo "uptime: " . secondsToTimeInterval(intval($end - $start)) . "</br>";
//echo "timestamp: " . date('Y-m-d H:i:s') . "</br>";




//DISPLAY STATUS SERVERS
$sql = "SELECT * FROM tbl_servers ";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $server_name = $row['server_name'];
        $server_ip = $row['server_ip'];
        $web_service = $row['web_service'];
        $web_page = $row['web_page'];

        //echo "<pre>";
        echo "***************** server status ******************</br>";
        echo "server_name: $server_name</br>";
        echo "server_ip: $server_ip</br>";
        if ($web_service)
        {
            echo "web_service <i  style='background-color:MediumSeaGreen;'>running</i></br>";
        }
        else
        {
            echo "web_service <i  style='background-color:Tomato;'>stopped</i></br>";
        }
        if ($web_page)
        {
            echo "web_page <i  style='background-color:MediumSeaGreen;'>running</i></br>";
        }
        else
        {
            echo "web_page <i  style='background-color:Tomato;'>stopped</i></br>";
        }
        echo "**************************************************</br>";
        //echo "</pre>";
    }
} //


//DISPLAY STATUS BOARDS
$sql = "SELECT * FROM tbl_boards ";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $board_name = $row['board_name'];
        $server_name = $row['server_name'];
        $monitor = $row['monitor'];

        //echo "<pre>";
        echo "***************** board status *******************</br>";
        echo "board_name: $board_name</br>";
        echo "server_name: $server_name</br>";

        if ($monitor)
        {
            echo "porttymon.exe process <i  style='background-color:MediumSeaGreen;'>running</i></br>";
        }
        else
        {
            echo "porttymon.exe process <i  style='background-color:Tomato;'>stopped</i></br>";
        }
		
		$sql = "SELECT * FROM tbl_dht WHERE board_name = '$board_name' ";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0)
		{
			while ($row = mysqli_fetch_assoc($result))
			{
				$temp = (float)$row['temp'];		
				$hum = (float)$row['hum'];		
			}		
			
        echo "temp: $temp / hum: $hum</br>";			
        echo "**************************************************</br>";			
		}
    }
} //


















echo "</tt>";
echo "</h1>";
mysqli_close($conn);

?>
