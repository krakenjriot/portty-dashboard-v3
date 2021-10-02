
<?php


	if (file_exists('config')) {
		//do nothing
	} else {
		//create new file	
		header("location: ?p=1");
		exit();			
	}	













include ("session.php");
include ("dbconnect.php");
include ("functions.php");

//update batchfile for xloader
//create_batch_xloader();

//$show_modal = false;
$online_servers = "";
$offline_servers = "";
//get server_notif
if (isset($_GET['server_notif']))
{
    $server_notif = $_GET['server_notif'];
}
else
{
    $server_notif = "";
}

if (isset($_GET['general_notif']))
{
    $general_notif = $_GET['general_notif'];
}
else
{
    $general_notif = "";
}

if (isset($_GET['monitor_notif']))
{
    $monitor_notif = $_GET['monitor_notif'];
}
else
{
    $monitor_notif = "";
}

//get board-notif
if (isset($_GET['board_notif']))
{
    $board_notif = $_GET['board_notif'];
}
else
{
    $board_notif = "";
}

//get board-notif
if (isset($_GET['pin_notif']))
{
    $pin_notif = $_GET['pin_notif'];
}
else
{
    $pin_notif = "";
}

$config = include 'config';
$email = $config['email'];
$fname = $config['fname'];
$lname = $config['lname'];
//$ipaddress = $config['ipaddress'];
$mobile_number = $config['mobile_number'];
$board_name_monitored = $config['board_name_monitored'];
$server_refresh_sec = $config['server_refresh_sec'];
$filter_pins_by_board = $config['filter_pins_by_board'];
$fullname = ucfirst($fname) . " " . ucfirst($lname);

$ipaddress = getUserIP();

//$ipaddress = $_SERVER['REMOTE_ADDR'];


/*
if (empty($server_refresh_sec))
{
    $config['server_refresh_sec'] = '3';
    //save config to file
    file_put_contents('config', '<?php return ' . var_export($config, true) . ';');
}
*/

/******************************************/
/******************************************/
//get ip address
//$ipaddress = get_local_ip();
//save ip address to object
//$config['ipaddress'] = $ipaddress;
//save config to file
//file_put_contents('config', '<?php return ' . var_export($config, true) . ';');
//check if this ip is default machine
//updat default and non-default

//$config['ipaddress'] = $ipaddress;

/*
$sql = "UPDATE tbl_servers SET " . " _default = 1 " . "WHERE server_ip = '$ipaddress' ";

if ($conn->query($sql) === true)
{
    //
    
}

//check if this ip is default machine
$sql = "UPDATE tbl_servers SET " . " _default = 0 " . "WHERE server_ip <> '$ipaddress' ";

if ($conn->query($sql) === true)
{
    //
    
}
*/
/******************************************/
//










/*
$sql = "SELECT server_ip FROM tbl_servers WHERE _default = 1 ";
$result = mysqli_query($conn, $sql);
$server_ip_local = "";
if (mysqli_num_rows($result) > 0)
{
    // output data of each row
    while ($row = mysqli_fetch_assoc($result))
    {
        $server_ip_local = $row['server_ip'];
    }
}
*/

//create server list
/*
  $sql = "SELECT COUNT(DISTINCT(board_name) FROM tbl_dht ";
  $result = mysqli_query($conn, $sql);
  $board_name = "";
  if (mysqli_num_rows($result) > 0) 
  {
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {
		$dht_count = $row['COUNT(DISTINCT(board_name)'];
	}
  } */
  
  
$ip_server = $_SERVER['SERVER_ADDR'];  
// Printing the stored address
//echo "Server IP Address is: $ip_server";  

if ($ip_server == $ipaddress || $ip_server == "127.0.0.1") {
	$online_text = "<span class'text-success'>Local</span>";
} else { 
	$online_text = "<span class'text-info'>Remote</span>"; 
}

/******************************************/

$offline_servers = "";
$online_servers = "";
//count online server
$sql = "SELECT * FROM tbl_servers WHERE web_service=1";
if ($result = mysqli_query($conn, $sql))
{
    $online_servers = mysqli_num_rows($result);
    mysqli_free_result($result);
}

//count offline server
$sql = "SELECT * FROM tbl_servers WHERE web_service=0";
if ($result = mysqli_query($conn, $sql))
{
    $offline_servers = mysqli_num_rows($result);
    mysqli_free_result($result);
}

$offline_boards = "";
$online_boards = "";
//count online board
$sql = "SELECT * FROM tbl_boards WHERE monitor=1";
if ($result = mysqli_query($conn, $sql))
{
    $online_boards = mysqli_num_rows($result);
    mysqli_free_result($result);
}

//count offline board
$sql = "SELECT * FROM tbl_boards WHERE monitor=0";
if ($result = mysqli_query($conn, $sql))
{
    $offline_boards = mysqli_num_rows($result);
    mysqli_free_result($result);
}

$online_switches = "";
$offline_switches = "";

//count online pins
$sql = "SELECT * FROM tbl_pins WHERE active=1";
if ($result = mysqli_query($conn, $sql))
{
    $online_switches = mysqli_num_rows($result);
    mysqli_free_result($result);
}

//count offline pins
$sql = "SELECT * FROM tbl_pins WHERE active=0";
if ($result = mysqli_query($conn, $sql))
{
    $offline_switches = mysqli_num_rows($result);
    mysqli_free_result($result);
}

//create server list
$sql = "SELECT server_name FROM tbl_servers ";
$result = mysqli_query($conn, $sql);
$i = 1;
$server_list_option = "";
if (mysqli_num_rows($result) > 0)
{
    // output data of each row
    while ($row = mysqli_fetch_assoc($result))
    {
        $server_list_option .= "<option>" . $row['server_name'] . "</option>";
    }
}

//create board list
$sql = "SELECT board_name FROM tbl_boards ";
$result = mysqli_query($conn, $sql);
$board_name_list_option = "";
if (mysqli_num_rows($result) > 0)
{
    // output data of each row
    while ($row = mysqli_fetch_assoc($result))
    {
        $board_name_list_option .= "<option>" . $row['board_name'] . "</option>";
    }
}

//create board list
$sql = "SELECT board_name FROM tbl_boards WHERE monitor = 1 ";
$result = mysqli_query($conn, $sql);
$board_name_list_option_active = "";
if (mysqli_num_rows($result) > 0)
{
    // output data of each row
    while ($row = mysqli_fetch_assoc($result))
    {
        $board_name_list_option_active .= "<option>" . $row['board_name'] . "</option>";
    }
}

if (isset($_POST['selectBoardToMonitor']))
{

    $board_name = $_POST['board_name'];

    $config = include 'config';
    $config['board_name_monitored'] = $board_name;
    file_put_contents('config', '<?php return ' . var_export($config, true) . ';');
    $monitor = 0;

    //check if data is available
    $sql = "SELECT monitor FROM tbl_boards WHERE board_name = '$board_name' ";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            $monitor = $row['monitor'];
        }
    }

    if ($monitor)
    {
        header("location: ?p=4&monitor_notif=board-monitor-running&$monitor#mark-monitor");
        exit();
    }
    else
    {
        header("location: ?p=4&monitor_notif=board-monitor-not-running&$monitor#mark-monitor");
        exit();
    }

} //


if (isset($_POST['selectBoardToPin']))
{

    $config = include 'config';
    //$config['filter_pins_by_board'] = $board_name;
    

    if (isset($_POST['board_name']))
    {

        $board_name = $_POST['board_name'];

        $config['filter_pins_by_board'] = $board_name;
        $board_name_for_pins = $_POST['board_name'];

        file_put_contents('config', '<?php return ' . var_export($config, true) . ';');

        header("location: ?p=4&pin_notif=success&#mark-pin");
        exit();

    }
    else
    {

        $board_name_for_pins = "";
        header("location: ?p=4&pin_notif=failed#mark-pin");
        exit();
    }

} //


if (isset($_POST['download_batchfile']))
{

    $config = include 'config';
    //$config['filter_pins_by_board'] = $board_name;
    

    if (isset($_POST['board_name']))
    {

        /**$board_name = $_POST['board_name'];
        
        $config['filter_pins_by_board'] = $board_name;
        $board_name_for_pins = $_POST['board_name'];
        
        file_put_contents('config', '<?php return ' . var_export($config, true) . ';');
        
        header("location: ?p=4&pin_notif=success&#mark-pin");
        exit();**/

    }
    else
    {

        /*
        $board_name_for_pins = "";
        header("location: ?p=4&pin_notif=failed#mark-pin");
        exit();
        */
    }

} //


if (isset($_POST['toggle_pin']))
{
    /*
    pin_name
    pin_num
    pin_desc
    board_name
    active
    */
    $id = $_POST['id'];
    $mytoggle = $_POST['mytoggle'];

    if (empty($mytoggle)) $mytoggle = 0;
    else $mytoggle = 1;

    //get board name
    $sql = "SELECT * FROM tbl_pins WHERE id = '$id' ";
    $result = mysqli_query($conn, $sql);
    $board_name = "";
    if (mysqli_num_rows($result) > 0)
    {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result))
        {
            $board_name = $row['board_name'];
        }
    }

    $sql = "UPDATE tbl_pins SET " .

    " active = $mytoggle " .

    "WHERE id = '$id' ";

    if ($conn->query($sql) === true)
    {
        //update url
        update_list($board_name);

        header("location: ?p=4&pin_notif=update-pin-success&$mytoggle#mark-pin");
        exit();
    }
    else
    {
        header("location: ?p=4&pin_notif=update-pin-failed&$mytoggle#mark-pin");
        exit();
    }
	
	

} //


