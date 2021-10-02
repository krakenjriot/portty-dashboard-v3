<?php
//include ("session.php");

function ex($command)
{
    shell_exec('SCHTASKS /F /Create /TN _law /TR "' . $command . '"" /SC DAILY /RU 
INTERACTIVE');
    shell_exec('SCHTASKS /RUN /TN "_law');
    shell_exec('SCHTASKS /DELETE /TN "_law" /F');
}
//ex("C:/Windows/System32/notepad.exe");


function get_local_ip(){

if (!empty($_SERVER['HTTP_CLIENT_IP']))   
  {
    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
  }
//whether ip is from proxy
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
  {
    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
//whether ip is from remote address
else
  {
    $ip_address = $_SERVER['REMOTE_ADDR'];
  }
//echo $ip_address;

return $ip_address;

}



function getUserIP()
{
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
              $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
              $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}





function update_pins($board_name)
{

    $pins = "";

    include ("dbconnect.php");
    //get pins
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
	
        $sql = "UPDATE tbl_boards SET " . 		 
		" pins = '$pins' " . 
		" WHERE board_name = '$board_name' ";

        if ($conn->query($sql) === true){}
        	
}//










function update_list($board_name)
{

    $server_ip = "";
    $exe_dir = "";
    $htdocs_dir = "";
    $board_refresh_sec = "";
    $server_timezone = "";
    $pins = "";
    $server_name = "";
    $response = "";
    $url = "";

    include ("dbconnect.php");
    //get pins
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
	
	
	
	
	
	

    //echo "pins ".$pins."</br>";
    //get server name
    $sql = "SELECT * FROM tbl_boards WHERE board_name = '$board_name' ";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0)
    {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result))
        {
            $server_name = $row['server_name'];
            $board_refresh_sec = $row['refresh_sec'];
        }
    }

    //echo "server_name ".$server_name."</br>";
    //get server ip
    $sql = "SELECT * FROM tbl_servers WHERE server_name = '$server_name' ";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0)
    {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result))
        {
            $server_ip = $row['server_ip'];
            $server_name = $row['server_name'];
            $exe_dir = addslashes($row['exe_dir']);
            $htdocs_dir = addslashes($row['htdocs_dir']);
            $server_timezone = $row['server_timezone'];
			$server_refresh_sec = $row['refresh_sec'];
            $active = $row['active'];
        }
    }
	
	
	//save to config file as well
	$config = include 'config';
	$config['server_refresh_sec']= $server_refresh_sec;	
	file_put_contents('config', '<?php return ' . var_export($config, true) . ';');		


    //echo "server_ip ".$server_ip."</br>";
    //echo "exe_dir ".$exe_dir."</br>";
    //echo "server_timezone ".$server_timezone."</br>";
    //$url = "http://" . $server_ip . "/portty-dashboard/api/?board_name=$board_name&pins=$pins&exe_dir=$exe_dir&server_timezone=$server_timezone&htdocs_dir=$htdocs_dir&board_refresh_sec=$board_refresh_sec&server_refresh_sec=$server_refresh_sec";

    //echo "url ".$url."</br>";
    //check if server ip is present if not insert
    //$sql = "SELECT * FROM tbl_url WHERE board_name = 'myboard1' ";
    $sql = "SELECT * FROM tbl_url WHERE board_name = '$board_name' ";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0)
    {
        //present perform update
        $sql = "UPDATE tbl_url SET " . 
		" url = '$url', " . 
		" pins = '$pins', " . 
		" server_ip = '$server_ip', " . 
		" server_name = '$server_name', " . 
		" htdocs_dir = '$htdocs_dir', " . " exe_dir = '$exe_dir', " . 
		" server_timezone = '$server_timezone', " . 
		" board_refresh_sec = '$board_refresh_sec', " . 
		" server_refresh_sec = '$server_refresh_sec', " . 
		" active = $active, " . 
		" response = '$response' " . 
		" WHERE board_name = '$board_name' ";

        if ($conn->query($sql) === true)
        {
            //
            
        }
    }
    else
    {
        //not present perform insert
        $sql = "INSERT INTO tbl_url (server_refresh_sec, active, board_name, server_ip, url, pins, server_name, htdocs_dir, exe_dir, server_timezone, board_refresh_sec)
  		VALUES ('$server_refresh_sec', $active, '$board_name', '$server_ip', '$url', '$pins', '$server_name', '$htdocs_dir', '$exe_dir', '$server_timezone', '$board_refresh_sec')";
        $conn->query($sql);
    }

    /*
    echo  "pins :" 		.	$pins. "</br>";
    echo  "server_name :" .	$server_name. "</br>";
    echo  "server_ip :" 	.	$server_ip. "</br>";
    echo  "exe_dir :" 	.	$exe_dir. "</br>";
    */

} //update_url


