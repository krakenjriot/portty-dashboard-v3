<?php
	include ("session.php");
	include ("dbconnect.php");
	//include ("functions.php");
	
	
	
	
	$config = include 'config';				
	$server_refresh_sec = $config['server_refresh_sec'];
	$ipaddress = $config['ipaddress'];
	
	/*
	if(isset($_GET['msg'])){
		$msg = $_GET['msg'];
	} else {
		$msg = "<div class='small mb-3 text-muted'>Update new configuration settings</div>";
	}
	*/
	
	if(isset($_POST['submit'])) {			
		$ipaddress_post = $_POST['ipaddress'];		
		$server_refresh_sec_post = $_POST['server_refresh_sec'];		
		
		
		$config = include 'config';								
		$config['ipaddress']= $ipaddress_post;				
		$config['server_refresh_sec'] = $server_refresh_sec_post;			
		file_put_contents('config', '<?php return ' . var_export($config, true) . ';');		
		//echo "dddd ".$server_refresh_sec_post;	




		//check if this ip is default machine
		//updat default and non-default
		$sql = "UPDATE tbl_servers SET " . 
		" refresh_sec = '$server_refresh_sec_post' " . 
		"WHERE server_ip = '$ipaddress_post' ";
		
		$conn->query($sql);
		
				
		header("location: ?p=4&msg=settings-update-successful&$server_refresh_sec_post");
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

    <title>Set Password</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Settings</h1>
                                        <p class="mb-4"><?php echo $msg; ?></p>
                                    </div>
                                    <form class="user" action="?p=9" method="post">
                                        <div class="form-group">
                                            
											<input type="text" class="form-control form-control-user"
                                                id="server_refresh_sec" aria-describedby="emailHelp"
                                                placeholder="server_refresh_sec..." name="server_refresh_sec" value="<?php echo $server_refresh_sec; ?>">	
												
                                            <input type="text" class="form-control form-control-user"
                                                id="ipaddress" aria-describedby="emailHelp"
                                                placeholder="ip address..." name="ipaddress" value="<?php echo $ipaddress; ?>">											
                                        </div>
                                        <!--<a href="?p=1" class="btn btn-primary btn-user btn-block">
                                            Set Password
                                        </a>-->
										<button type="submit" class="btn btn-primary btn-user btn-block" name="submit" >Update Settings</button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="?p=4">Return Home</a>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>