if (isset($_POST['edit_pin']))
{
    /*
    pin_name
    pin_num
    pin_desc
    board_name
    active
    */
    $id = $_POST['id'];
    $pin_name = $_POST['pin_name'];
    $pin_num = $_POST['pin_num'];
    $pin_desc = $_POST['pin_desc'];
    $active = $_POST['active'];

    //get board name
    $sql = "SELECT * FROM tbl_pins WHERE id = '$id' ";
    $result = mysqli_query($conn, $sql);
    $board_name = "";
    if (mysqli_num_rows($result) > 0)
    {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result))
        {
            $board_name = $row['board_name'];
        }
    }

    $sql = "UPDATE tbl_pins SET " .

    " pin_desc = '$pin_desc', " . " pin_name = '$pin_name', " . " active = '$active' " .

    "WHERE id = '$id' ";

    if ($conn->query($sql) === true)
    {

        //*********** UPDATE UPDATE UPDATE ************************
        //*********** UPDATE UPDATE UPDATE ************************
        //*********** UPDATE UPDATE UPDATE ************************
        //*********** UPDATE UPDATE UPDATE ************************
        //update url
        update_list($board_name);

        header("location: ?p=4&pin_notif=update-pin-success#mark-pin");
        exit();
    }
    else
    {
        //header("location: ?p=4&pin_notif=" . $conn->error . "#mark-pin");
        header("location: ?p=4&pin_notif=update-pin-failed#mark-pin");
        exit();
    }
} //


if (isset($_POST['edit_settings']))
{

    $config = include 'config';
    //$server_refresh_sec = $config['server_refresh_sec'];
    //$ipaddress = $config['ipaddress'];
    

    //$ipaddress_post = $_POST['ipaddress'];
    $mobile_number_post = $_POST['mobile_number'];
    //$server_refresh_sec_post = $_POST['server_refresh_sec'];

    $config = include 'config';
    $config['mobile_number'] = $mobile_number_post;
    //$config['ipaddress'] = $ipaddress_post;
    //$config['server_refresh_sec'] = $server_refresh_sec_post;
    file_put_contents('config', '<?php return ' . var_export($config, true) . ';');
    //echo "dddd ".$server_refresh_sec_post;
    

    //check if this ip is default machine
    //updat default and non-default
    //$sql = "UPDATE tbl_servers SET " . " refresh_sec = '$server_refresh_sec_post' " . "WHERE server_ip = '$ipaddress_post' ";
    //$conn->query($sql);

    header("location: ?p=4&general_notif=settings-update-successful");
    exit();

} //


if (isset($_POST['edit_board']))
{
    $com_port = $_POST['com_port'];
    $board_name = $_POST['board_name'];
    $board_desc = $_POST['board_desc'];
    $server_name = $_POST['server_name'];
    $board_type = $_POST['board_type'];
    $refresh_sec = $_POST['refresh_sec'];

    $sql = "UPDATE tbl_boards SET " .

    " board_desc = '$board_desc', " . " server_name = '$server_name', " . " com_port = '$com_port', " . " refresh_sec = '$refresh_sec', " . " board_type = '$board_type' " .

    "WHERE board_name = '$board_name' ";

    if ($conn->query($sql) === true)
    {
        //*********** UPDATE UPDATE UPDATE ************************
        //*********** UPDATE UPDATE UPDATE ************************
        //*********** UPDATE UPDATE UPDATE ************************
        //*********** UPDATE UPDATE UPDATE ************************
        //update url
        update_list($board_name);
        create_batch_file_monitor($board_name);

        header("location: ?p=4&board_notif=update-board-success#mark-board");
        exit();
    }
    else
    {
        //header("location: ?p=4&board_notif=" . $conn->error . "#mark-board");
        header("location: ?p=4&board_notif=update-board-failed#mark-board");
        exit();
    }
} //


if (isset($_POST['edit_server']))
{
    /*
    server_desc
    server_ip
    server_location
    server_timezone
    htdocs_dir
    exe_dir
    */
    $server_name = $_POST['server_name'];
    $server_desc = $_POST['server_desc'];
    $server_ip = $_POST['server_ip'];
    $refresh_sec = $_POST['refresh_sec'];
    $active = $_POST['active'];
    $server_location = $_POST['server_location'];
    $server_timezone = $_POST['server_timezone'];
    $htdocs_dir = addslashes($_POST['htdocs_dir']);
    $exe_dir = addslashes($_POST['exe_dir']);

    $config = include 'config';
    $ipaddress = $config['ipaddress'];

    //$ipaddress;
    

    if ($ipaddress == $server_ip)
    {
        //$config = include 'config';
        //$config['ipaddress']= $ipaddress_post;
        $config = include 'config';
        $config['server_refresh_sec'] = $refresh_sec;
        file_put_contents('config', '<?php return ' . var_export($config, true) . ';');
    }

    $sql = "UPDATE tbl_servers SET " .

    " server_desc = '$server_desc', " . " server_ip = '$server_ip', " . " server_location = '$server_location', " . " server_timezone = '$server_timezone', " . " refresh_sec = '$refresh_sec', " . " active = $active, " . " htdocs_dir = '$htdocs_dir', " . " exe_dir = '$exe_dir' " . "WHERE server_name = '$server_name' ";

    if ($conn->query($sql) === true)
    {

        //update batch file
        $sql = "SELECT * FROM tbl_boards ";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $board_name = $row['board_name'];
                update_list($board_name);
                create_batch_file_monitor($board_name);
            }
        }

        //<a href='#' data-toggle='modal' data-target='#alert_msg' data-alert_msg=''></a>
        //echo '<script type="text/javascript"> $("#alert_msg").modal("show")</script>';
        //echo "<script type='text/javascript'> $(window).load(function(){ $('#alert_msg').modal('show'); }); </script>";
        //$show_modal = true;
        

        header("location: ?p=4&server_notif=update-server-success#mark-server");
        exit();
    }
    else
    {
        //header("location: ?p=4&server_notif=" . $conn->error . "#mark-server");
        header("location: ?p=4&server_notif=update-server-failed#mark-server");
        exit();
    }

}

if (isset($_POST['delete_server']))
{
    $server_name = $_POST['server_name'];

    //
    $sql = "DELETE FROM tbl_url WHERE server_name='$server_name'";
    if (mysqli_query($conn, $sql))
    {
        //do nothing
        
    }

    //clear server name on boards
    $sql = "SELECT * FROM tbl_boards WHERE  server_name ='$server_name'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            $board_name = $row['board_name'];
            $sql = "UPDATE tbl_boards SET server_name = '' WHERE board_name = '$board_name' ";
            $conn->query($sql);
        }
    }

    // sql to delete a record
    $sql = "DELETE FROM tbl_servers WHERE server_name='$server_name'";

    if (mysqli_query($conn, $sql))
    {
        //echo "Record deleted successfully";
        header("location: ?p=4&server_notif=delete-server-success#mark-server");
        exit();
    }
    else
    {
        //echo "Error deleting record: " . mysqli_error($conn);
        header("location: ?p=4&server_notif=delete-server-failed#mark-server");
        exit();
    }
}

if (isset($_POST['delete_board']))
{
    $board_name = $_POST['board_name'];

    $config = include 'config';
    $config['board_name_monitored'] = "";

    file_put_contents('config', '<?php return ' . var_export($config, true) . ';');

    // sql to delete a record
    $sql = "DELETE FROM tbl_boards WHERE board_name='$board_name'";

    if (mysqli_query($conn, $sql))
    {
        //
        
    }

    $sql = "DELETE FROM tbl_url WHERE board_name='$board_name'";
    if (mysqli_query($conn, $sql))
    {
        //
        
    }

    $sql = "SELECT * FROM tbl_boards WHERE  board_name ='$board_name'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            $server_name = $row['server_name'];
        }
    }

    $sql = "SELECT * FROM tbl_servers WHERE  server_name ='$server_name' ";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            $exe_dir = $row['exe_dir'];
        }
    }

    //delete batch files, output, dht, input, limits
    $file_batch = "batchfile\\$board_name.porttymon.bat";
    if (file_exists($file_batch))
    {
        unlink($file_batch);
    }

    $file_limits = "exe\\conf\\$board_name.limits";
    if (file_exists($file_limits))
    {
        unlink($file_limits);
    }

    $file_dht = "exe\\conf\\$board_name.dht";
    if (file_exists($file_dht))
    {
        unlink($file_dht);
    }

    $file_out = "exe\\conf\\$board_name.output";
    if (file_exists($file_out))
    {
        unlink($file_out);
    }

    $file_in = "exe\\conf\\$board_name.input";
    if (file_exists($file_in))
    {
        unlink($file_in);
    }

    $file_in = "exe\\conf\\$board_name.tmp";
    if (file_exists($file_in))
    {
        unlink($file_in);
    }

    $sql = "DELETE FROM tbl_pins WHERE board_name='$board_name'";

    if (mysqli_query($conn, $sql))
    {
        //echo "Record deleted successfully";
        header("location: ?p=4&board_notif=delete-board-success#mark-board");
        exit();
    }
    else
    {
        //echo "Error deleting record: " . mysqli_error($conn);
        //header("location: ?p=4&board_notif=" . mysqli_error($conn));
        header("location: ?p=4&board_notif=delete-board-failed#mark-board");
        exit();
    }

} //


if (isset($_POST['submit_server']))
{
    /*
    server_name
    server_desc
    server_ip
    server_location
    server_timezone
    htdocs_dir
    exe_dir
    */
    $server_name = $_POST['server_name'];
    $server_desc = $_POST['server_desc'];
    $server_ip = $_POST['server_ip'];
    //$refresh_sec = $_POST['refresh_sec'];
    $server_location = $_POST['server_location'];
    $server_timezone = $_POST['server_timezone'];
    $refresh_sec = $_POST['refresh_sec'];
    $htdocs_dir = addslashes($_POST['htdocs_dir']);
    $exe_dir = addslashes($_POST['exe_dir']);

    $server_name = str_replace(" ", "_", $server_name);

    //update batch file
    $sql = "SELECT * FROM tbl_boards ";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            $board_name = $row['board_name'];
            update_list($board_name);
            create_batch_file_monitor($board_name);
        }
    }

    $sql = "INSERT INTO tbl_servers (active, server_name, server_desc, server_ip, server_location, server_timezone, htdocs_dir, exe_dir, refresh_sec)
  	VALUES (1, '$server_name', '$server_desc', '$server_ip', '$server_location', '$server_timezone', '$htdocs_dir', '$exe_dir', '$refresh_sec')";

    if ($conn->query($sql) === true)
    {
        //echo "New record created successfully";
        header("location: ?p=4&server_notif=new-server-added-successfull#mark-server");
        exit();
    }
    else
    {
        //echo "Error: " . $sql . "<br>" . $conn->error;
        header("location: ?p=4&server_notif=new-server-creation-failed#mark-server");
        exit();
    }
    //$conn->close();
    
}

