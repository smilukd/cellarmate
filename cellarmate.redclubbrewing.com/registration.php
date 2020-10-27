
<?php

session_start();
include('scripts/connect.php');

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cellarmate - Registration</title>
<!--    Bootstrap templace courtesy of Bootsrtap Free Admin Template - SIMINTA | Admin Dashboad Template -->
    <!-- Core CSS - Include with every page -->
    <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/main-style.css" rel="stylesheet" />
    <!-- Page-Level CSS -->
    <link href="assets/plugins/morris/morris-0.4.3.min.css" rel="stylesheet" />
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
		form input{
			margin-bottom: 2%;
		}
	
	</style>
    
    
   </head>
<body>
    <!--  wrapper -->
    <div id="wrapper">
        <!-- navbar top -->
        <?php
			include('scripts/topnav.php');
		?>
        <!-- end navbar top -->

        <!-- navbar side -->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <!-- sidebar-collapse -->
            <div class="sidebar-collapse">
                <!-- side-menu -->
                <ul class="nav" id="side-menu">
                    <li>
                        <!-- user image section-->
                        <?php
							include('scripts/userimagesection.php');
						?>
                        <!--end user image section-->
                    </li>
                    <li class="sidebar-search">
                        <!-- search section-->
                        
  
                        <!--end search section-->
                    </li>
                    
                </ul>
                <!-- end side-menu -->
            </div>
            <!-- end sidebar-collapse -->
        </nav>
        <!-- end navbar side -->
        <!--  page-wrapper -->
        <div id="page-wrapper">

            <div class="row">
                <!-- Page Header -->
                <div class="col-lg-12">
                    <h1 class="page-header">
                    	Cellarmate Beer Inventory System
                    </h1>
                </div>
                <!--End Page Header -->
            </div>

            <div class="row">
                <!-- Welcome -->
                <div class="col-lg-12">
                    <div class="alert alert-info">
                        <i class="fa fa-folder-open"></i><b>Welcome to Cellarmate!</b>
 						<!--<i class="fa  fa-pencil"></i>-->
                    </div>
                </div>
                <!--end  Welcome -->
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <!--End area chart example -->
                    <!--Simple table example -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                        	<h3>Create an Account</h3>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                   <h2>New User Registration</h2>
                                   	<div class="col-lg-6">
										<form action="scripts/register.php" method="post" enctype="multipart/form-data">
											<input class="form-control" id="firstName" type="text" name="firstName" placeholder="First Name" required> 
											<input class="form-control" id="lastName" type="text" name="lastName" placeholder="Last Name" required> 
											<input class="form-control" id="email" type="text" name="email" placeholder="Email Address" required> 
											<input class="form-control" id="emailVer" type="text" name="emailVer" placeholder="Retype Email Address" onfocusout="checkEmail()" required>
											<div class="red" id="noEMatch"></div>
											<input class="form-control" id="location" type="text" name="location" placeholder="Location (optional)">
											<input class="form-control" id="cellarName" type="text" name="cellarName" placeholder="Cellar Name" required>
											<span class="row">
												<span>Make cellar visible to others users?</span>
												<label>Yes </label><input id="publicYes" type="radio" name="public" value="yes" required>
												<label>No </label><input id="publicNo" type="radio" name="public" value="no" checked>
											</span>
						<!--					check that the username does not exist before registration-->
											<input class="form-control" id="username" type="text" name="username" placeholder="Desired User Name" onfocusout="checkUser()" onKeyDown="$('#userCheck').val("")"> <label class="userResult" id="userCheck"></label>
											<input class="form-control" id="password" type="password" name="password" placeholder="Password" required> 
											<input class="form-control" id="passwordVer" type="password" name="passwordVer" placeholder="Retype Password" onfocusout="checkPass()" required>
											<div class="red" id="noPWMatch"></div>
											<br><br>
											<label>Upload a profile picture <input type="file" name="file" id="file"></label>
											<br>
											<br>
											<button class="btn btn-success" type="submit" name="submitRegistration">Register</button>

										</form>
                               		</div>
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!--End simple table example -->

                </div>

                <div class="col-lg-4">
                    <?php
						include('scripts/allcellarcount.php');
					?>

                </div>

            </div>

        </div>
        <!-- end page-wrapper -->

    </div>
    <!-- end wrapper -->

    <!-- Core Scripts - Include with every page -->

    <script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="assets/plugins/pace/pace.js"></script>
    <script src="assets/scripts/siminta.js"></script>
    <!-- Page-Level Plugin Scripts-->
    <script src="assets/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/plugins/morris/morris.js"></script>
    <script src="assets/scripts/dashboard-demo.js"></script>
<!--    <script src="assets/plugins/jquery-1.10.2.js"></script>-->
	<script>
		function checkUser()
		{
			var username = $('#username').val();
			//check to make sure the username is available.
			$.ajax({
					type: "POST",
					url: "scripts/usercheck.php",
					data: {user: username},
					cache: false,					
					success: function(html)
					{
						var currentUserName = $('#username').val();
												
						$("#userCheck").html(html);
						
						var result = $('#userCheck').html();
						
						//username exists, have user input a new one
						if(!result.includes("OK"))
						{
							
							$('#username').val("");
							/*$("#userCheck").removeClass("green");
							$("#userCheck").addClass("red");*/
							//$("#userCheck").html(currentUserName + " already exists, choose another" );
						}
						else
							{
								//$("#userCheck").removeClass("red");
								//$("#userCheck").addClass("green");
								$("#userCheck").html(html);
							}
						
					}
				});
		}
		
		function checkPass(){
			
			//check to see if the passwords match
			var pass1 = $('#password').val();
			var pass2 = $('#passwordVer').val();
			
			if(pass1 != pass2)
			{
				//passwords do not match
				$('#passwordVer').val("");
				$('#noPWMatch').html("Passwords do not match!");
			}
			else
			{
				$('#noPWMatch').html("");
			}
		}
		
		function checkEmail()
		{
			var email1 = $('#email').val();
			var email2 = $('#emailVer').val();
			
			if(email1 != email2)
			{
				//emails do not match
				$('#emailVer').val("");
				$('#noEMatch').html("Emails do not match!");
			}
			else
			{
				$('#noEMatch').html("");
			}
		}
	</script>
</body>

</html>
