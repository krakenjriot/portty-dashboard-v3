<?php

$dht_file = "";
$out_file = "";
$tmp_file = "";

if (isset($_GET['pins']) && $_GET['board_name'])
{

    //b=$board_name&
    //p=$pins&
    //exe_dir=$exe_dir&
    //server_timezone=$server_timezone";
    $pins = $_GET['pins'];
    $board_name = $_GET['board_name'];
    $server_timezone = $_GET['server_timezone'];
    $htdocs_dir = $_GET['htdocs_dir'];
    $exe_dir = $_GET['exe_dir'];
    $server_refresh_sec = $_GET['server_refresh_sec'];	
    $board_refresh_sec = $_GET['board_refresh_sec'];	
	
	
	//echo $server_timezone;
	//echo $server_refresh_sec."</br>";
	
	//$board_refresh_sec = (int) $board_refresh_sec;
	
	//$config = include $htdocs_dir . '\\config';		
	//var_dump($config);		
	//$config['server_refresh_sec']= $server_refresh_sec;	
	//file_put_contents($htdocs_dir.'\\config', '<?php return ' . var_export($config, true) . ';');		
	//file_put_contents($htdocs_dir . '\\config', '<?php return ' . var_export($config, true) . ';');	


    $out_file = $exe_dir . "\\conf\\" . $board_name . ".output";
    file_put_contents($out_file, $pins);

    $dht_file = $exe_dir . "\\conf\\" . $board_name . ".dht";
    if (!file_exists($dht_file))
    {
        file_put_contents($dht_file, "0,0");
    }

	$tmp_file = $exe_dir . "\\conf\\" . $board_name . ".tmp";
    if (!file_exists($tmp_file))
    {
        file_put_contents($tmp_file, "");
    }

    $diff = time() - filemtime($tmp_file);

	//echo "diff ".$diff."</br>";	
	//echo "board_refresh_sec ".$board_refresh_sec."</br>";	

    //echo "diff ".$diff."</br>";
    //echo "</br>";
    //echo "dht_file ".$dht_file."</br>";
    //value is zero then set it to 3 secs
    //if(!$board_refresh_sec) $board_refresh_sec = 3;   

    //if ($diff < $board_refresh_sec * 3)
    if ($diff < $board_refresh_sec * 3)
    { // 10 seconds
        //echo "</br>porttymon for board ($board_name) is running";
        //return true;
        $monitor = 1;
    }
    else
    {
        //echo "</br>porttymon for board ($board_name) is not running";
        //return false;
        $monitor = 0;
    }

	//$tz = "Asia/Riyadh"
	
    //echo "</br>";
    //echo "</br>";
    //echo "$config: ". var_dump($config)."</br>";
    //echo "dht hum: ". $dht_arr[1]."</br>";
    date_default_timezone_set($server_timezone);
    //date_default_timezone_set("Asia/Riyadh");
    //date_default_timezone_set($tz);

	//file_put_contents($dht_csv_tmp); // write temp file
	//copy($dht_file, $dht_file_tmp); // ideally on the same filesystem			
	
    //file_put_contents($dht_file_tmp,  file_get_contents($dht_file));
	
	$dht_csv = @file_get_contents($dht_file);
	
    $dt = date('Y-m-d H:i:s:q');

    //echo "</br>";
    //echo "</br>";
    //echo "return porttysen.exe input file";
    //if(empty($dht_csv))$dht_csv = "0,0";
	
	
    if (!empty($dht_csv)) echo "$board_name,$dt,$dht_csv,0ld7vcxm72c2g3yz,$server_timezone,$monitor";
	else echo "$board_name,$dt,0,0,0ld7vcxm72c2g3yz,$server_timezone,$monitor";
	//dont save if zero value
	
	//unlink($dht_file);
}

/*
	$new_datetime = date("H:i:s");
	echo " [0ld7vcxm72c2g3yz] ";
	echo " [". $new_datetime . "] - Board Name: $b</br>";
	echo "todo list - create auto batch file for new add board</br>";
	echo "todo list - add com ports in add/edit board</br>";
	echo "todo list - add cascading links server -> boards -> pins with filter table</br>";
	echo "todo list - create board output if not present</br>";
	echo "todo list - settings to modal to add worker refresh rate</br>";
*/

//echo "server_refresh_sec ".$server_refresh_sec."</br>";

?>