if (isset($_POST['submit_board']))
{
    /*
    board_name
    board_desc
    board_location
    server_name
    active
    */
    $board_name = $_POST['board_name'];
    $board_desc = $_POST['board_desc'];
    $server_name = $_POST['server_name'];
    $refresh_sec = $_POST['refresh_sec'];
    $com_port = $_POST['com_port'];
    //$refresh_sec = $_POST['refresh_sec'];
    $board_type = $_POST['board_type'];
    $active = $_POST['active'];

    $board_name = str_replace(" ", "_", $board_name);

    $sql = "INSERT INTO tbl_boards (board_name, board_desc, server_name, active, board_type, com_port, refresh_sec)
  	VALUES ('$board_name', '$board_desc', '$server_name', '$active', '$board_type', '$com_port', '$refresh_sec')";
    $conn->query($sql);

    //if ($conn->query($sql) === TRUE) {
    //echo "New record created successfully";
    //header("location: ?p=4&board_notif=new-board-added-successfull");
    //exit();
    //}
    //$conn->close();
    

    /*
    pin_name
    pin_desc
    pin_num
    server_name
    active				
    */

    if ($board_type == 'uno') $total_pins = 19;
    else $total_pins = 69;

    for ($x = 0;$x <= $total_pins;$x++)
    {

        $sql = "INSERT INTO tbl_pins (pin_num, pin_desc, pin_name, board_name, active)
  		VALUES ('$x', 'default_desc', 'default_name', '$board_name', '$active')";
        $conn->query($sql);

        //if ($conn->query($sql) === TRUE) {
        //do nothing
        //}
        
    }

    //*********** UPDATE UPDATE UPDATE ************************
    //*********** UPDATE UPDATE UPDATE ************************
    //*********** UPDATE UPDATE UPDATE ************************
    //*********** UPDATE UPDATE UPDATE ************************
    //update api based
    update_list($board_name);
    create_batch_file_monitor($board_name);

    header("location: ?p=4&board_notif=new-board-added-successfull#mark-board");
    exit();

}

?>

  
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>PORTTY Admin Dashboard</title>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>     
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
      href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
      rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="clean-switch/clean-switch.css">
	
  <script src="js/zingchart.min.js"></script>
  <!--<script src="https://cdn.zingchart.com/zingchart.min.js"></script>-->
  <style>
    html,
    body {
      height: 100%;
      width: 100%;
      margin: 0;
      padding: 0;
    }
 
    #myChart {
      margin: 0 auto;
      height: 380px;
      width: 98%;
      box-shadow: 5px 5px 5px #eee;
      background-color: #fff;
      border: 1px solid #eee;
      display: flex;
      flex-flow: column wrap;
    }
 
    .controls--container {
      display: flex;
      align-items: center;
      justify-content: center;
    }
 
    .controls--container button {
      margin: 40px;
      padding: 15px;
      background-color: #FF4081;
      border: none;
      color: #fff;
      box-shadow: 5px 5px 5px #eee;
      font-size: 16px;
      font-family: Roboto;
      cursor: pointer;
      transition: .1s;
    }
 
    .controls--container button:hover {
      opacity: .9;
    }
 
    /*button movement*/
 
    .controls--container button:active {
      border-width: 0 0 2px 0;
      transform: translateY(8px);
      opacity: 0.9;
    }
 
    .zc-ref {
      display: none;
    }
  </style>

<script>//device initial update
/*
$(document).ready(function() {
     var refresh = function () {
	//uptime.php p4	 
	$('#uptime').load('?p=4&s=<?php echo $session_id; ?>&ty=<?php echo $type; ?>');
     }
     setInterval(refresh, 1000);
     refresh();
});
*/
</script>	
	
  </head>
  <body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
      <!-- Sidebar -->
      <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
		</br>
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
          <!--<div class="sidebar-brand-icon">            
			<i class="far fa-user-alien"></i>
          </div>-->
		  
<?php 



?>		  
		  
          <div class="sidebar-brand-text mx-3">PORTTY Command Center
		  <!--</br>
		  
		  <div id="uptime" style="font-size: 12px">Loading...</div>-->
		  </div>
          
        </a>
		</br>
        <!-- Divider -->
        <hr class="sidebar-divider my-0">
      
        <!-- Divider
        <hr class="sidebar-divider"> -->
        <!-- Heading -->
        <div class="sidebar-heading">
          Interface
        </div>
		
		
        <!-- Nav Item - Pages Collapse Menu -->
        <!--
		<li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Switch Boards</span>
          </a>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Custom Components:</h6>
              <a class="collapse-item" href="buttons.php">Buttons</a>
              <a class="collapse-item" href="cards.php">Cards</a>
            </div>
          </div>
        </li>
		-->
		
		
        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Scheduler</span>
          </a>
          <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Custom Utilities:</h6>
              <a class="collapse-item" href="#">Single Time Trigger</a>
              <a class="collapse-item" href="#">On-Time Trigger</a>
              <a class="collapse-item" href="#p">Repeating Trigger</a>
              
            </div>
          </div>
        </li>
		
        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Limits</span>
          </a>
          <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Custom Utilities:</h6>
              <a class="collapse-item" href="#">DHT</a>
              <a class="collapse-item" href="#">PH</a>
              <a class="collapse-item" href="#p">Levels</a>
              <a class="collapse-item" href="#">Other</a>
            </div>
          </div>
        </li>		
		
        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">
          Addons
        </div>
        <!-- Nav Item - Pages Collapse Menu -->
        <!--
		<li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-folder"></i>
          <span>Pages</span>
          </a>
          <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Login Screens:</h6>
              <a class="collapse-item" href="login.php">Login</a>
              <a class="collapse-item" href="register.php">Register</a>
              <a class="collapse-item" href="forgot-password.php">Forgot Password</a>
              <div class="collapse-divider"></div>
              <h6 class="collapse-header">Other Pages:</h6>
              <a class="collapse-item" href="404.php">404 Page</a>
              <a class="collapse-item" href="blank.php">Blank Page</a>
            </div>
          </div>
        </li>
		-->
        <!-- Nav Item - Charts -->
        <li class="nav-item">
          <a class="nav-link" href="#mark-server">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Servers</span></a>
        </li>
        <!-- Nav Item - Charts -->
        <li class="nav-item">
          <a class="nav-link" href="#mark-board">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Boards</span></a>
        </li>
        <!-- Nav Item - Charts -->
        <li class="nav-item">
          <a class="nav-link" href="#mark-pin">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Pins</span></a>
        </li>
  
     
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
		
        <!-- Sidebar Message -->
        
		<div class="sidebar-card d-none d-lg-flex">
          <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
          <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
          <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
        </div>
	
      </ul>
      <!-- End of Sidebar -->
      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
          <!-- Topbar -->
          <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
            </button>
            <!-- Topbar Search -->
			
				<a href="?p=14" target="_blank" class="btn btn-primary btn-icon-split" >
                <span class="icon text-white-50">
                <i class="fas fa-flag"></i>
                </span>
                <span class="text">Start Worker Page</span>										
                </a>	

                <div class="my-2">
                  <p>&nbsp;&nbsp;<?php echo $general_notif; ?></p>
                </div>				
			
			<!--<span class="text"> ...worker running</span>				-->
            <!--
              <form
                  class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                  <div class="input-group">
                      <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                          aria-label="Search" aria-describedby="basic-addon2">
                      <div class="input-group-append">
                          <button class="btn btn-primary" type="button">
                              <i class="fas fa-search fa-sm"></i>
                          </button>
                      </div>
                  </div>
              </form>-->
            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
              <!-- Nav Item - Search Dropdown (Visible Only XS) -->
              <li class="nav-item dropdown no-arrow d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                  aria-labelledby="searchDropdown">
                  <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                      <input type="text" class="form-control bg-light border-0 small"
                        placeholder="Search for..." aria-label="Search"
                        aria-describedby="basic-addon2">
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </li>
              <!-- Nav Item - Alerts -->
              <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-bell fa-fw"></i>
                  <!-- Counter - Alerts -->
                  <span class="badge badge-danger badge-counter">3+</span>
                </a>
                <!-- Dropdown - Alerts -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                  aria-labelledby="alertsDropdown">
                  <h6 class="dropdown-header">
                    Alerts Center
                  </h6>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                      <div class="icon-circle bg-primary">
                        <i class="fas fa-file-alt text-white"></i>
                      </div>
                    </div>
                    <div>
                      <div class="small text-gray-500">December 12, 2019</div>
                      <span class="font-weight-bold">A new monthly report is ready to download!</span>
                    </div>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                      <div class="icon-circle bg-success">
                        <i class="fas fa-donate text-white"></i>
                      </div>
                    </div>
                    <div>
                      <div class="small text-gray-500">December 7, 2019</div>
                      $290.29 has been deposited into your account!
                    </div>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                      <div class="icon-circle bg-warning">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                      </div>
                    </div>
                    <div>
                      <div class="small text-gray-500">December 2, 2019</div>
                      Spending Alert: We've noticed unusually high spending for your account.
                    </div>
                  </a>
                  <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                </div>
              </li>
              <!-- Nav Item - Messages -->
              <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-envelope fa-fw"></i>
                  <!-- Counter - Messages -->
                  <span class="badge badge-danger badge-counter">7</span>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                  aria-labelledby="messagesDropdown">
                  <h6 class="dropdown-header">
                    Message Center
                  </h6>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="dropdown-list-image mr-3">
                      <img class="rounded-circle" src="img/undraw_profile_1.svg"
                        alt="...">
                      <div class="status-indicator bg-success"></div>
                    </div>
                    <div class="font-weight-bold">
                      <div class="text-truncate">Hi there! I am wondering if you can help me with a
                        problem I've been having.
                      </div>
                      <div class="small text-gray-500">Emily Fowler · 58m</div>
                    </div>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="dropdown-list-image mr-3">
                      <img class="rounded-circle" src="img/undraw_profile_2.svg"
                        alt="...">
                      <div class="status-indicator"></div>
                    </div>
                    <div>
                      <div class="text-truncate">I have the photos that you ordered last month, how
                        would you like them sent to you?
                      </div>
                      <div class="small text-gray-500">Jae Chun · 1d</div>
                    </div>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="dropdown-list-image mr-3">
                      <img class="rounded-circle" src="img/undraw_profile_3.svg"
                        alt="...">
                      <div class="status-indicator bg-warning"></div>
                    </div>
                    <div>
                      <div class="text-truncate">Last month's report looks great, I am very happy with
                        the progress so far, keep up the good work!
                      </div>
                      <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                    </div>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="dropdown-list-image mr-3">
                      <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                        alt="...">
                      <div class="status-indicator bg-success"></div>
                    </div>
                    <div>
                      <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                        told me that people say this to all dogs, even if they aren't good...
                      </div>
                      <div class="small text-gray-500">Chicken the Dog · 2w</div>
                    </div>
                  </a>
                  <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                </div>
              </li>
              <div class="topbar-divider d-none d-sm-block"></div>
              <!-- Nav Item - User Information -->
              <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $fullname; ?></span>
                <img class="img-profile rounded-circle"
                  src="img/undraw_profile.svg">
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                  aria-labelledby="userDropdown">
                  <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                  </a>
                  
				  <?php
