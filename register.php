<?php

	$config = include 'config';		
	$pass = $config['pass'];
	
	if(isset($_GET['msg'])){
		$msg = $_GET['msg'];
	} else {
		$msg = "<div class='small mb-3 text-muted'>Enter the new password twice and press Set New Password Button</div>";
	}
	
	
	
	if(isset($_POST['submit'])) {
		
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
		$pass0 = $_POST['pass0'];
		$pass1 = $_POST['pass1'];		
		
		if($pass0 == "" || $pass1 == ""){
			header("location: ?p=2&msg=set-pass-failed-empty-data");
			exit();	
		} else if($pass0 != $pass1) {
			header("location: ?p=2&msg=new password-and-repeat-password-entered-did-not-match");
			exit();	
		} 		
	
		else if($pass0 == $pass1) {		
			$config['pass']= md5($pass1);	
			$config['fname']= $fname;	
			$config['lname']= $lname;	
			$config['email']= $email;	
			file_put_contents('config', '<?php return ' . var_export($config, true) . ';');				
			header("location: ?p=1&msg=new-account-creation-success");
			exit();
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

    <title>SB Admin 2 - Register</title>

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

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Setup New Account!</h1>
                            </div>
                            <form class="user" action="?p=2" method="post">
							
                                        <div class="form-group">
                                                <label><?php echo $msg; ?></label>                                            
                                        </div>								
							
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="First Name" name="fname">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" id="exampleLastName"
                                            placeholder="Last Name" name="lname">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Email Address" name="email">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password" name="pass0" >
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleRepeatPassword" placeholder="Repeat Password" name="pass1" >
                                    </div>
                                </div>
                                <!--<a href="login.html" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </a>-->
								<button type="submit" class="btn btn-primary btn-user btn-block" name="submit" >Set Account</button>
                                
                               
                            </form>
                            <!--<hr>
                            <div class="text-center">
                                <a class="small" href="?p=3">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="?p=1">Already have an account? Login!</a>
                            </div>-->
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