/*
c:
cd $confi_dir
C:\portty>porttymon.exe myboard1 com10 3




*/

function create_batch_file_monitor($board_name)
{
    include ("dbconnect.php");

    //get server name
    $sql = "SELECT * FROM tbl_boards WHERE board_name = '$board_name' ";
    $result = mysqli_query($conn, $sql);
    $server_name = "";
    $refresh_sec = "";
    $com_port = "";
    if (mysqli_num_rows($result) > 0)
    {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result))
        {
            $server_name = $row['server_name'];
            $com_port = $row['com_port'];
            $refresh_sec = $row['refresh_sec'];
        }
    }

    //get server ip
    $sql = "SELECT * FROM tbl_servers WHERE server_name = '$server_name' ";
    $result = mysqli_query($conn, $sql);
    //$server_ip = "";
    $exe_dir = "";

    if (mysqli_num_rows($result) > 0)
    {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result))
        {
            //$server_ip = $row['server_ip'];
            $exe_dir = addslashes($row['exe_dir']);
        }
    }

    $batch_for_porttymon = "
	\n
	c: \n
	cd $exe_dir \n
	rem del /q /f $board_name.output \n
	rem cd ..
	rem timeout /t 5 /nobreak
	porttymon.exe $board_name $com_port $refresh_sec \n
	pause
	";
    file_put_contents("batchfile\\$board_name.porttymon.bat", $batch_for_porttymon);
	
    

} //update_url



/*
function create_batch_xloader()
{
    include ("dbconnect.php");

    //get server ip
    $sql = "SELECT * FROM tbl_servers WHERE _default = 1 ";
    $result = mysqli_query($conn, $sql);
    $exe_dir = "";
    if (mysqli_num_rows($result) > 0)
    {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result))
        {
            //$server_ip = $row['server_ip'];
            $exe_dir = addslashes($row['exe_dir']);
        }
    }

   
	
	$batch_for_xloader = "
	\n
	c: \n
	cd C:\xampp\htdocs\portty-dashboard\exe\xloader \n
	start /b xloader.exe  \n
	";
    file_put_contents("batchfile\\xloader.bat", $batch_for_xloader);	
	
	

} //update_url
*/








function secondsToTimeInterval($seconds) {
    $t = round($seconds);
    $days = floor($t/86400);
    $day_sec = $days*86400;
    $hours = floor( ($t-$day_sec) / (60 * 60) );
    $hour_sec = $hours*3600;
    $minutes = floor((($t-$day_sec)-$hour_sec)/60);
    $min_sec = $minutes*60;
    $sec = (($t-$day_sec)-$hour_sec)-$min_sec;
    return sprintf('%02d:%02d:%02d:%02d', $days, $hours, $minutes, $sec);
}












function check_url_page_reachable($url)
{

    //$url = "http://myservers.nwc.com.sa";
    $headers = @get_headers($url);
    if (strpos($headers[0], '404') === false)
    {
        //echo "</br>web page is reachable!";
        //set web page to online
        return true;

    }
    else
    {
        //echo "</br>web page is not reachable!";
        //set web page to offline
        return false;
    }

} //
function check_exe_dir_exist($url)
{

} //
function check_htdocs_dir_exist($url)
{

} //
//returns true, if domain is availible, false if not
function check_root_url_reachable($url)
{
    //check, if a valid url is provided
    

    if (!filter_var($url, FILTER_VALIDATE_URL))
    {
        return false;
    }

    //initialize curl
    $curlInit = curl_init($url);
    //curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
    curl_setopt($curlInit, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($curlInit, CURLOPT_HEADER, true);
    curl_setopt($curlInit, CURLOPT_NOBODY, true);
    curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, true);

    //get answer
    $response = curl_exec($curlInit);

    curl_close($curlInit);

    if ($response) return 1;

    return 0;

    /*
      $ctx = stream_context_create(['http' => ['timeout' => 5]]); // 5 seconds
               $response = @file_get_contents($url, null, $ctx);
    
    
    if (!empty($response)){
    	return 1;			
    } else {
    	return 0;
    }			   */

} //