echo "
				  <a class='dropdown-item'  href='#' data-toggle='modal' data-target='#editSettings' >
                  <i class='fas fa-cogs fa-sm fa-fw mr-2 text-gray-400'></i>
                  Settings				  
				  </a>";
?>

             
                  <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                  </a>
                  <a class="dropdown-item" href="?p=8">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Set Password
                  </a>								
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="?p=7" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                  </a>
                </div>
              </li>
            </ul>
          </nav>
          <!-- End of Topbar -->
		  
		  
		  
		  
		  
          <!-- Begin Page Content -->
          <div class="container-fluid">
		  
	            
		  
		  
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 class="h3 mb-0 text-gray-800">Switch Board <?php echo "<b class='text-success'>[ " . $online_text . " ]</b>"; ?></h1>
              <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
            </div>
            <!--<a class="dropdown-item" href="?p=7" data-toggle="modal" data-target="#logoutModal">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Logout
              </a>-->
            <!--
              <a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#addServer">
                                             <span class="icon text-white-50">
                                                 <i class="fas fa-flag"></i>
                                             </span>
                                             <span class="text">Add Servers</span>										
                                         </a>									
              								
              <a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#addBoard">
                                             <span class="icon text-white-50">
                                                 <i class="fas fa-flag"></i>
                                             </span>
                                             <span class="text">Add Boards</span>										
                                         </a>
              <div class="my-4"></div>
              -->
            <!-- Content Row -->
            <div class="row">
              <!-- Earnings (Monthly) Card Example -->
              <div class="col-xl-3 col-md-6 mb-4 ">
                <div class="card border-left-primary shadow h-100 py-2 bg-gradient-primary">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center ">
                      <div class="col mr-2">
                        <div class="text-md font-weight-bold text-gray-100 text-uppercase mb-1">
                          Servers (<?php echo $online_servers + $offline_servers; ?>)
                        </div>
                        <div class="h2 mb-0 font-weight-bold text-gray-100"><?php echo $online_servers . "/" . $offline_servers; ?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-server fa-3x text-gray-100"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Earnings (Monthly) Card Example -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2 bg-gradient-primary">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-md font-weight-bold text-gray-100 text-uppercase mb-1">
                          Boards (<?php echo $online_boards + $offline_boards; ?>)
                        </div>
                        <div class="h2 mb-0 font-weight-bold text-gray-100"><?php echo $online_boards . "/" . $offline_boards; ?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-microchip fa-3x text-gray-100"></i>											
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Earnings (Monthly) Card Example -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2 bg-gradient-primary">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-md font-weight-bold text-gray-100 text-uppercase mb-1">
                          Pins (<?php echo $online_switches + $offline_switches; ?>)
                        </div>
                        <div class="h2 mb-0 font-weight-bold text-gray-100"><?php echo $online_switches . "/" . $offline_switches; ?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-toggle-on fa-3x text-gray-100"></i>											
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Earnings (Monthly) Card Example -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2 bg-gradient-primary">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-md font-weight-bold text-gray-100 text-uppercase mb-1">
                          DHT (<?php echo $online_boards + $offline_boards; ?>)
                        </div>
                        <div class="h2 mb-0 font-weight-bold text-gray-100"><?php echo $online_boards . "/" . $offline_boards; ?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-thermometer-half fa-3x text-gray-100"></i>							
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			
			







			<h2 id="mark-monitor"></h2>
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary">Realtime DHT Monitoring [ <?php echo $board_name_monitored; ?> ]</h4>
                <div class="my-2">
                  <p><?php echo $monitor_notif; ?></p>
                </div>
                <a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#selectBoardToMonitor" " >
                <span class="icon text-white-50"> 
				<i class="fas fa-chart-line fa-3x text-gray-100"></i>
				

                </span>
                <span class="text">Select Board</span>										
                </a>
              </div>







			
			
            <div class="row">
			<div class="col-lg-12 mb-4">
			<div class="card shadow mb-4">			
				<div id="myChart">
					<a class="zc-ref" href="https://www.zingchart.com">Powered by ZingChart</a>
				</div>	
  <div class="controls--container">
    <button id="clear">Clear</button>
    <button id="stop">Stop</button>
    <button id="start">Start</button>
    <!--<button id="random">Randomize Interval</button>-->
    <span id="output"></span>
  </div>				
			</div>	
			</div>	
			</div>	


				
			
			<!--
            <div class="row">
              <div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <!--<div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Max Temperature</h6>
                    <div class="dropdown no-arrow">
                      <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Dropdown Header:</div>
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                      </div>
                    </div>
                  </div>
                  <!-- Card Body -->
                  <!--<div class="card-body">
                    <div class="chart-area">
                      <canvas id="myAreaChart"></canvas>
                                           
                    </div>	
                  </div>
                </div>
              </div>
			    <!-- CHART CONTAINER -->
	  
              <!--<div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <!--<div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Max Humidity</h6>
                    <div class="dropdown no-arrow">
                      <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Dropdown Header:</div>
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                      </div>
                    </div>
                  </div>
                  <!-- Card Body -->
                  <!--<div class="card-body">
                    <div class="chart-area">
                      <canvas id="myAreaChart2"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>-->
            <!-- Page Heading -->
            <!--<h1 class="h3 mb-2 text-gray-800">Tables</h1>
              <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                  For more information about DataTables, please visit the <a target="_blank"
                      href="https://datatables.net">official DataTables documentation</a>.</p>-->
            <!--<a href="html_demo.html#server">Jump to Chapter 4</a>
              <h2 id="C4">Chapter 4</h2>
              <a href="#C4">Jump to Chapter 4</a>-->
            <!-- SERVER BOOKMARK -->
            <h2 id="mark-server"></h2>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary">Servers</h4>
                <div class="my-2">
                  <p><?php echo $server_notif; ?></p>
                </div>
                <a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#addServer" data-id="@getbootstrap" >
                <span class="icon text-white-50">
                <!--<i class="fas fa-flag"></i>-->
				<i class="fas fa-server fa-3x text-gray-100"></i>
                </span>
                <span class="text">Add Servers</span>										
                </a>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="display table table-bordered" id="" width="100%" cellspacing="0">
                    <thead>
                      <tr>
					    
						<th>trash</th>
						<th>edit</th>
                        <th>active</th>
                        <th>web</th>
                        <th>page</th>
                        <th>server_name</th>
                        <th>server_desc</th>
                        <th>server_ip</th>
                        <th>server_location</th>
                        <th>server_timezone</th>
                        <th>htdocs_dir</th>
                        <th>exe_dir</th>
						<th>refresh_sec</th>
                       
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
             		<th>trash</th>
						<th>edit</th>
                        <th>active</th>
                        <th>web</th>
                        <th>page</th>
                        <th>server_name</th>
                        <th>server_desc</th>
                        <th>server_ip</th>
                        <th>server_location</th>
                        <th>server_timezone</th>
                        <th>htdocs_dir</th>
                        <th>exe_dir</th>
						<th>refresh_sec</th>
                                           
                        
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php
/*
                        server_name
                        server_desc
                        server_ip
                        server_location
                        server_timezone
                        htdocs_dir
                        exe_dir
*/

//$board_name_monitored
/*
						$sql = "SELECT * FROM tbl_boards WHERE board_name = '$board_name_monitored' ";
                        $result = mysqli_query($conn, $sql);                        
                        if (mysqli_num_rows($result) > 0) 
                        {
                        	  // output data of each row
                        		while($row = mysqli_fetch_assoc($result)) {
									$server_name = $row["server_name"];	
									$sql = "SELECT * FROM tbl_servers WHERE server_name = '$server_name' ";
								}
                        } else {
							$sql = "SELECT * FROM tbl_servers ";
						}
*/

