<?php
	include ("session.php");
	include ("dbconnect.php");
	include ("functions.php");	

	if(isset($_GET['msg'])){
		$msg = $_GET['msg'];
	} else {
		$msg = "<div class='small mb-3 text-muted'>Enter the new password twice and press Set New Password Button</div>";
	}
	
	
	if(isset($_POST['submit'])) {
		
		$pass0 = $_POST['pass0'];
		$pass1 = $_POST['pass1'];
		
		
		if($pass0 == "" || $pass1 == ""){
			//header("location: ?p=8&msg=set-pass-failed-empty-data");
			exit();	
		} else if($pass0 != $pass1) {
			//header("location: ?p=4&msg=new-server-added-success");
			exit();	
		} else if($pass0 == $pass1 && ($pass0 != "" || $pass1 != "")) {
			
			
			$email;
			
			
			//$config = include 'config';				
			//$config['pass']= md5($pass1);
			$pass_hashed = md5($pass0);			
			//file_put_contents('config', '<?php return ' . var_export($config, true) . ';');				

				 $sql = "UPDATE tbl_users  SET " .                  
						" pass = '$pass_hashed' " .
						"WHERE email = '$email' ";                
						
					  
					  if ($conn->query($sql) === true) {
						header("location: ?p=4&msg=password-update-successful");
						exit();					  
					  } else {
						header("location: ?p=4&msg=password-update-error");
						exit();				  
					  }	

		}
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
                                        <h1 class="h4 text-gray-900 mb-2">Set Your Password?</h1>
                                        <p class="mb-4"><?php echo $msg; ?></p>
                                    </div>
                                    <form class="user" action="?p=8" method="post">
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="inputPass0" aria-describedby="emailHelp"
                                                placeholder="Enter new password..." name="pass0">
                                            <input type="password" class="form-control form-control-user"
                                                id="inputPass1" aria-describedby="emailHelp"
                                                placeholder="Repeat new password..." name="pass1">											
                                        </div>
                                        <!--<a href="?p=1" class="btn btn-primary btn-user btn-block">
                                            Set Password
                                        </a>-->
										<button type="submit" class="btn btn-primary btn-user btn-block" name="submit" >Set Password</button>
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