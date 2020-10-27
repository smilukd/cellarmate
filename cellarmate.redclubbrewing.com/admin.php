
<?php
/* enable this once the site is passing post data, for now its commented out so it works
	if(!isset($_POST['id']))
	{
		//a user not logged in is trying to access this page, send them back to the login page
		header('location: login.php');
	}
	else
	{
		include('scripts/connect.php');
	}
*/
session_start();
include('scripts/connect.php');
//prevent unauthoized access to the page
if($_SESSION['USER']['role'] != "admin")
{
	header('location: login.php');
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cellarmate - Admin</title>
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
		.center{
			text-align: center;
		}
		td {
			vertical-align: middle;
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
                    <li class="sidebar-search"></li>
                        <!-- search section-->
                        
  
                        <!--end search section-->
                    
                    <?php
							include('scripts/navAdmin.html');
						?>
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
                    	Cellarmate Admin Users 
                    </h1>
                </div>
                <!--End Page Header -->
            </div>

            <div class="row">
                <!-- Welcome -->
                <div class="col-lg-12">
                    <div class="alert alert-info">
                        <i class="fa fa-folder-open"></i><b>&nbsp;Hello ! </b>Welcome Back <b>
                        <?php 
							if(isset($_SESSION['USER']))
							{
								echo $_SESSION['USER']['firstName']." ".$_SESSION['USER']['lastName']; 
							}
						?> </b>
 						<!--<i class="fa  fa-pencil"></i>-->
                    </div>
                </div>
                <!--end  Welcome -->
            </div>
            
            
            
            
            
            
            
<!--   only display this once the admin selects a user to edit.-->
           
            <div class="row">
                <div class="col-lg-12">
                    <!--End area chart example -->
                    <!--Simple table example -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Admin Users
                            
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                  <?php
										//get the list of users from the database
										include('scripts/loadusers.php');

									?>                                   	
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!--End simple table example -->

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
			var originalUsername = $('#username').attr('placeholder');
			var username = $('#username').val();
			//check to make sure the username is available.
			if(originalUsername != username)	//check to make sure that the username has actuall changed before checking whether it exists
				{
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
		}
	</script>
</body>

</html>