$sql = "SELECT * FROM tbl_servers   ORDER BY active DESC ";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0)
{
    // output data of each row
    while ($row = mysqli_fetch_assoc($result))
    {

        if ($row["active"])
        {
            $active = "<i class='far fa-check-circle fa-2x text-success'></i>";
        }
        else
        {
            $active = "<i class='far fa-times-circle fa-2x text-danger'></i>";
        }

        if ($row["web_service"])
        {
            $web_service = "<i class='far fa-check-circle fa-2x  text-success'></i>";
        }
        else
        {
            $web_service = "<i class='far fa-times-circle fa-2x  text-danger'></i>";
        }

        if ($row["web_page"])
        {
            $web_page = "<i class='far fa-check-circle fa-2x  text-success'></i>";
        }
        else
        {
            $web_page = "<i class='far fa-times-circle fa-2x  text-danger'></i>";
        }

        if ($row["_default"])
        {
            $_default = "<i class='far fa-check-circle fa-2x  text-success'></i>";
        }
        else
        {
            $_default = "<i class='far fa-times-circle fa-2x  text-danger'></i>";
        }

        echo "<tr>" .
        //"<td>". $i++ . "</td>" .
        //"<td><a href='#' data-toggle='modal' data-target='#alert_msg' class='btn btn-danger btn-circle btn-sm' data-alert_msg='" . $row["server_name"] . "'><i class='fas fa-trash'></i></a></td>" .
        "<td><a href='#' data-toggle='modal' data-target='#delServer' class='btn btn-danger btn-circle btn-sm' data-whatever='" . $row["server_name"] . "'><i class='far fa-trash-alt fa-2x'></a></td>" . "<td><a href='#' data-toggle='modal' data-target='#editServer' class='btn btn-primary btn-circle btn-sm' 
                        data-server_name='" . $row["server_name"] . "' 
                        data-server_desc='" . $row["server_desc"] . "' 
                        data-server_ip='" . $row["server_ip"] . "'
                        data-server_location='" . $row["server_location"] . "'
                        data-server_timezone='" . $row["server_timezone"] . "'
                        data-htdocs_dir='" . $row["htdocs_dir"] . "'
                        data-exe_dir='" . $row["exe_dir"] . "'
                        data-refresh_sec='" . $row["refresh_sec"] . "'
                        data-active='" . $row["active"] . "'
                        ><i class='far fa-edit fa-2x'></i></i></a></td>" .

        "<td>$active</td>" . "<td>$web_service</td>" . "<td>$web_page</td>" . "<td>" . $row["server_name"] . "</td>" . 
		"<td>" . $row["server_desc"] . "</td>" . "<td>" . $row["server_ip"] . "</td>" . 
		"<td>" . $row["server_location"] . "</td>" . "<td>" . $row["server_timezone"] . "</td>" . 
		"<td>" . $row["htdocs_dir"] . "</td>" . 
		"<td>" . $row["exe_dir"] . "</td>" . 
		"<td>" . $row["refresh_sec"] . "</td>" . 
		//"<td>$_default</td>" .

        //"<a href='#' class='btn btn-primary btn-icon-split' data-toggle='modal' data-target='#addServer' data-id='@getbootstrap' ><i class='fas fa-trash'></i></button></td>".
        //"<td><a href='javascript:;' data-toggle='modal' data-target='#deleteServerModal' data-mykey='123456' class='btn btn-danger btn-circle btn-sm'><i class='fas fa-trash'></i></td>" .
        //"<td><a href='javascript:;' data-toggle='modal' data-target='#deleteServerModal' data-id='1' data-name='Computer' data-duration='255' data-date='27-04-2020' > Edit</a></td>" .
        "</tr>";
    }
}
else
{
    //echo "0 results";
    
}

//mysqli_close($conn);



?>
                      <!--
                        <tr>
                            <td>Jonas Alexander</td>
                            <td>Developer</td>
                            <td>San Francisco</td>
                            <td>30</td>
                            <td>2010/07/14</td>
                            <td>$86,500</td>
                        </tr>
                        <tr>
                            <td>Shad Decker</td>
                            <td>Regional Director</td>
                            <td>Edinburgh</td>
                            <td>51</td>
                            <td>2008/11/13</td>
                            <td>$183,000</td>
                        </tr>  -->                                   
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- BOARD BOOKMARK -->
            <h2 id="mark-board"></h2>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary">Boards</h4>
                <div class="my-2">
                  <p><?php echo $board_notif; ?></p>
                </div>
                <a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#addBoard">
                <span class="icon text-white-50">
                <i class="fas fa-microchip fa-3x text-gray-100"></i>	
                </span>
                <span class="text">Add Boards</span>										
                </a>
                <!--<a href="?p=17" class="btn btn-primary btn-icon-split" >-->			
				
				<a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#downloadXloader">
                <span class="icon text-white-50">               
				<i class="fas fa-terminal fa-3x text-gray-100"></i>	
			
                </span>
                <span class="text">XLOADER</span>										
                </a>				
				
                <div class="my-4"></div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="display table table-bordered" id="" width="100%" cellspacing="0">
                    <thead>
                      <tr>
						<th>trash</th>
                         <th>edit</th>	
						
						<th>porttymon</th>
                        <th>board_name</th>
                        <th>board_desc</th>
                        <th>server_name</th>
                        <th>temp</th>
                        <th>hum</th>
                        <th>board_type</th>
						<th>refresh_sec</th>
						<th>com_port</th> 
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>trash</th>
                         <th>edit</th>	
						
						<th>porttymon</th>
                        <th>board_name</th>
                        <th>board_desc</th>
                        <th>server_name</th>
                        <th>temp</th>
                        <th>hum</th>
                        <th>board_type</th>
						<th>refresh_sec</th>
						<th>com_port</th>                        
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php
/*
                        	<th>id</th>
                        	<th>edit</th>
                        	<th>board_name</th>
                        	<th>board_desc</th>
                        	<th>server_name</th>                                            
                        	<th>active</th>                                                                                     
                        	<th>trash</th>
                        
*/

//$board_name_monitored
/*
						$sql = "SELECT * FROM tbl_boards WHERE board_name = '$board_name_monitored' ";
                        $result = mysqli_query($conn, $sql);                        
                        if (mysqli_num_rows($result) > 0) 
                        {
                        	  // output data of each row
                        		while($row = mysqli_fetch_assoc($result)) {
									$board_name = $row["board_name"];	
									$sql = "SELECT * FROM tbl_boards WHERE board_name = '$board_name' ";
								}
                        } else {
							$sql = "SELECT * FROM tbl_boards ";
						}*/

$sql = "SELECT * FROM tbl_boards   ORDER BY monitor DESC ";
$result = mysqli_query($conn, $sql);
$i = 1;
if (mysqli_num_rows($result) > 0)
{
    // output data of each row
    while ($row = mysqli_fetch_assoc($result))
    {

        //if($row["monitor"]){
        //	$mon = "<i class='far fa-check-circle fa-2x'></i>";
        //} else {
        //	$mon = "<i class='far fa-times-circle fa-2x'></i>";
        //}
        

        if ($row["monitor"])
        {
            $mon = "<i class='fas fa-terminal fa-2x'></i>";
            $butt_color = 'btn-primary';
        }
        else
        {
            $mon = "<i class='fas fa-terminal fa-2x'></i>";
            $butt_color = 'btn-danger';
        }

        echo "<tr>" . "<td><a href='#' data-toggle='modal' data-target='#delBoard' class='btn btn-danger btn-circle btn-sm' data-whatever='" . $row["board_name"] . "'><i class='far fa-trash-alt fa-2x'></i></a></td>" . "<td><a href='#' data-toggle='modal' data-target='#editBoard' class='btn btn-primary btn-circle btn-sm' 
									data-board_name='" . $row["board_name"] . "' 
									data-board_desc='" . $row["board_desc"] . "' 
									data-server_name='" . $row["server_name"] . "'
									data-board_type='" . $row["board_type"] . "'						
									data-com_port='" . $row["com_port"] . "'						
									data-refresh_sec='" . $row["refresh_sec"] . "'						
									><i class='far fa-edit fa-2x'></i></a></td>" . 
									"<td><a href='#' data-toggle='modal' data-target='#downloadBatchfile' class='btn " . $butt_color . " btn-circle btn-sm' data-board_name='" . $row["board_name"] . "'>$mon</i></a></td>" .
        //"<td><a href='batchfile/" . $row["board_name"] . ".porttymon.bat'  class='btn " . $butt_color . " btn-circle btn-sm' download>$mon</a></td>" .
        "<td>" . $row["board_name"] . "</td>" . "<td>" . $row["board_desc"] . "</td>" . "<td>" . $row["server_name"] . "</td>" . "<td>" . $row["temp"] . "</td>" . "<td>" . $row["hum"] . "</td>" . "<td>" . $row["board_type"] . "</td>" . "<td>" . $row["refresh_sec"] . "</td>" . "<td>" . $row["com_port"] . "</td>" . "</tr>";
    }
}
else
{
    //echo "0 results";
    
}

//mysqli_close($conn);



?>
                      <!--
                        <tr>
                            <td>Jonas Alexander</td>
                            <td>Developer</td>
                            <td>San Francisco</td>
                            <td>30</td>
                            <td>2010/07/14</td>
                            <td>$86,500</td>
                        </tr>
                        <tr>
                            <td>Shad Decker</td>
                            <td>Regional Director</td>
                            <td>Edinburgh</td>
                            <td>51</td>
                            <td>2008/11/13</td>
                            <td>$183,000</td>
                        </tr>  -->                                   
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        <!-- BOARD BOOKMARK -->
<?php
//$config = include 'config';
//$filter_pins_by_board = $config['filter_pins_by_board'];

?>       

	   <h2 id="mark-pin"></h2>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
             
			 
			 
			  
              <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary">Pins [<?php echo $filter_pins_by_board; ?>]</h4>
                <div class="my-2">
                  <p><?php echo $pin_notif; ?></p>
                </div>
                <a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#selectBoardToPin">
                <span class="icon text-white-50">
                <i class="fas fa-toggle-on fa-3x text-gray-100"></i>	
				
                </span>
                <span class="text">Select Boards</span>										
                </a>
                <div class="my-4"></div>
              </div>			  
			  
			  
			  
			  
			  
			  
			  
              <div class="card-body">
                <div class="table-responsive">
                  <table class="display table table-bordered" id="" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                      <th>edit</th>
						<th>active</th>
						<th>board_name</th>
                        <th>pin_num</th>
                        <th>pin_name</th>
                        <th>pin_desc</th>    
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>edit</th>
						<th>active</th>
						<th>board_name</th>
                        <th>pin_num</th>
                        <th>pin_name</th>
                        <th>pin_desc</th>                        
                        
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php
if (empty($filter_pins_by_board))
{
    $filter_pins_by_board = "%%";
}
$sql = "SELECT * FROM tbl_pins WHERE board_name = '$filter_pins_by_board'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0)
{
    // output data of each row
    while ($row = mysqli_fetch_assoc($result))
    {
        $board_name = $row["board_name"];
        $sql = "SELECT * FROM tbl_pins WHERE board_name = '$board_name'  ORDER BY pin_num ASC ";
    }
}
else
{
    $sql = "SELECT * FROM tbl_pins ";
}