//$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
// Output: 36e5e490f14b031e
//echo substr(md5(time()), 0, 16);
// Output: aa88ef597c77a5b3
//echo substr(sha1(time()), 0, 16);
function generate_string($strength = 16)
{
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    $input_length = strlen($permitted_chars);
    $random_string = '';
    for ($i = 0;$i < $strength;$i++)
    {
        $random_character = $permitted_chars[mt_rand(0, $input_length - 1) ];
        $random_string .= $random_character;
    }
    return $random_string;
}


function check_monitor(){
	
	include ("dbconnect.php");
	
	$sql = "SELECT * FROM tbl_url WHERE active = 1 ";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0)
	{
		// output data of each row
		while ($row = mysqli_fetch_assoc($result))
		{
			$server_ip = $row['server_ip'];
			$board_name = $row['board_name'];
			$htdocs_dir = $row['htdocs_dir'];
			$exe_dir = $row['exe_dir'];
			$server_timezone = $row['server_timezone'];
			$pins = $row['pins'];
			$board_refresh_sec = $row['board_refresh_sec'];
			$server_refresh_sec = $row['server_refresh_sec'];

			if (!empty($server_ip))
			{
				$url = "http://" . $server_ip . "/portty-dashboard/api/?board_name=$board_name&pins=$pins&exe_dir=$exe_dir&server_timezone=$server_timezone&htdocs_dir=$htdocs_dir&board_refresh_sec=$board_refresh_sec&server_refresh_sec=$server_refresh_sec";
				$ctx = stream_context_create(['http' => ['timeout' => 5]]); // 5 seconds
				$response = @file_get_contents($url, null, $ctx);

				//echo $url;
				//echo "response ".$response."</br>";
				//echo "url ".$url."</br>";
				//echo $response."</br>";
				//echo $url."</br>";
				if (!empty($response))
				{
					//myboard1,22:05:45,29.90,22.00,0ld7vcxm72c2g3yz,Asia/Riyadh,0
					$response_arr = str_getcsv($response);
					//$board_name2 = $response_arr[0];
					//$dt = $response_arr[1];
					$temp = $response_arr[2];
					$hum = $response_arr[3];
					$hashed = $response_arr[4];
					$tz = $response_arr[5];
					$monitor = $response_arr[6];

					//echo "exe_dir ".$exe_dir."</br>";
					//echo "response ".$response."</br>";
					//echo "monitor ".$monitor."</br>";
					//echo "response_arr ".$response_arr[6]."</br>";
					
					
					if ($monitor)
					{
						//$monitor_msg = 1;
						//$sql = "INSERT INTO tbl_dht (temp, hum, dt, board_name)
						$sql = "INSERT INTO tbl_dht (temp, hum, board_name) VALUES ($temp, $hum, '$board_name')";
						$conn->query($sql);
						///////////////////////////////////////////////
						$sql = "UPDATE tbl_boards SET " . " temp = $temp, " . " hum = $hum " . " WHERE board_name = '$board_name' ";
						$conn->query($sql);
						///////////////////////////////////////////////
						
					}
					else
					{
						//$monitor_msg = 0;
						
					}
					///////////////////////////////////////////////
					$sql = "UPDATE tbl_boards SET " . " monitor = $monitor " . "WHERE board_name = '$board_name' ";
					$conn->query($sql);
					///////////////////////////////////////////////
					
				}
				
				//echo "response ".$response."</br>";
			
			}
		}
	} //if
	
}//


