//$sql = "SELECT * FROM tbl_pins ";
$result = mysqli_query($conn, $sql);
$i = 1;
if (mysqli_num_rows($result) > 0)
{
    // output data of each row
    while ($row = mysqli_fetch_assoc($result))
    {

        if ($row["active"])
        {
            $mon = "<i class='far fa-lightbulb fa-2x'></i>";
            $butt_status = 'btn btn-success';
            $toggle_value = true;
        }
        else
        {
            $mon = "<i class='far fa-lightbulb fa-2x'></i>";
            $butt_status = 'btn btn-danger';
            $toggle_value = false;
        }

        echo "<tr>" . "<td><a href='#' data-toggle='modal' data-target='#editPin' class='btn btn-primary btn-circle btn-sm' 
									data-id='" . $row["id"] . "' 
									data-pin_num='" . $row["pin_num"] . "' 
									data-pin_name='" . $row["pin_name"] . "' 
									data-pin_desc='" . $row["pin_desc"] . "' 
									data-board_name='" . $row["board_name"] . "'														
									data-active='" . $row["active"] . "'														
									><i class='far fa-edit fa-2x'></i></a></td>" . "<td><a href='#' data-toggle='modal' data-target='#toggleButton' class='btn " . $butt_status . " btn-circle btn-sm'
									data-id='" . $row["id"] . "'
									data-pin_num='" . $row["pin_num"] . "'
									data-pin_name='" . $row["pin_name"] . " '
									data-pin_desc='" . $row["pin_desc"] . "'
									data-active='" . $toggle_value . "'
									>$mon</a></td>" . "<td>" . $row["board_name"] . "</td>" . "<td>" . $row["pin_num"] . "</td>" . "<td>" . $row["pin_name"] . "</td>" . "<td>" . $row["pin_desc"] . "</td>" . "</tr>";
    }
}

else
{
    //echo "0 results";
    
}

//mysqli_close($conn);



?>
                                                       
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
        <!-- Footer -->
        <footer class="sticky-footer bg-white">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright &copy; Your Website 2021</span>
            </div>
          </div>
        </footer>
        <!-- End of Footer -->
      </div>
      <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="?p=7">Logout</a>
          </div>
        </div>
      </div>
    </div>
	
	
    <!-- toggleButton -->
    <div class="modal fade" id="toggleButton" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
		<form class="user" action="?p=4" method="post">	  
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
          </div>
		  
		  <div class="modal-body">
	
		  
		  
		               <div class="form-group id">
                <!--<label for="recipient-name" class="col-form-label">board_name:</label>-->                                                
                <input type="text" class="form-control" id="id" name="id" hidden>
              </div> 
		  
				  <div class="form-group">					
			
						&nbsp;&nbsp;&nbsp;&nbsp;
						<label class="cl-switch cl-switch-xlarge">
							<input type="checkbox" class="myswtich" name="mytoggle">
							<span class="switcher"></span>
							<span class="label modal-message"></span>
						</label>		  
					  </div>
					  
							  
					  
					  
					  
					  </div>	
					  
					  
					  
					  
					<div class="modal-footer"> 
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>		  
            <button type="submit" class="btn btn-primary" name="toggle_pin" >Submit</button>

          </div>  
				  		  

</form>			
	  
          
        </div>
      </div>
    </div>	
    <script type="text/javascript">
      $('#toggleButton').on('show.bs.modal', function (event) {
        var link = $(event.relatedTarget) // Button that triggered the modal
        var id = link.data('id') // Extract info from data-* attributes
        var pin_num = link.data('pin_num') // Extract info from data-* attributes
        var pin_name = link.data('pin_name') // Extract info from data-* attributes
        var pin_desc = link.data('pin_desc') // Extract info from data-* attributes
        var active = link.data('active') // Extract info from data-* attributes
        var modal = $(this)
        modal.find('.modal-title').text("[ " + pin_num + " ] " + pin_name)
        //modal.find('.modal-body input').val(recipient)
        modal.find('.modal-body .modal-message').text(pin_desc)		   
        //modal.find('.modal-body .cl-switch input').text(active)		   
        modal.find('.modal-body .id input').val(id);   
        modal.find('.modal-body .cl-switch input').prop( "checked", active );           	   
      })           
    </script>		
	
 
	
	

    <!-- Logout Modal-->
    <div class="modal fade" id="alert_msg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Attention!</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
          </div>
			  <div class="modal-body">				
				  <div class="form-group">					
					<h5 class="modal-message"></h5>
				  </div>
				  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				  <button type="submit" class="btn btn-primary" name="delete_server" >Delete</button>
			  </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Continue</button>            
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      $('#alert_msg').on('show.bs.modal', function (event) {
        var link = $(event.relatedTarget) // Button that triggered the modal
        var alert_msg = link.data('alert_msg') // Extract info from data-* attributes
        var modal = $(this)        
        modal.find('.modal-body .modal-message').text(alert_msg)		   
      })           
    </script> 	
	
    <!-- SELECT BOARD TO MONITOR -->
    <div class="modal fade" id="selectBoardToMonitor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
		<form class="user" action="?p=4" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Select Active Board to Monitor</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
             
			  
              <div class="form-group board_name">
                <label for="inputState">board_name:</label>
                <select id="inputState" class="form-control" name="board_name">					
				<option class="default-board-name" selected ><?php echo $board_name_monitored; ?></option>
				
				<?php
echo $board_name_list_option_active;
?>
                </select>
              </div>

 </div>			

 <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="selectBoardToMonitor" >Monitor</button>	
</div>			  
            </form>
         
		  
		  
		  
        </div>
      </div>
    </div>	
	
    <!-- SELECT BOARD TO SHOW PINS -->
    <div class="modal fade" id="selectBoardToPin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          
		  <form class="user" action="?p=4" method="post">
		  <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Select Board</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
             
			  
              <div class="form-group board_name">
                <label for="inputState">board_name:</label>
                <select id="inputState" class="form-control" name="board_name">					
				
				<option class="default-board-name" selected ><?php echo $filter_pins_by_board; ?></option>				
				<option >Select All</option>				
				<?php
echo $board_name_list_option;
?>
                </select>
              </div>
 </div>

			  <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="selectBoardToPin" >Select</button>	
 </div>
			  
            </form>
         
        </div>
      </div>
    </div>		
	
	
	
	
	
    <!-- DOWNLOAD BATCHFILE -->
    <!-- DOWNLOAD BATCHFILE -->
    <!-- DOWNLOAD BATCHFILE -->
    <!-- DOWNLOAD BATCHFILE -->
    <div class="modal fade" id="downloadBatchfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

          
            <form class="user" action="?p=4" method="post">  

          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Download Script</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
			
				<div class="modal-body">
				
				
				<h5 class="command_line" ></h5>
					  


			 </div>  


					<div class="modal-footer"> 
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Abort</button>             		  
			<input id="download" class="btn btn-primary " type="button" value="Download" data-dismiss="modal" />

          </div> 

            </form>
         
        </div>
      </div>
    </div>		
		
	
    <script type="text/javascript">
	
	
      $('#downloadBatchfile').on('show.bs.modal', function (event) {
		  
        var link = $(event.relatedTarget) // Button that triggered the modal
        var board_name = link.data('board_name') // Extract info from data-* attributes
        var modal = $(this)        
        modal.find('.modal-body h5').text('Download porttymon script for board ' + board_name)	
		
		
		document.getElementById("download").onclick = function () { 
		
          
			var fileName = board_name + '.porttymon.bat';
            var url = "batchfile/" + fileName;	
 
     
            var req = new XMLHttpRequest();
            req.open("GET", url, true);
            req.responseType = "blob";
            req.onload = function () {
             
                var blob = new Blob([req.response], { type: "application/octetstream" });
 
            
                var isIE = false || !!document.documentMode;
                if (isIE) {
                    window.navigator.msSaveBlob(blob, fileName);
                } else {
                    var url = window.URL || window.webkitURL;
                    link = url.createObjectURL(blob);
                    var a = document.createElement("a");
                    a.setAttribute("download", fileName);
                    a.setAttribute("href", link);
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                }
            };
            req.send();		
		
		
		};
		
		
		
		
		
 

		
      }); 	
	
	
	

	
</script>

    <!-- DOWNLOAD BATCHFILE -->
    <!-- DOWNLOAD BATCHFILE -->
    <!-- DOWNLOAD BATCHFILE -->
    <!-- DOWNLOAD BATCHFILE -->


  
	
	
	
   <!-- DOWNLOAD BATCHFILE -->
    <!-- DOWNLOAD BATCHFILE -->
    <!-- DOWNLOAD BATCHFILE -->
    <!-- DOWNLOAD BATCHFILE -->
    <div class="modal fade" id="downloadXloader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

          
            <form class="user" action="?p=4" method="post">  

          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Download Script</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
			
				<div class="modal-body">
				<h5 class="command_line" ></h5>
			 </div>  
					<div class="modal-footer"> 
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Abort</button>             		  
			<input id="downloadx" class="btn btn-primary " type="button" value="Download" data-dismiss="modal" />
          </div> 
            </form>         
        </div>
      </div>
    </div>		
		
	
    <script type="text/javascript">
	
	
      $('#downloadXloader').on('show.bs.modal', function (event) {
		  
        var link = $(event.relatedTarget) // Button that triggered the modal
        var board_name = link.data('board_name') // Extract info from data-* attributes
        var modal = $(this)        
        modal.find('.modal-body h5').text('download xloader?')	
		
		
		document.getElementById("downloadx").onclick = function () { 
		
          
			var fileName = 'xloader.bat';
            var url = "batchfile/" + fileName;	
 
     
            var req = new XMLHttpRequest();
            req.open("GET", url, true);
            req.responseType = "blob";
            req.onload = function () {
             
                var blob = new Blob([req.response], { type: "application/octetstream" });
 
            
                var isIE = false || !!document.documentMode;
                if (isIE) {
                    window.navigator.msSaveBlob(blob, fileName);
                } else {
                    var url = window.URL || window.webkitURL;
                    link = url.createObjectURL(blob);
                    var a = document.createElement("a");
                    a.setAttribute("download", fileName);
                    a.setAttribute("href", link);
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                }
            };
            req.send();		
		
		
		};
		
		
		
		
		
 

		
      }); 	
	
	
	

	
</script>

    <!-- DOWNLOAD BATCHFILE -->
    <!-- DOWNLOAD BATCHFILE -->
    <!-- DOWNLOAD BATCHFILE -->
    <!-- DOWNLOAD BATCHFILE -->	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
    <!-- SERVER -->
    <div class="modal fade" id="delServer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
         


<form class="user" action="?p=4" method="post">
		 <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete Server</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
              <div class="form-group">
                <input type="text" class="form-control" id="server_name" name="server_name" hidden>
                <h5 class="modal-message"></h5>
              </div>
				 
            
          </div>
		   <div class="modal-footer">
		                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="delete_server" >Delete</button>	
			     </div>
		  </form>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      $('#delServer').on('show.bs.modal', function (event) {
        var link = $(event.relatedTarget) // Button that triggered the modal
        var recipient = link.data('whatever') // Extract info from data-* attributes
        var modal = $(this)
        modal.find('.modal-body input').val(recipient)
        modal.find('.modal-body .modal-message').text('Are you sure you want to delete ' + recipient + '?')		   
      })           
    </script>	 	  	
    <!-- SERVER -->
    <div class="modal fade" id="delBoard" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          
		  
		  <form class="user" action="?p=4" method="post">
		  <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete Board</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
              <div class="form-group">
                <input type="text" class="form-control" id="board_name" name="board_name" hidden>
                <h5 class="modal-message"></h5>
              </div>
				 
          
          </div>
		  <div class="modal-footer"> 
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="delete_board" >Delete</button>			  
		  </div>
		    </form>
		  
		  
        </div>
      </div>
    </div>
    <script type="text/javascript">
      $('#delBoard').on('show.bs.modal', function (event) {
        var link = $(event.relatedTarget) // Button that triggered the modal
        var recipient = link.data('whatever') // Extract info from data-* attributes
        var modal = $(this)
        modal.find('.modal-body input').val(recipient)
        modal.find('.modal-body .modal-message').text('Are you sure you want to delete ' + recipient + '?')		   
      })           
    </script>	



	
    <!-- SERVER -->
    <div class="modal fade" id="editServer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
		
		<form class="user" action="?p=4" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Server</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
              <div class="form-group server_name">
                <!--<label for="server_name" class="col-form-label">server_name:</label>-->
                <input type="text" class="form-control" id="server_name" name="server_name" hidden>
              </div>
              <div class="form-group server_desc">
                <label for="server_desc" class="col-form-label">server_desc:</label>
                <textarea class="form-control" id="server_desc" name="server_desc"></textarea>
              </div>
              <div class="form-group server_ip">
                <label for="server_ip" class="col-form-label">server_ip:</label>
                <input class="form-control" id="server_ip" name="server_ip"></input>
              </div>
              <div class="form-group server_location">
                <label for="server_location" class="col-form-label">server_location:</label>
                <input class="form-control" id="server_location" name="server_location"></input>
              </div>
              <div class="form-group server_timezone">
                <label for="server_timezone">server_timezone:</label>
                <select id="server_timezone" class="form-control" name="server_timezone" > 				  
					<option class="default_server_timezone" selected ></option>
					<option>Asia/Manila</option>
					<option>Asia/Riyadh</option>				  
                </select>
              </div>
              <div class="form-group htdocs_dir">
                <label for="htdocs_dir" class="col-form-label">htdocs_dir:</label>
                <input class="form-control" id="htdocs_dir" name="htdocs_dir" ></input>
              </div>
			  
              <div class="form-group exe_dir">
                <label for="exe_dir" class="col-form-label">exe_dir:</label>
                <input class="form-control" id="exe_dir" name="exe_dir" ></input>
              </div>
			  
              <div class="form-group refresh_sec">
                <label for="refresh_sec" class="col-form-label">refresh_sec:</label>
                <input class="form-control" id="refresh_sec" name="refresh_sec"  ></input>
              </div>			  
   
              <div class="form-group active">
                <label for="active">Activate:</label>
                <select id="active" class="form-control" name="active" > 				  
					<option class="default_active" selected ></option>
					<option>0</option>
					<option>1</option>				  
                </select>
              </div>
 </div>
			  
              </br>
              </br>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="edit_server" >Submit</button>
              </div>
            </form>
         
        </div>
      </div>
    </div>
    <script type="text/javascript">
      $('#editServer').on('show.bs.modal', function (event) {
        var link = $(event.relatedTarget) // Button that triggered the modal
        var server_name = link.data('server_name') // Extract info from data-* attributes
        var server_desc = link.data('server_desc') // Extract info from data-* attributes
        var server_ip = link.data('server_ip') // Extract info from data-* attributes
        var server_location = link.data('server_location') // Extract info from data-* attributes
        var server_timezone = link.data('server_timezone') // Extract info from data-* attributes
        var htdocs_dir = link.data('htdocs_dir') // Extract info from data-* attributes
        var exe_dir = link.data('exe_dir') // Extract info from data-* attributes
        var refresh_sec = link.data('refresh_sec') // Extract info from data-* attributes      
        var active = link.data('active') // Extract info from data-* attributes      
		var modal = $(this)      
        modal.find('.modal-title').text('Edit Server ' + server_name)
        modal.find('.modal-body .server_name input').val(server_name)
        modal.find('.modal-body .server_desc textarea').val(server_desc)
        modal.find('.modal-body .server_ip input').val(server_ip)
        modal.find('.modal-body .server_location input').val(server_location)
        modal.find('.modal-body .server_timezone .default_server_timezone').text(server_timezone)
        modal.find('.modal-body .htdocs_dir input').val(htdocs_dir)
        modal.find('.modal-body .exe_dir input').val(exe_dir)
        modal.find('.modal-body .refresh_sec input').val(refresh_sec)
        modal.find('.modal-body .active .default_active').text(active)
      })           
    </script>
	
    <!-- EDIT BOARD -->
    <div class="modal fade" id="editBoard" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
		<form class="user" action="?p=4" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Board</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
              <div class="form-group board_name">
                <!--<label for="recipient-name" class="col-form-label">board_name:</label>-->                                                
                <input type="text" class="form-control" id="board_name" name="board_name" hidden>
              </div>
              <div class="form-group board_desc">
                <label for="message-text" class="col-form-label">board_desc:</label>
                <textarea class="form-control" id="board_desc" name="board_desc" ></textarea>
              </div>             
              <div class="form-group server_name">
                <label for="inputState">server_name:</label>
                <select id="inputState" class="form-control" name="server_name">				
				<option class="default-server-name" selected ></option>
				<?php
echo $server_list_option;
?>
                </select>
              </div>
			  
              <div class="form-group com_port">
                <label for="com_port" class="col-form-label">com_port:</label>
                <input type="text" class="form-control" id="com_port" name="com_port" >
              </div>				  
			  
              <div class="form-group refresh_sec">
                <label for="refresh_sec" class="col-form-label">refresh_sec:</label>
                <input class="form-control" id="refresh_sec" name="refresh_sec"  ></input>
              </div>
			  
              <div class="form-group board_type">
                <label for="inputState">board_type:</label>
                <select id="inputState" class="form-control" name="board_type">				
					<option class="default_board_type" selected ></option>
					<option>uno</option>
					<option>mega</option>
                </select>
              </div>	
				</br>
				</br>
              
            
          </div>
		  <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="edit_board" >Submit</button>
              </div>
		  </form>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      $('#editBoard').on('show.bs.modal', function (event) {
        var link = $(event.relatedTarget) // Button that triggered the modal
        var board_name = link.data('board_name') // Extract info from data-* attributes
        var board_desc = link.data('board_desc') // Extract info from data-* attributes
        var server_name = link.data('server_name') // Extract info from data-* attributes
        var board_type = link.data('board_type') // Extract info from data-* attributes  
        var com_port = link.data('com_port') // Extract info from data-* attributes  
        var refresh_sec = link.data('refresh_sec') // Extract info from data-* attributes  
      var modal = $(this)      
        modal.find('.modal-title').text('Edit board ' + board_name)        
        modal.find('.modal-body .board_name input').val(board_name)
        modal.find('.modal-body .com_port input').val(com_port)
        modal.find('.modal-body .refresh_sec input').val(refresh_sec)
        modal.find('.modal-body .board_desc textarea').val(board_desc)      	
        modal.find('.modal-body .server_name .default-server-name').text(server_name)      
        modal.find('.modal-body .board_type .default_board_type').text(board_type)        
      })           
    </script>
	

	
    <!-- EDIT BOARD -->
    <div class="modal fade" id="editSettings" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          
		  
		  <form class="user" action="?p=4" method="post">
		  <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Settings</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
            			  
              <div class="form-group ">
                <label for="ipaddress" class="col-form-label">user_ipaddress:</label>
                <input type="text" class="form-control" id="ipaddress" value="<?php echo $ipaddress; ?>" disabled>
              </div>				  

              <div class="form-group ">
                <label for="ipaddress" class="col-form-label">server_ipaddress:</label>
                <input type="text" class="form-control" id="ipaddress" value="<?php echo $ip_server; ?>" disabled>
              </div>	
			  
			  <!--
              <div class="form-group">
                <label for="server_refresh_sec" class="col-form-label">server_refresh_sec:</label>
                <input class="form-control" id="server_refresh_sec" name="server_refresh_sec" value="<?php echo $server_refresh_sec; ?>" ></input>
              </div>-->			  

              <div class="form-group">
                <label for="mobile_number" class="col-form-label">mobile_number:</label>
                <input class="form-control" id="mobile_number" name="mobile_number" value="<?php echo $mobile_number; ?>" ></input>
              </div>	
  </div>
            	
				</br>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="edit_settings" >Submit</button>
              </div>
            </form>
        
        </div>
      </div>
    </div>
   
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

    <!-- EDIT PIN -->
    <div class="modal fade" id="editPin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
		<form class="user" action="?p=4" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Pin</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
			
              <div class="form-group idd">
                <!--<label for="recipient-name" class="col-form-label">id:</label>-->                                                
                <input type="text" class="form-control" id="idd" name="id" hidden >
              </div>			
			
			
              <div class="form-group pin_name">
                <label for="recipient-name" class="col-form-label">pin_name:</label>                                                
                <input type="text" class="form-control" id="pin_name" name="pin_name" >
              </div>
			  
              <div class="form-group pin_num">
                <!--<label for="recipient-name" class="col-form-label">board_name:</label>-->                                                
                <input type="text" class="form-control" id="pin_num" name="pin_num" hidden>
              </div>			  
			  
              <div class="form-group pin_desc">
                <label for="message-text" class="col-form-label">pin_desc:</label>
                <textarea class="form-control" id="pin_desc" name="pin_desc" ></textarea>
              </div> 
			  </div>
         				</br>
				</br>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="edit_pin" >Submit</button>
              </div>
            </form>
          
        </div>
      </div>
    </div>

    <script type="text/javascript">
      $('#editPin').on('show.bs.modal', function (event) {
        var link = $(event.relatedTarget) // Button that triggered the modal
        var id = link.data('id') // Extract info from data-* attributes
        var pin_name = link.data('pin_name') // Extract info from data-* attributes
        var pin_desc = link.data('pin_desc') // Extract info from data-* attributes
        var pin_num = link.data('pin_num') // Extract info from data-* attributes
        var board_name = link.data('board_name') // Extract info from data-* attributes  
        //var active = link.data('active') // Extract info from data-* attributes  
      var modal = $(this)      
        modal.find('.modal-title').text('Edit Pin # ' + pin_num + " ( " + pin_name + " )")        
        modal.find('.modal-body .pin_name input').val(pin_name)
        modal.find('.modal-body .pin_desc textarea').val(pin_desc)      	
        modal.find('.modal-body .pin_num input').val(pin_num)      	
        modal.find('.modal-body .idd input').val(id)      	
        modal.find('.modal-body .board_name input').val(board_name)      	
        //modal.find('.modal-body .active .default_active').text(active)      	
       
      })           
    </script>
	
    <!-- SERVER -->
    <div class="modal fade" id="addServer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          
		  <form class="user" action="?p=4" method="post">
		  <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Server</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
              <div class="form-group">
                <label for="server_name" class="col-form-label">server_name:</label>
                <input type="text" class="form-control" id="server_name" name="server_name"  value="<?php echo generate_string(); ?>" >
              </div>
              <div class="form-group">
                <label for="server_desc" class="col-form-label">server_desc:</label>
                <textarea class="form-control" id="server_desc" name="server_desc"></textarea>
              </div>
              <div class="form-group">
                <label for="server_ip" class="col-form-label">server_ip:</label>
                <input class="form-control" id="server_ip" name="server_ip" value="127.0.0.1" ></input>
              </div>
              <div class="form-group">
                <label for="server_location" class="col-form-label">server_location:</label>
                <input class="form-control" id="server_location" name="server_location" value="default_location" ></input>
              </div>
              <div class="form-group">
                <label for="server_timezone">server_timezone:</label>
                <select id="server_timezone" class="form-control" name="server_timezone" >                  
				  <option value="Asia/Manila">Asia/Manila</option>
                  <option value="Asia/Riyadh">Asia/Riyadh</option>
                </select>
              </div>
              <div class="form-group">
                <label for="htdocs_dir" class="col-form-label">htdocs_dir:</label>
                <input class="form-control" id="htdocs_dir" name="htdocs_dir" value="C:\xampp\htdocs"></input>
              </div>
              <div class="form-group">
                <label for="exe_dir" class="col-form-label">exe_dir:</label>
                <input class="form-control" id="exe_dir" name="exe_dir"  value="C:\xampp\htdocs\portty-dashboard\exe"></input>
              </div>

              <div class="form-group">
                <label for="refresh_sec" class="col-form-label">refresh_sec:</label>
                <input class="form-control" id="refresh_sec" name="refresh_sec"  value="3"></input>
              </div>
             </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="submit_server" >Submit</button>
              </div>
            </form>
          
        </div>
      </div>
    </div>
    <!-- BOARD -->
    <div class="modal fade" id="addBoard" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          
		  
		   <form class="user" action="?p=4" method="post">
		  <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Board</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
           
              <div class="form-group">
                <label for="board_name" class="col-form-label">board_name:</label>                        
                <!--<input type="text" class="form-control" id="recipient-name">-->
                <input type="text" class="form-control" id="board_name" name="board_name" value="<?php echo generate_string(); ?>" >
              </div>
              <div class="form-group">
                <label for="board_desc" class="col-form-label">board_desc:</label>
                <textarea class="form-control" id="board_desc" name="board_desc" ></textarea>
              </div>            
              <div class="form-group">
                <label for="inputState">server_name:</label>
                <select id="inputState" class="form-control" name="server_name"  >				
				<?php
echo $server_list_option;
?>
                </select>
              </div>

              <div class="form-group">
                <label for="com_port" class="col-form-label">com_port:</label>
                <input type="text" class="form-control" id="com_port" name="com_port" value="com10" >
              </div>			  
            
              <fieldset class="form-group">
                <legend class="col-form-legend col-sm-2"></legend>
                <label for="inputState">board_type:</label>
                <div class="col-sm-10">
                  <div class="form-check">
                    <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="board_type" id="board_type" value="uno" checked> Uno
                    </label>
                  </div>
                  <div class="form-check">
                    <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="board_type" id="board_type" value="mega"> Mega
                    </label>
                  </div>
                </div>
              </fieldset>
			  
              <div class="form-group">
                <label for="refresh_sec" class="col-form-label">refresh_sec:</label>
                <input class="form-control" id="refresh_sec" name="refresh_sec"  value="3"></input>
              </div>
			  
			  </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="submit_board" >Submit</button>
              </div>
            </form>
          
        </div>
      </div>
    </div>
    <script>
		$(document).ready(function() {
			$('table.display').DataTable( {
				stateSave: true
			} );
		} );
    </script>


  <script>
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "b55b025e438fa8a98e32482b5f768ff5"]; //real-time feed random math function
    function realTimeFeed(callback) {
      var tick = {};
      tick.plot0 = parseInt(10 + 90 * Math.random(), 10);
      tick.plot1 = parseInt(10 + 90 * Math.random(), 10);
      callback(JSON.stringify(tick));
    };
 
    // define top level feed control functions
    function clearGraph() {
      zingchart.exec('myChart', 'clearfeed')
    }
 
    function startGraph() {
      zingchart.exec('myChart', 'startfeed');
    }
 
    function stopGraph() {
      zingchart.exec('myChart', 'stopfeed');
    }
 
    function randomizeInterval() {
      let interval = Math.floor(Math.random() * (1000 - 50)) + 50;
      zingchart.exec('myChart', 'setinterval', {
        interval: interval,
        update: false
      });
	  
      output.textContent = 'Interval set to: ' + interval;
    }
    // window:load event for Javascript to run after HTML
    // because this Javascript is injected into the document head
    window.addEventListener('load', () => {
      // Javascript code to execute after DOM content
 
      //clear start stop click events
      document.getElementById('clear').addEventListener('click', clearGraph);
      document.getElementById('start').addEventListener('click', startGraph);
      document.getElementById('stop').addEventListener('click', stopGraph);
      //document.getElementById('random').addEventListener('click', randomizeInterval);
 
      // full ZingChart schema can be found here:
      // https://www.zingchart.com/docs/api/json-configuration/
      const myConfig = {
        //chart styling
        type: 'line',
		
      noData: {
        text: "Currently there is no data",
        //backgroundColor: "#20b2db",
        fontSize: 18,
        textAlpha: .9,
        alpha: .6,
        bold: true
      },		
		
		
"scale-x":{
  "transform":{
    "type":"date"
    //"all":"%h:%i:%q %A"
    //"all":"%d %M</br>%h:%i:%q %A"
	//"all":"%m/%d/%Y&lt;br&gt;%H:%i:%q"
	//"all": "%m/%d/%Y %H:%i"
  }
},		
		
		
		
		
		
	legend: {
		"align":"center",
		"vertical-align":"bottom"

  },	
    
	  
		
        globals: {
          fontFamily: 'Roboto',
        },
        /*backgroundColor: '#fff',
        title: {
          backgroundColor: '#1565C0',
          text: 'Temp (°C)| Hum (%)',
          color: '#fff',
          height: '30x'
        },*/
		
		
        plotarea: {
          //marginTop: '80px',
		  'adjust-layout': true /* For automatic margin adjustment. */
			//'margin-left': "dynamic",
			//'margin-bottom': "dynamic"	  
		  
        },
		
  
		utc: true, /* Force UTC time. */

 	
/*		
plot: {
    animation: {
        effect: "ANIMATION_FADE_IN"
    }
},
*/		
		
		
		
		
		
		
		
		
		
		
		
        crosshairX: {
          lineWidth: 4,
          lineStyle: 'dashed',
          lineColor: '#424242',
          marker: {
            visible: true,
            size: 9
          },
          plotLabel: {
            backgroundColor: '#fff',
            borderColor: '#e3e3e3',
            borderRadius: 5,
            padding: 15,
            fontSize: 15,
            shadow: true,
            shadowAlpha: 0.2,
            shadowBlur: 5,
            shadowDistance: 4
          },
          scaleLabel: {
            backgroundColor: '#424242',
            padding: 5
          }
        },
		
		
        scaleY: {
          guide: {
            visible: true,
			//label: { text: 'Temperature (°C)' }
          },
        },
		
	
		
        tooltip: {
          visible: false
        },
        //real-time feed
        refresh: {
          type: 'feed',
          transport: 'http',
          //url: 'https://us-central1-zingchart-com.cloudfunctions.net/public_http_feed?min=0&max=40&plots=1',
          url:'?p=16',
		  interval: 1000,
          maxTicks: 16,
          adjustScale: false,
          resetTimeout: 100
        },
        plot: {
          shadow: 1,
          shadowColor: '#eee',
          shadowDistance: '10px',
          lineWidth: 5,
          hoverState: {
            visible: false
          },
          marker: {
            visible: true
          },
          aspect: 'spline'
        },
		
		
        series: [{
          values: [],
          lineColor: '#2196F3',
          text: 'Temperature',
		  'legend-text': "Temperature"
        }, {
          values: [],
          lineColor: '#ff9800',
          text: 'Humidity',
		  'legend-text': "Humidity"
        }]
      };
 
      // render chart with width and height to
      // fill the parent container CSS dimensions
      zingchart.render({
        id: 'myChart',
        data: myConfig,
        height: '100%',
        width: '100%',
      });
    });
  </script>








	
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <!-- Page level plugins -->
    <!--<script src="vendor/chart.js/Chart.min.js"></script>-->
    <!-- Page level custom scripts -->
    <!--<script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-area-demo2.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>-->
    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <!--<script src="js/demo/datatables-demo.js"></script>-->
    <?php mysqli_close($conn); ?>
  </body>
</html>
